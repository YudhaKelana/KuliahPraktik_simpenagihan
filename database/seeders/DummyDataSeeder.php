<?php

namespace Database\Seeders;

use App\Models\ArrearsItem;
use App\Models\Employee;
use App\Models\Followup;
use App\Models\MessageLog;
use App\Models\ReminderBatch;
use App\Models\ReminderItem;
use App\Models\ReminderRule;
use App\Models\Task;
use App\Models\Taxpayer;
use App\Models\Vehicle;
use App\Models\VehicleStatus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // --- Wajib Pajak (Taxpayers) ---
        $taxpayersData = [
            ['name' => 'Ahmad Hidayat', 'nik' => '2171010101800001', 'phone_e164' => '08127012001', 'address' => 'Jl. Merdeka No. 12, Tanjungpinang Barat'],
            ['name' => 'Sari Dewi', 'nik' => '2171020202850002', 'phone_e164' => '08127012002', 'address' => 'Jl. Sultan Mahmud No. 45, Tanjungpinang Timur'],
            ['name' => 'Budi Prasetyo', 'nik' => '2171030303900003', 'phone_e164' => '08127012003', 'address' => 'Jl. Yusuf Kahar No. 8, Bukit Bestari'],
            ['name' => 'Rina Marlina', 'nik' => '2171040404880004', 'phone_e164' => '08127012004', 'address' => 'Jl. Basuki Rahmat No. 33, Tanjungpinang Kota'],
            ['name' => 'Muhammad Reza', 'nik' => '2171050505920005', 'phone_e164' => '08127012005', 'address' => 'Jl. Pos No. 17, Tanjungpinang Barat'],
            ['name' => 'Lilis Suryani', 'nik' => '2171060606870006', 'phone_e164' => '08127012006', 'address' => 'Jl. DI Panjaitan No. 22, Bukit Bestari'],
            ['name' => 'Eko Saputra', 'nik' => '2171070707950007', 'phone_e164' => '08127012007', 'address' => 'Jl. Teuku Umar No. 55, Tanjungpinang Timur'],
            ['name' => 'Nurhayati', 'nik' => '2171080808830008', 'phone_e164' => '08127012008', 'address' => 'Jl. Hang Tuah No. 9, Tanjungpinang Kota'],
            ['name' => 'Irwan Setiawan', 'nik' => '2171090909780009', 'phone_e164' => '08127012009', 'address' => 'Jl. Pramuka No. 14, Bukit Bestari'],
            ['name' => 'Dewi Kusuma', 'nik' => '2171101010860010', 'phone_e164' => '08127012010', 'address' => 'Jl. KH Ahmad Dahlan No. 3, Tanjungpinang Barat'],
            ['name' => 'Hendri Kurniawan', 'nik' => '2171111111910011', 'phone_e164' => '08127012011', 'address' => 'Jl. Gatot Subroto No. 77, Tanjungpinang Timur'],
            ['name' => 'Yuni Astuti', 'nik' => '2171121212840012', 'phone_e164' => '08127012012', 'address' => 'Jl. Kartini No. 29, Tanjungpinang Kota'],
            ['name' => 'Agus Purnomo', 'nik' => '2171131313890013', 'phone_e164' => '08127012013', 'address' => 'Jl. Sudirman No. 5, Bukit Bestari'],
            ['name' => 'Fitriani', 'nik' => '2171141414930014', 'phone_e164' => '08127012014', 'address' => 'Jl. Ahmad Yani No. 61, Tanjungpinang Barat'],
            ['name' => 'Rizal Fahmi', 'nik' => '2171151515870015', 'phone_e164' => '08127012015', 'address' => 'Jl. RA Kartini No. 18, Tanjungpinang Timur'],
            ['name' => 'Wahyu Hidayah', 'nik' => '2171161616960016', 'phone_e164' => '', 'address' => 'Jl. Diponegoro No. 40, Bukit Bestari', 'flag_phone_invalid' => true],
            ['name' => 'Diana Putri', 'nik' => '2171171717800017', 'phone_e164' => '08127012017', 'address' => 'Tanjungpinang', 'opt_out' => true],
            ['name' => 'Arif Rahman', 'nik' => '2171181818850018', 'phone_e164' => '08127012018', 'address' => 'Jl. Hang Jebat No. 7, Tanjungpinang Kota'],
            ['name' => 'Sri Wahyuni', 'nik' => '2171191919900019', 'phone_e164' => '08127012019', 'address' => 'Jl. Engku Putri No. 23, Bukit Bestari'],
            ['name' => 'Bambang Hermawan', 'nik' => '2171202020880020', 'phone_e164' => '08127012020', 'address' => 'Jl. Tugu No. 11, Tanjungpinang Barat'],
        ];

        $taxpayers = collect($taxpayersData)->map(function ($data) {
            return Taxpayer::firstOrCreate(['nik' => $data['nik']], $data);
        });

        // --- Kendaraan (Vehicles) ---
        $vehiclesData = [
            ['plate_number' => 'BP 1234 AB', 'tp' => 0, 'vehicle_brand' => 'Honda Vario 150', 'vehicle_year' => 2020, 'due_date' => now()->addDays(5)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 2345 CD', 'tp' => 1, 'vehicle_brand' => 'Toyota Avanza', 'vehicle_year' => 2019, 'due_date' => now()->addDays(2)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 3456 EF', 'tp' => 2, 'vehicle_brand' => 'Yamaha NMAX', 'vehicle_year' => 2021, 'due_date' => now()->subDays(10)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 4567 GH', 'tp' => 3, 'vehicle_brand' => 'Suzuki Ertiga', 'vehicle_year' => 2018, 'due_date' => now()->subDays(30)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 5678 IJ', 'tp' => 4, 'vehicle_brand' => 'Honda Beat', 'vehicle_year' => 2022, 'due_date' => now()->addDays(15)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 6789 KL', 'tp' => 5, 'vehicle_brand' => 'Daihatsu Xenia', 'vehicle_year' => 2017, 'due_date' => now()->subDays(60)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 7890 MN', 'tp' => 6, 'vehicle_brand' => 'Yamaha Mio', 'vehicle_year' => 2020, 'due_date' => now()->addDays(25)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 8901 OP', 'tp' => 7, 'vehicle_brand' => 'Honda HRV', 'vehicle_year' => 2021, 'due_date' => now()->subDays(5)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 9012 QR', 'tp' => 8, 'vehicle_brand' => 'Kawasaki Ninja', 'vehicle_year' => 2019, 'due_date' => now()->subDays(90)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 1122 ST', 'tp' => 9, 'vehicle_brand' => 'Toyota Rush', 'vehicle_year' => 2022, 'due_date' => now()->addDays(7)->toDateString(), 'status_payment' => 'paid'],
            ['plate_number' => 'BP 2233 UV', 'tp' => 10, 'vehicle_brand' => 'Honda Scoopy', 'vehicle_year' => 2021, 'due_date' => now()->addDays(12)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 3344 WX', 'tp' => 11, 'vehicle_brand' => 'Mitsubishi Xpander', 'vehicle_year' => 2020, 'due_date' => now()->subDays(15)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 4455 YZ', 'tp' => 12, 'vehicle_brand' => 'Honda CB150R', 'vehicle_year' => 2023, 'due_date' => now()->addDays(30)->toDateString(), 'status_payment' => 'paid'],
            ['plate_number' => 'BP 5566 AA', 'tp' => 13, 'vehicle_brand' => 'Suzuki Satria', 'vehicle_year' => 2018, 'due_date' => now()->subDays(45)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 6677 BB', 'tp' => 14, 'vehicle_brand' => 'Toyota Innova', 'vehicle_year' => 2017, 'due_date' => now()->subDays(120)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 7788 CC', 'tp' => 0, 'vehicle_brand' => 'Yamaha R15', 'vehicle_year' => 2022, 'due_date' => now()->addDays(3)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 8899 DD', 'tp' => 15, 'vehicle_brand' => 'Honda PCX', 'vehicle_year' => 2021, 'due_date' => now()->subDays(20)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 9900 EE', 'tp' => 16, 'vehicle_brand' => 'Daihatsu Sigra', 'vehicle_year' => 2020, 'due_date' => now()->addDays(40)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 1010 FF', 'tp' => 17, 'vehicle_brand' => 'Honda CRV', 'vehicle_year' => 2019, 'due_date' => now()->subDays(7)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 2020 GG', 'tp' => 18, 'vehicle_brand' => 'Yamaha Aerox', 'vehicle_year' => 2023, 'due_date' => now()->addDays(20)->toDateString(), 'status_payment' => 'unpaid'],
        ];

        $vehicles = collect($vehiclesData)->map(function ($data) use ($taxpayers) {
            return Vehicle::firstOrCreate(
                ['plate_number' => $data['plate_number'], 'due_date' => $data['due_date']],
                [
                    'taxpayer_id' => $taxpayers[$data['tp']]->id,
                    'vehicle_brand' => $data['vehicle_brand'],
                    'vehicle_year' => $data['vehicle_year'],
                    'status_payment' => $data['status_payment'],
                ]
            );
        });

        // --- Tunggakan (Arrears) ---
        $employees = Employee::where('is_active', true)->get();
        $arrearsData = [
            ['plate' => 'BP 3456 EF', 'owner' => 'Budi Prasetyo', 'phone' => '08127012003', 'amount' => 850000, 'years' => 1, 'brand' => 'Yamaha NMAX', 'year' => 2021],
            ['plate' => 'BP 4567 GH', 'owner' => 'Rina Marlina', 'phone' => '08127012004', 'amount' => 2450000, 'years' => 3, 'brand' => 'Suzuki Ertiga', 'year' => 2018],
            ['plate' => 'BP 6789 KL', 'owner' => 'Lilis Suryani', 'phone' => '08127012006', 'amount' => 4200000, 'years' => 5, 'brand' => 'Daihatsu Xenia', 'year' => 2017],
            ['plate' => 'BP 8901 OP', 'owner' => 'Nurhayati', 'phone' => '08127012008', 'amount' => 350000, 'years' => 1, 'brand' => 'Honda HRV', 'year' => 2021],
            ['plate' => 'BP 9012 QR', 'owner' => 'Irwan Setiawan', 'phone' => '08127012009', 'amount' => 6100000, 'years' => 7, 'brand' => 'Kawasaki Ninja', 'year' => 2019],
            ['plate' => 'BP 3344 WX', 'owner' => 'Yuni Astuti', 'phone' => '08127012012', 'amount' => 1200000, 'years' => 2, 'brand' => 'Mitsubishi Xpander', 'year' => 2020],
            ['plate' => 'BP 5566 AA', 'owner' => 'Fitriani', 'phone' => '08127012014', 'amount' => 3100000, 'years' => 4, 'brand' => 'Suzuki Satria', 'year' => 2018],
            ['plate' => 'BP 6677 BB', 'owner' => 'Rizal Fahmi', 'phone' => '08127012015', 'amount' => 8500000, 'years' => 8, 'brand' => 'Toyota Innova', 'year' => 2017],
            ['plate' => 'BP 8899 DD', 'owner' => 'Wahyu Hidayah', 'phone' => '', 'amount' => 1600000, 'years' => 2, 'brand' => 'Honda PCX', 'year' => 2021, 'flag_phone' => true],
            ['plate' => 'BP 1010 FF', 'owner' => 'Arif Rahman', 'phone' => '08127012018', 'amount' => 500000, 'years' => 1, 'brand' => 'Honda CRV', 'year' => 2019],
            ['plate' => 'BP 1234 AB', 'owner' => 'Ahmad Hidayat', 'phone' => '08127012001', 'amount' => 250000, 'years' => 1, 'brand' => 'Honda Vario 150', 'year' => 2020],
            ['plate' => 'BP 2345 CD', 'owner' => 'Sari Dewi', 'phone' => '08127012002', 'amount' => 180000, 'years' => 1, 'brand' => 'Toyota Avanza', 'year' => 2019],
        ];

        $arrears = collect($arrearsData)->map(function ($data) {
            return ArrearsItem::firstOrCreate(
                ['plate_number' => $data['plate']],
                [
                    'owner_name' => $data['owner'],
                    'phone' => $data['phone'],
                    'address' => 'Tanjungpinang',
                    'arrears_amount' => $data['amount'],
                    'arrears_years' => $data['years'],
                    'vehicle_brand' => $data['brand'],
                    'vehicle_year' => $data['year'],
                    'calculation_date' => now()->subDays(rand(1, 14)),
                    'flag_phone_invalid' => $data['flag_phone'] ?? ($data['phone'] === ''),
                    'flag_address_suspect' => false,
                ]
            );
        });

        // --- Tugas (Tasks) with Follow-ups & Vehicle Statuses ---
        if ($employees->isNotEmpty()) {
            $statuses = ['new', 'in_progress', 'in_progress', 'done', 'in_progress', 'new', 'done', 'in_progress', 'new', 'in_progress', 'done', 'in_progress'];

            foreach ($arrears as $idx => $arrear) {
                $emp = $employees[$idx % $employees->count()];
                $status = $statuses[$idx] ?? 'new';
                $days = rand(3, 30);

                $task = Task::firstOrCreate(
                    ['arrears_item_id' => $arrear->id, 'employee_id' => $emp->id],
                    [
                        'status' => $status,
                        'assigned_date' => now()->subDays($days),
                        'notes' => null,
                    ]
                );

                // Follow-ups for in_progress / done tasks
                if (in_array($status, ['in_progress', 'done'])) {
                    $fTypes = ['telepon', 'kunjungan', 'telepon'];
                    $results = ['Tidak diangkat', 'Pemilik menjawab, janji bayar minggu depan', 'Kunjungan lapangan, rumah kosong'];
                    $numFollowups = rand(1, 3);

                    for ($f = 0; $f < $numFollowups; $f++) {
                        $fDate = now()->subDays($days - $f - 1);
                        Followup::firstOrCreate(
                            ['task_id' => $task->id, 'followup_date' => $fDate->toDateString()],
                            [
                                'employee_id' => $emp->id,
                                'type' => $fTypes[$f % count($fTypes)],
                                'result' => $results[$f % count($results)],
                                'followup_date' => $fDate,
                            ]
                        );
                    }
                }

                // Vehicle status for some tasks
                if (in_array($status, ['done', 'in_progress']) && $idx % 3 === 0) {
                    $vStatuses = ['dimiliki', 'lapor_jual', 'pindah_alamat', 'rumah_kosong'];
                    VehicleStatus::firstOrCreate(
                        ['task_id' => $task->id],
                        [
                            'status' => $vStatuses[$idx % count($vStatuses)],
                            'status_date' => now()->subDays(rand(1, 5))->toDateString(),
                            'reported_by' => $emp->id,
                            'notes' => 'Verifikasi lapangan',
                        ]
                    );
                }
            }
        }

        // --- Reminder Batch dummy ---
        $rule = ReminderRule::first();
        if ($rule && $vehicles->count() >= 5) {
            $batch = ReminderBatch::firstOrCreate(
                ['filter_description' => 'Batch uji coba H-7'],
                [
                    'status' => 'done',
                    'total_items' => 5,
                    'sent_count' => 4,
                    'failed_count' => 1,
                    'skipped_count' => 0,
                    'created_by' => 1,
                    'approved_by' => 1,
                    'approved_at' => now()->subDays(3),
                    'scheduled_at' => now()->subDays(3),
                    'completed_at' => now()->subDays(3),
                ]
            );

            // Reminder items + message logs
            foreach ($vehicles->take(5) as $idx => $vehicle) {
                $tp = $taxpayers[$vehiclesData[$idx]['tp']];

                $item = ReminderItem::firstOrCreate(
                    ['reminder_batch_id' => $batch->id, 'vehicle_id' => $vehicle->id, 'reminder_rule_id' => $rule->id],
                    [
                        'taxpayer_id' => $tp->id,
                        'status' => $idx === 4 ? 'failed' : 'sent',
                        'planned_send_at' => now()->subDays(3),
                    ]
                );

                MessageLog::firstOrCreate(
                    ['reminder_item_id' => $item->id],
                    [
                        'phone' => $tp->phone_e164 ?: '08120000000',
                        'message_body' => "Yth. {$tp->name}, pajak kendaraan {$vehicle->plate_number} akan jatuh tempo. Segera lakukan pembayaran.",
                        'status' => $idx === 4 ? 'failed' : ($idx === 3 ? 'delivered' : 'sent'),
                        'provider' => 'fonnte',
                        'sent_at' => $idx === 4 ? null : now()->subDays(3),
                        'error_message' => $idx === 4 ? 'Number not registered on WhatsApp' : null,
                        'retry_count' => $idx === 4 ? 2 : 0,
                    ]
                );
            }
        }

        $this->command->info('✓ Dummy data seeded: 20 taxpayers, 20 vehicles, 12 arrears, tasks, followups, reminder batch');
    }
}
