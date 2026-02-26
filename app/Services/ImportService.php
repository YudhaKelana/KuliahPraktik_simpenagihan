<?php

namespace App\Services;

use App\Models\ArrearsItem;
use App\Models\Employee;
use App\Models\Followup;
use App\Models\Task;
use App\Models\Taxpayer;
use App\Models\Vehicle;
use App\Models\VehicleStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImportService
{
    public function import(UploadedFile $file, string $type): array
    {
        $rows = $this->parseFile($file);

        $result = [
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors' => [],
            'total' => count($rows),
        ];

        if (empty($rows)) {
            $result['errors'][] = ['row' => 0, 'message' => 'File kosong atau format tidak dikenali.'];
            return $result;
        }

        $batchId = Str::uuid()->toString();

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                $rowNum = $index + 2; // +2 karena index 0 + header row
                try {
                    $importResult = match ($type) {
                        'arrears' => $this->importArrears($row, $batchId),
                        'tasks' => $this->importTasks($row),
                        'followups' => $this->importFollowups($row),
                        'vehicle_statuses' => $this->importVehicleStatuses($row),
                        'taxpayers' => $this->importTaxpayers($row),
                        'vehicles' => $this->importVehicles($row),
                        default => throw new \InvalidArgumentException("Tipe import tidak valid: {$type}"),
                    };

                    $result[$importResult]++;
                } catch (\Exception $e) {
                    $result['errors'][] = [
                        'row' => $rowNum,
                        'message' => $e->getMessage(),
                        'data' => array_slice($row, 0, 3),
                    ];
                    $result['skipped']++;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $result['errors'][] = ['row' => 0, 'message' => 'Fatal: ' . $e->getMessage()];
        }

        return $result;
    }

    private function parseFile(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if (in_array($extension, ['csv', 'txt'])) {
            return $this->parseCsv($file->getPathname());
        }

        // For xlsx, we'd need a package like maatwebsite/excel
        // For now, handle CSV only and return empty for xlsx with a note
        return $this->parseCsv($file->getPathname());
    }

    private function parseCsv(string $path): array
    {
        $rows = [];
        $handle = fopen($path, 'r');

        if (!$handle) {
            return $rows;
        }

        // Detect delimiter
        $firstLine = fgets($handle);
        rewind($handle);
        $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';

        $headers = null;
        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            if (!$headers) {
                $headers = array_map(fn($h) => Str::snake(trim(strtolower($h))), $data);
                continue;
            }

            if (count($data) !== count($headers)) {
                continue; // skip malformed rows
            }

            $rows[] = array_combine($headers, array_map('trim', $data));
        }

        fclose($handle);
        return $rows;
    }

    private function importArrears(array $row, string $batchId): string
    {
        $plateNumber = $row['plate_number'] ?? $row['nopol'] ?? $row['no_polisi'] ?? null;
        if (!$plateNumber) {
            throw new \Exception('Kolom plate_number/nopol wajib diisi.');
        }

        $calcDate = $row['calculation_date'] ?? $row['tanggal_kalkulasi'] ?? now()->toDateString();

        $data = [
            'plate_number' => strtoupper(trim($plateNumber)),
            'registration_number' => $row['registration_number'] ?? $row['no_registrasi'] ?? null,
            'owner_name' => $row['owner_name'] ?? $row['nama_pemilik'] ?? null,
            'phone' => $row['phone'] ?? $row['hp'] ?? $row['telepon'] ?? null,
            'address' => $row['address'] ?? $row['alamat'] ?? null,
            'district' => $row['district'] ?? $row['kecamatan'] ?? null,
            'sub_district' => $row['sub_district'] ?? $row['kelurahan'] ?? null,
            'postal_code' => $row['postal_code'] ?? $row['kode_pos'] ?? null,
            'arrears_amount' => (float) ($row['arrears_amount'] ?? $row['nominal_tunggakan'] ?? 0),
            'arrears_years' => (int) ($row['arrears_years'] ?? $row['lama_tunggakan'] ?? 0),
            'calculation_date' => $calcDate,
            'vehicle_type' => $row['vehicle_type'] ?? $row['jenis_kendaraan'] ?? null,
            'vehicle_brand' => $row['vehicle_brand'] ?? $row['merek'] ?? null,
            'vehicle_year' => $row['vehicle_year'] ?? $row['tahun'] ?? null,
            'notes' => $row['notes'] ?? $row['catatan'] ?? null,
            'import_batch' => $batchId,
        ];

        // Data quality flags
        $phone = $data['phone'];
        $data['flag_phone_invalid'] = !empty($phone) && strlen(preg_replace('/\D/', '', $phone)) < config('samsat.min_phone_digits', 8);
        if (empty($phone)) {
            $data['flag_phone_invalid'] = true;
        }

        $addr = $data['address'];
        $data['flag_address_suspect'] = !empty($addr) && strlen($addr) < config('samsat.min_address_length', 10);

        $item = ArrearsItem::updateOrCreate(
            ['plate_number' => $data['plate_number'], 'calculation_date' => $data['calculation_date']],
            $data
        );

        return $item->wasRecentlyCreated ? 'created' : 'updated';
    }

    private function importTasks(array $row): string
    {
        $plateNumber = $row['plate_number'] ?? $row['nopol'] ?? null;
        if (!$plateNumber) {
            throw new \Exception('Kolom plate_number/nopol wajib diisi.');
        }

        $arrears = ArrearsItem::where('plate_number', strtoupper(trim($plateNumber)))->latest()->first();
        if (!$arrears) {
            throw new \Exception("Data tunggakan untuk {$plateNumber} tidak ditemukan.");
        }

        $employeeName = $row['employee'] ?? $row['pegawai'] ?? $row['pic'] ?? null;
        $employee = $employeeName ? Employee::where('name', 'like', "%{$employeeName}%")->first() : null;

        $task = Task::updateOrCreate(
            ['arrears_item_id' => $arrears->id],
            [
                'employee_id' => $employee?->id,
                'status' => $row['status'] ?? 'new',
                'assigned_date' => $row['assigned_date'] ?? $row['tanggal_tugas'] ?? now()->toDateString(),
                'notes' => $row['notes'] ?? $row['catatan'] ?? null,
            ]
        );

        return $task->wasRecentlyCreated ? 'created' : 'updated';
    }

    private function importFollowups(array $row): string
    {
        $plateNumber = $row['plate_number'] ?? $row['nopol'] ?? null;
        if (!$plateNumber) {
            throw new \Exception('Kolom plate_number/nopol wajib diisi.');
        }

        $task = Task::whereHas('arrearsItem', fn($q) => $q->where('plate_number', strtoupper(trim($plateNumber))))->latest()->first();
        if (!$task) {
            throw new \Exception("Tugas untuk {$plateNumber} tidak ditemukan.");
        }

        Followup::create([
            'task_id' => $task->id,
            'employee_id' => $task->employee_id,
            'type' => $row['type'] ?? $row['jenis'] ?? 'telepon',
            'followup_date' => $row['followup_date'] ?? $row['tanggal'] ?? now()->toDateString(),
            'notes' => $row['notes'] ?? $row['catatan'] ?? null,
            'result' => $row['result'] ?? $row['hasil'] ?? null,
        ]);

        if ($task->status === 'new') {
            $task->update(['status' => 'in_progress']);
        }

        return 'created';
    }

    private function importVehicleStatuses(array $row): string
    {
        $plateNumber = $row['plate_number'] ?? $row['nopol'] ?? null;
        if (!$plateNumber) {
            throw new \Exception('Kolom plate_number/nopol wajib diisi.');
        }

        $task = Task::whereHas('arrearsItem', fn($q) => $q->where('plate_number', strtoupper(trim($plateNumber))))->latest()->first();
        if (!$task) {
            throw new \Exception("Tugas untuk {$plateNumber} tidak ditemukan.");
        }

        $status = $row['status'] ?? $row['status_kendaraan'] ?? null;
        if (!$status || !array_key_exists($status, VehicleStatus::STATUSES)) {
            throw new \Exception("Status kendaraan '{$status}' tidak valid.");
        }

        VehicleStatus::create([
            'task_id' => $task->id,
            'status' => $status,
            'status_date' => $row['status_date'] ?? $row['tanggal'] ?? now()->toDateString(),
            'notes' => $row['notes'] ?? $row['catatan'] ?? null,
        ]);

        return 'created';
    }

    private function importTaxpayers(array $row): string
    {
        $name = $row['name'] ?? $row['nama'] ?? null;
        if (!$name) {
            throw new \Exception('Kolom name/nama wajib diisi.');
        }

        $phone = $row['phone'] ?? $row['hp'] ?? $row['phone_e164'] ?? null;
        $nik = $row['nik'] ?? null;

        $data = [
            'name' => $name,
            'phone_e164' => $phone,
            'address' => $row['address'] ?? $row['alamat'] ?? null,
            'district' => $row['district'] ?? $row['kecamatan'] ?? null,
            'sub_district' => $row['sub_district'] ?? $row['kelurahan'] ?? null,
            'postal_code' => $row['postal_code'] ?? $row['kode_pos'] ?? null,
        ];

        // Data quality flags
        $data['flag_phone_invalid'] = empty($phone) || strlen(preg_replace('/\D/', '', $phone)) < config('samsat.min_phone_digits', 8);
        $addr = $data['address'];
        $data['flag_address_suspect'] = !empty($addr) && strlen($addr) < config('samsat.min_address_length', 10);

        $key = $nik ? ['nik' => $nik] : ['name' => $name, 'phone_e164' => $phone];
        $taxpayer = Taxpayer::updateOrCreate($key, $data);

        return $taxpayer->wasRecentlyCreated ? 'created' : 'updated';
    }

    private function importVehicles(array $row): string
    {
        $plateNumber = $row['plate_number'] ?? $row['nopol'] ?? null;
        if (!$plateNumber) {
            throw new \Exception('Kolom plate_number/nopol wajib diisi.');
        }

        // Find the taxpayer
        $taxpayerName = $row['taxpayer_name'] ?? $row['nama_wp'] ?? $row['nama'] ?? null;
        $taxpayerPhone = $row['phone'] ?? $row['hp'] ?? null;

        $taxpayer = null;
        if ($taxpayerName) {
            $taxpayer = Taxpayer::where('name', $taxpayerName)->first();
        }
        if (!$taxpayer && $taxpayerPhone) {
            $taxpayer = Taxpayer::where('phone_e164', $taxpayerPhone)->first();
        }
        if (!$taxpayer) {
            // Auto-create taxpayer
            $taxpayer = Taxpayer::create([
                'name' => $taxpayerName ?? 'Unknown',
                'phone_e164' => $taxpayerPhone,
                'flag_phone_invalid' => empty($taxpayerPhone),
            ]);
        }

        $dueDate = $row['due_date'] ?? $row['jatuh_tempo'] ?? null;

        $vehicle = Vehicle::updateOrCreate(
            ['plate_number' => strtoupper(trim($plateNumber)), 'due_date' => $dueDate],
            [
                'taxpayer_id' => $taxpayer->id,
                'registration_number' => $row['registration_number'] ?? $row['no_registrasi'] ?? null,
                'vehicle_type' => $row['vehicle_type'] ?? $row['jenis_kendaraan'] ?? null,
                'vehicle_brand' => $row['vehicle_brand'] ?? $row['merek'] ?? null,
                'vehicle_year' => $row['vehicle_year'] ?? $row['tahun'] ?? null,
                'notes' => $row['notes'] ?? $row['catatan'] ?? null,
            ]
        );

        return $vehicle->wasRecentlyCreated ? 'created' : 'updated';
    }
}
