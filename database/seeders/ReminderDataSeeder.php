<?php

namespace Database\Seeders;

use App\Models\Taxpayer;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReminderDataSeeder extends Seeder
{
    public function run(): void
    {
        // Data Wajib Pajak dengan berbagai kondisi
        $taxpayersData = [
            // WP Normal - Siap Reminder
            ['name' => 'Andi Wijaya', 'nik' => '2171010101850001', 'phone_e164' => '+6281234567001', 'address' => 'Jl. Merdeka No. 10, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Siti Nurhaliza', 'nik' => '2171020202900002', 'phone_e164' => '+6281234567002', 'address' => 'Jl. Sudirman No. 25, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Budi Santoso', 'nik' => '2171030303880003', 'phone_e164' => '+6281234567003', 'address' => 'Jl. Ahmad Yani No. 15, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Rina Kusuma', 'nik' => '2171040404920004', 'phone_e164' => '+6281234567004', 'address' => 'Jl. Gatot Subroto No. 8, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Hendra Gunawan', 'nik' => '2171050505870005', 'phone_e164' => '+6281234567005', 'address' => 'Jl. Diponegoro No. 33, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Dewi Lestari', 'nik' => '2171060606910006', 'phone_e164' => '+6281234567006', 'address' => 'Jl. Kartini No. 12, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Agus Prasetyo', 'nik' => '2171070707890007', 'phone_e164' => '+6281234567007', 'address' => 'Jl. Basuki Rahmat No. 45, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Lina Marlina', 'nik' => '2171080808930008', 'phone_e164' => '+6281234567008', 'address' => 'Jl. Hang Tuah No. 20, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Rudi Hartono', 'nik' => '2171090909860009', 'phone_e164' => '+6281234567009', 'address' => 'Jl. Teuku Umar No. 7, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Yuni Astuti', 'nik' => '2171101010940010', 'phone_e164' => '+6281234567010', 'address' => 'Jl. Pramuka No. 18, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Eko Saputra', 'nik' => '2171111111880011', 'phone_e164' => '+6281234567011', 'address' => 'Jl. Veteran No. 22, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Fitri Handayani', 'nik' => '2171121212920012', 'phone_e164' => '+6281234567012', 'address' => 'Jl. Imam Bonjol No. 5, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Dedi Kurniawan', 'nik' => '2171131313850013', 'phone_e164' => '+6281234567013', 'address' => 'Jl. Cendana No. 30, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Maya Sari', 'nik' => '2171141414910014', 'phone_e164' => '+6281234567014', 'address' => 'Jl. Melati No. 14, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Irwan Setiawan', 'nik' => '2171151515870015', 'phone_e164' => '+6281234567015', 'address' => 'Jl. Mawar No. 9, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            
            // WP dengan kondisi khusus (akan di-skip)
            ['name' => 'Bambang Hermawan', 'nik' => '2171161616890016', 'phone_e164' => '', 'address' => 'Jl. Anggrek No. 11, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => true],
            ['name' => 'Sri Wahyuni', 'nik' => '2171171717920017', 'phone_e164' => '+6281234567017', 'address' => 'Jl. Kenanga No. 6, Tanjungpinang', 'opt_out' => true, 'flag_phone_invalid' => false],
            ['name' => 'Joko Widodo', 'nik' => '2171181818880018', 'phone_e164' => '081234567', 'address' => 'Jl. Dahlia No. 3, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => true],
            
            // WP tambahan untuk variasi
            ['name' => 'Nurul Hidayah', 'nik' => '2171191919930019', 'phone_e164' => '+6281234567019', 'address' => 'Jl. Flamboyan No. 27, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Arif Rahman', 'nik' => '2171202020860020', 'phone_e164' => '+6281234567020', 'address' => 'Jl. Bougenville No. 16, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Diana Putri', 'nik' => '2171212121940021', 'phone_e164' => '+6281234567021', 'address' => 'Jl. Kamboja No. 19, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Wahyu Hidayat', 'nik' => '2171222222890022', 'phone_e164' => '+6281234567022', 'address' => 'Jl. Sakura No. 4, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Ratna Sari', 'nik' => '2171232323920023', 'phone_e164' => '+6281234567023', 'address' => 'Jl. Tulip No. 13, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Fajar Ramadhan', 'nik' => '2171242424870024', 'phone_e164' => '+6281234567024', 'address' => 'Jl. Seroja No. 21, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
            ['name' => 'Indah Permata', 'nik' => '2171252525910025', 'phone_e164' => '+6281234567025', 'address' => 'Jl. Teratai No. 8, Tanjungpinang', 'opt_out' => false, 'flag_phone_invalid' => false],
        ];

        $taxpayers = [];
        foreach ($taxpayersData as $data) {
            $taxpayers[] = Taxpayer::updateOrCreate(
                ['nik' => $data['nik']],
                $data
            );
        }

        // Kendaraan dengan jatuh tempo bervariasi untuk testing reminder
        $today = Carbon::today();
        
        $vehiclesData = [
            // Jatuh tempo dalam 1-3 hari (urgent)
            ['taxpayer_idx' => 0, 'plate' => 'BP 1001 AA', 'brand' => 'Honda Vario 160', 'year' => 2022, 'days_offset' => 1, 'status' => 'unpaid'],
            ['taxpayer_idx' => 1, 'plate' => 'BP 1002 AB', 'brand' => 'Toyota Avanza', 'year' => 2021, 'days_offset' => 2, 'status' => 'unpaid'],
            ['taxpayer_idx' => 2, 'plate' => 'BP 1003 AC', 'brand' => 'Yamaha NMAX', 'year' => 2023, 'days_offset' => 3, 'status' => 'unpaid'],
            
            // Jatuh tempo dalam 5-7 hari (ideal untuk H-7 reminder)
            ['taxpayer_idx' => 3, 'plate' => 'BP 1004 AD', 'brand' => 'Suzuki Ertiga', 'year' => 2020, 'days_offset' => 5, 'status' => 'unpaid'],
            ['taxpayer_idx' => 4, 'plate' => 'BP 1005 AE', 'brand' => 'Honda Beat', 'year' => 2022, 'days_offset' => 6, 'status' => 'unpaid'],
            ['taxpayer_idx' => 5, 'plate' => 'BP 1006 AF', 'brand' => 'Daihatsu Xenia', 'year' => 2019, 'days_offset' => 7, 'status' => 'unpaid'],
            ['taxpayer_idx' => 6, 'plate' => 'BP 1007 AG', 'brand' => 'Yamaha Mio', 'year' => 2021, 'days_offset' => 7, 'status' => 'unpaid'],
            ['taxpayer_idx' => 7, 'plate' => 'BP 1008 AH', 'brand' => 'Honda HRV', 'year' => 2022, 'days_offset' => 7, 'status' => 'unpaid'],
            
            // Jatuh tempo dalam 10-14 hari
            ['taxpayer_idx' => 8, 'plate' => 'BP 1009 AI', 'brand' => 'Kawasaki Ninja 250', 'year' => 2020, 'days_offset' => 10, 'status' => 'unpaid'],
            ['taxpayer_idx' => 9, 'plate' => 'BP 1010 AJ', 'brand' => 'Toyota Rush', 'year' => 2023, 'days_offset' => 12, 'status' => 'unpaid'],
            ['taxpayer_idx' => 10, 'plate' => 'BP 1011 AK', 'brand' => 'Honda Scoopy', 'year' => 2022, 'days_offset' => 14, 'status' => 'unpaid'],
            
            // Jatuh tempo dalam 20-30 hari
            ['taxpayer_idx' => 11, 'plate' => 'BP 1012 AL', 'brand' => 'Mitsubishi Xpander', 'year' => 2021, 'days_offset' => 20, 'status' => 'unpaid'],
            ['taxpayer_idx' => 12, 'plate' => 'BP 1013 AM', 'brand' => 'Honda CB150R', 'year' => 2023, 'days_offset' => 25, 'status' => 'unpaid'],
            ['taxpayer_idx' => 13, 'plate' => 'BP 1014 AN', 'brand' => 'Suzuki Satria', 'year' => 2020, 'days_offset' => 30, 'status' => 'unpaid'],
            
            // Jatuh tempo lebih dari 30 hari
            ['taxpayer_idx' => 14, 'plate' => 'BP 1015 AO', 'brand' => 'Toyota Innova', 'year' => 2019, 'days_offset' => 45, 'status' => 'unpaid'],
            ['taxpayer_idx' => 18, 'plate' => 'BP 1016 AP', 'brand' => 'Yamaha R15', 'year' => 2022, 'days_offset' => 60, 'status' => 'unpaid'],
            
            // Kendaraan dengan kondisi khusus (akan di-skip)
            ['taxpayer_idx' => 15, 'plate' => 'BP 1017 AQ', 'brand' => 'Honda PCX', 'year' => 2021, 'days_offset' => 7, 'status' => 'unpaid'], // Phone invalid
            ['taxpayer_idx' => 16, 'plate' => 'BP 1018 AR', 'brand' => 'Daihatsu Sigra', 'year' => 2020, 'days_offset' => 7, 'status' => 'unpaid'], // Opt-out
            ['taxpayer_idx' => 17, 'plate' => 'BP 1019 AS', 'brand' => 'Honda CRV', 'year' => 2022, 'days_offset' => 7, 'status' => 'unpaid'], // Phone invalid
            
            // Kendaraan sudah bayar (tidak akan masuk reminder)
            ['taxpayer_idx' => 19, 'plate' => 'BP 1020 AT', 'brand' => 'Yamaha Aerox', 'year' => 2023, 'days_offset' => 7, 'status' => 'paid'],
            ['taxpayer_idx' => 20, 'plate' => 'BP 1021 AU', 'brand' => 'Toyota Fortuner', 'year' => 2021, 'days_offset' => 10, 'status' => 'paid'],
            
            // Kendaraan tambahan untuk variasi
            ['taxpayer_idx' => 21, 'plate' => 'BP 1022 AV', 'brand' => 'Honda Brio', 'year' => 2020, 'days_offset' => 8, 'status' => 'unpaid'],
            ['taxpayer_idx' => 22, 'plate' => 'BP 1023 AW', 'brand' => 'Yamaha Lexi', 'year' => 2022, 'days_offset' => 9, 'status' => 'unpaid'],
            ['taxpayer_idx' => 23, 'plate' => 'BP 1024 AX', 'brand' => 'Suzuki XL7', 'year' => 2021, 'days_offset' => 11, 'status' => 'unpaid'],
            ['taxpayer_idx' => 24, 'plate' => 'BP 1025 AY', 'brand' => 'Honda Jazz', 'year' => 2019, 'days_offset' => 13, 'status' => 'unpaid'],
            
            // Beberapa WP dengan 2 kendaraan
            ['taxpayer_idx' => 0, 'plate' => 'BP 2001 BA', 'brand' => 'Honda Supra X', 'year' => 2018, 'days_offset' => 15, 'status' => 'unpaid'],
            ['taxpayer_idx' => 1, 'plate' => 'BP 2002 BB', 'brand' => 'Toyota Calya', 'year' => 2020, 'days_offset' => 18, 'status' => 'unpaid'],
            ['taxpayer_idx' => 3, 'plate' => 'BP 2003 BC', 'brand' => 'Yamaha Jupiter', 'year' => 2017, 'days_offset' => 22, 'status' => 'unpaid'],
        ];

        foreach ($vehiclesData as $data) {
            $dueDate = $today->copy()->addDays($data['days_offset']);
            
            Vehicle::updateOrCreate(
                ['plate_number' => $data['plate']],
                [
                    'taxpayer_id' => $taxpayers[$data['taxpayer_idx']]->id,
                    'vehicle_brand' => $data['brand'],
                    'vehicle_year' => $data['year'],
                    'due_date' => $dueDate,
                    'status_payment' => $data['status'],
                ]
            );
        }

        $this->command->info('✓ Reminder data seeded successfully');
        $this->command->info('  - 25 Taxpayers (22 valid, 3 dengan kondisi khusus)');
        $this->command->info('  - 28 Vehicles dengan jatuh tempo bervariasi');
        $this->command->info('  - Siap untuk testing batch reminder');
    }
}
