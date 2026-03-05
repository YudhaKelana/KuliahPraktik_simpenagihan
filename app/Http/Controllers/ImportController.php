<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Services\ImportService;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        $hasPhpSpreadsheet = class_exists(\PhpOffice\PhpSpreadsheet\Spreadsheet::class);
        return view('import.index', compact('hasPhpSpreadsheet'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimetypes:text/csv,text/plain,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:10240',
            'type' => 'required|in:arrears,tasks,followups,vehicle_statuses,taxpayers,vehicles',
        ]);

        $file = $request->file('file');
        $type = $request->input('type');

        $service = new ImportService();
        $result = $service->import($file, $type);

        AuditTrail::log('import', null, null, [
            'type' => $type,
            'filename' => $file->getClientOriginalName(),
            'result' => $result,
        ], "Import {$type}: {$result['created']} created, {$result['updated']} updated, {$result['skipped']} skipped, " . count($result['errors']) . " errors");

        return view('import.result', compact('result', 'type'));
    }

    public function downloadTemplate(string $type, Request $request)
    {
        $format = $request->query('format', 'csv');

        $labels = [
            'arrears' => 'Tunggakan',
            'tasks' => 'Tugas',
            'followups' => 'Follow-up',
            'vehicle_statuses' => 'Status Kendaraan',
            'taxpayers' => 'Wajib Pajak',
            'vehicles' => 'Kendaraan',
        ];

        if (!isset($labels[$type])) {
            abort(404);
        }

        // --- XLSX format (requires PhpSpreadsheet) ---
        if ($format === 'xlsx' && class_exists(\PhpOffice\PhpSpreadsheet\Spreadsheet::class)) {
            return $this->downloadXlsxTemplate($type, $labels[$type]);
        }

        // --- CSV format (always available) ---
        $csvTemplates = [
            'arrears' => 'templates/template_tunggakan.csv',
            'tasks' => 'templates/template_tugas.csv',
            'followups' => 'templates/template_followup.csv',
            'vehicle_statuses' => 'templates/template_status_kendaraan.csv',
            'taxpayers' => 'templates/template_wajib_pajak.csv',
            'vehicles' => 'templates/template_kendaraan.csv',
        ];

        $path = storage_path('app/' . $csvTemplates[$type]);
        if (!file_exists($path)) {
            abort(404, 'Template belum tersedia.');
        }

        return response()->download($path, "template_{$type}.csv");
    }

    private function downloadXlsxTemplate(string $type, string $label)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($label);

        $templates = $this->getTemplateData();
        $data = $templates[$type];

        // Write headers (row 1) with styling
        foreach ($data['headers'] as $col => $header) {
            $cell = $sheet->setCellValue([$col + 1, 1], $header);
            $sheet->getColumnDimensionByColumn($col + 1)->setAutoSize(true);
        }

        // Style header row
        $headerRange = 'A1:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($data['headers'])) . '1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ]);

        // Write sample data rows
        foreach ($data['sample'] as $rowIndex => $row) {
            foreach ($row as $col => $value) {
                $sheet->setCellValue([$col + 1, $rowIndex + 2], $value);
            }
        }

        // Style data rows borders
        if (!empty($data['sample'])) {
            $lastRow = count($data['sample']) + 1;
            $dataRange = 'A2:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($data['headers'])) . $lastRow;
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
            ]);
        }

        // Output
        $filename = "template_{$type}.xlsx";
        $tempPath = tempnam(sys_get_temp_dir(), 'tpl_') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempPath);
        $spreadsheet->disconnectWorksheets();

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }

    private function getTemplateData(): array
    {
        return [
            'arrears' => [
                'headers' => ['nopol', 'no_registrasi', 'nama_pemilik', 'hp', 'alamat', 'kecamatan', 'kelurahan', 'kode_pos', 'nominal_tunggakan', 'lama_tunggakan', 'tanggal_kalkulasi', 'jenis_kendaraan', 'merek', 'tahun', 'catatan'],
                'sample' => [
                    ['BP 1234 AB', '1234567890', 'Budi Santoso', '081234567890', 'Jl. Merdeka No. 10', 'Tanjungpinang Timur', 'Kamboja', '29124', 1500000, 2, '2025-01-15', 'Sedan', 'Toyota Vios', 2018, 'Tunggakan PKB 2 tahun'],
                    ['BP 5678 CD', '9876543210', 'Siti Aminah', '081298765432', 'Jl. DI Panjaitan No. 5', 'Bukit Bestari', 'Tanjungpinang', '29125', 750000, 1, '2025-01-15', 'Sepeda Motor', 'Honda Beat', 2020, ''],
                ],
            ],
            'tasks' => [
                'headers' => ['nopol', 'pegawai', 'status', 'tanggal_tugas', 'catatan'],
                'sample' => [
                    ['BP 1234 AB', 'Budi Santoso', 'new', '2025-02-01', 'Tugas penagihan rutin'],
                    ['BP 5678 CD', 'Siti Aminah', 'new', '2025-02-01', 'Kunjungan lapangan'],
                ],
            ],
            'followups' => [
                'headers' => ['nopol', 'jenis', 'tanggal', 'catatan', 'hasil'],
                'sample' => [
                    ['BP 1234 AB', 'telepon', '2025-02-05', 'Menghubungi WP via telepon', 'Berjanji bayar minggu depan'],
                    ['BP 5678 CD', 'kunjungan', '2025-02-06', 'Kunjungan ke alamat WP', 'WP tidak di tempat'],
                ],
            ],
            'vehicle_statuses' => [
                'headers' => ['nopol', 'status_kendaraan', 'tanggal', 'catatan'],
                'sample' => [
                    ['BP 1234 AB', 'ada_di_lokasi', '2025-02-10', 'Kendaraan ditemukan di alamat WP'],
                    ['BP 5678 CD', 'tidak_ditemukan', '2025-02-10', 'Kendaraan tidak ada di lokasi'],
                ],
            ],
            'taxpayers' => [
                'headers' => ['nama', 'nik', 'hp', 'alamat', 'kecamatan', 'kelurahan', 'kode_pos'],
                'sample' => [
                    ['Budi Santoso', '1234567890123456', '081234567890', 'Jl. Merdeka No. 10', 'Tanjungpinang Timur', 'Kamboja', '29124'],
                    ['Siti Aminah', '6543210987654321', '081298765432', 'Jl. DI Panjaitan No. 5', 'Bukit Bestari', 'Tanjungpinang', '29125'],
                ],
            ],
            'vehicles' => [
                'headers' => ['nopol', 'nama_wp', 'hp', 'no_registrasi', 'jenis_kendaraan', 'merek', 'tahun', 'jatuh_tempo', 'catatan'],
                'sample' => [
                    ['BP 1234 AB', 'Budi Santoso', '081234567890', '1234567890', 'Sedan', 'Toyota Vios', 2018, '2025-06-15', ''],
                    ['BP 5678 CD', 'Siti Aminah', '081298765432', '9876543210', 'Sepeda Motor', 'Honda Beat', 2020, '2025-07-20', ''],
                ],
            ],
        ];
    }
}
