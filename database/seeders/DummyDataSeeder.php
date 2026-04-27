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
        // --- Wajib Pajak (Taxpayers) — 50 data ---
        $taxpayersData = [
            ['name' => 'Ahmad Hidayat', 'nik' => '2171010101800001', 'phone_e164' => '08127012001', 'email' => 'ahmad.hidayat@gmail.com', 'address' => 'Jl. Merdeka No. 12, Tanjungpinang Barat'],
            ['name' => 'Sari Dewi', 'nik' => '2171020202850002', 'phone_e164' => '08127012002', 'email' => 'sari.dewi85@yahoo.com', 'address' => 'Jl. Sultan Mahmud No. 45, Tanjungpinang Timur'],
            ['name' => 'Budi Prasetyo', 'nik' => '2171030303900003', 'phone_e164' => '08127012003', 'email' => 'budi.prasetyo90@gmail.com', 'address' => 'Jl. Yusuf Kahar No. 8, Bukit Bestari'],
            ['name' => 'Rina Marlina', 'nik' => '2171040404880004', 'phone_e164' => '08127012004', 'email' => 'rina.marlina@outlook.com', 'address' => 'Jl. Basuki Rahmat No. 33, Tanjungpinang Kota'],
            ['name' => 'Muhammad Reza', 'nik' => '2171050505920005', 'phone_e164' => '08127012005', 'email' => 'muh.reza92@gmail.com', 'address' => 'Jl. Pos No. 17, Tanjungpinang Barat'],
            ['name' => 'Lilis Suryani', 'nik' => '2171060606870006', 'phone_e164' => '08127012006', 'email' => 'lilis.suryani@yahoo.co.id', 'address' => 'Jl. DI Panjaitan No. 22, Bukit Bestari'],
            ['name' => 'Eko Saputra', 'nik' => '2171070707950007', 'phone_e164' => '08127012007', 'email' => 'eko.saputra95@gmail.com', 'address' => 'Jl. Teuku Umar No. 55, Tanjungpinang Timur'],
            ['name' => 'Nurhayati', 'nik' => '2171080808830008', 'phone_e164' => '08127012008', 'email' => 'nurhayati83@gmail.com', 'address' => 'Jl. Hang Tuah No. 9, Tanjungpinang Kota'],
            ['name' => 'Irwan Setiawan', 'nik' => '2171090909780009', 'phone_e164' => '08127012009', 'email' => 'irwan.setiawan@outlook.com', 'address' => 'Jl. Pramuka No. 14, Bukit Bestari'],
            ['name' => 'Dewi Kusuma', 'nik' => '2171101010860010', 'phone_e164' => '08127012010', 'email' => 'dewi.kusuma86@gmail.com', 'address' => 'Jl. KH Ahmad Dahlan No. 3, Tanjungpinang Barat'],
            ['name' => 'Hendri Kurniawan', 'nik' => '2171111111910011', 'phone_e164' => '08127012011', 'email' => 'hendri.k91@yahoo.com', 'address' => 'Jl. Gatot Subroto No. 77, Tanjungpinang Timur'],
            ['name' => 'Yuni Astuti', 'nik' => '2171121212840012', 'phone_e164' => '08127012012', 'email' => 'yuni.astuti84@gmail.com', 'address' => 'Jl. Kartini No. 29, Tanjungpinang Kota'],
            ['name' => 'Agus Purnomo', 'nik' => '2171131313890013', 'phone_e164' => '08127012013', 'email' => 'agus.purnomo@gmail.com', 'address' => 'Jl. Sudirman No. 5, Bukit Bestari'],
            ['name' => 'Fitriani', 'nik' => '2171141414930014', 'phone_e164' => '08127012014', 'email' => 'fitriani93@outlook.com', 'address' => 'Jl. Ahmad Yani No. 61, Tanjungpinang Barat'],
            ['name' => 'Rizal Fahmi', 'nik' => '2171151515870015', 'phone_e164' => '08127012015', 'email' => 'rizal.fahmi87@gmail.com', 'address' => 'Jl. RA Kartini No. 18, Tanjungpinang Timur'],
            ['name' => 'Wahyu Hidayah', 'nik' => '2171161616960016', 'phone_e164' => '', 'email' => 'wahyu.hidayah96@gmail.com', 'address' => 'Jl. Diponegoro No. 40, Bukit Bestari', 'flag_phone_invalid' => true],
            ['name' => 'Diana Putri', 'nik' => '2171171717800017', 'phone_e164' => '08127012017', 'email' => 'diana.putri80@yahoo.com', 'address' => 'Tanjungpinang', 'opt_out' => true],
            ['name' => 'Arif Rahman', 'nik' => '2171181818850018', 'phone_e164' => '08127012018', 'email' => 'arif.rahman@gmail.com', 'address' => 'Jl. Hang Jebat No. 7, Tanjungpinang Kota'],
            ['name' => 'Sri Wahyuni', 'nik' => '2171191919900019', 'phone_e164' => '08127012019', 'email' => 'sri.wahyuni90@gmail.com', 'address' => 'Jl. Engku Putri No. 23, Bukit Bestari'],
            ['name' => 'Bambang Hermawan', 'nik' => '2171202020880020', 'phone_e164' => '08127012020', 'email' => 'bambang.h88@outlook.com', 'address' => 'Jl. Tugu No. 11, Tanjungpinang Barat'],
            // --- 21-30 ---
            ['name' => 'Ratna Sari', 'nik' => '2171212121910021', 'phone_e164' => '08127012021', 'email' => 'ratna.sari91@gmail.com', 'address' => 'Jl. Pemuda No. 16, Tanjungpinang Kota'],
            ['name' => 'Dedi Kurniadi', 'nik' => '2171222222870022', 'phone_e164' => '08127012022', 'email' => 'dedi.kurniadi@yahoo.co.id', 'address' => 'Jl. Bakar Batu No. 31, Bukit Bestari'],
            ['name' => 'Anisa Rahmawati', 'nik' => '2171232323940023', 'phone_e164' => '08127012023', 'email' => 'anisa.rahma94@gmail.com', 'address' => 'Jl. Pelantar II No. 5, Tanjungpinang Timur'],
            ['name' => 'Hendra Gunawan', 'nik' => '2171242424860024', 'phone_e164' => '08127012024', 'email' => 'hendra.gun86@outlook.com', 'address' => 'Jl. Bintan No. 42, Tanjungpinang Barat'],
            ['name' => 'Putri Lestari', 'nik' => '2171252525930025', 'phone_e164' => '08127012025', 'email' => 'putri.lestari93@gmail.com', 'address' => 'Jl. Raja Ali Haji No. 8, Bukit Bestari'],
            ['name' => 'Surya Dharma', 'nik' => '2171262626810026', 'phone_e164' => '08127012026', 'email' => 'surya.dharma81@gmail.com', 'address' => 'Jl. Nusantara No. 19, Tanjungpinang Kota'],
            ['name' => 'Mega Wulandari', 'nik' => '2171272727950027', 'phone_e164' => '08127012027', 'email' => 'mega.wulan95@yahoo.com', 'address' => 'Jl. Pancasila No. 25, Tanjungpinang Timur'],
            ['name' => 'Joko Susanto', 'nik' => '2171282828880028', 'phone_e164' => '08127012028', 'email' => 'joko.susanto@gmail.com', 'address' => 'Jl. RE Martadinata No. 13, Bukit Bestari'],
            ['name' => 'Nur Azizah', 'nik' => '2171292929900029', 'phone_e164' => '08127012029', 'email' => 'nur.azizah90@outlook.com', 'address' => 'Jl. Tanjung Unggat No. 7, Tanjungpinang Barat'],
            ['name' => 'Fajar Pratama', 'nik' => '2171303030920030', 'phone_e164' => '', 'email' => 'fajar.pratama92@gmail.com', 'address' => 'Jl. Senggarang No. 34, Tanjungpinang Kota', 'flag_phone_invalid' => true],
            // --- 31-40 ---
            ['name' => 'Indah Permata', 'nik' => '2171313131850031', 'phone_e164' => '08127012031', 'email' => 'indah.permata@gmail.com', 'address' => 'Jl. Sei Jang No. 20, Bukit Bestari'],
            ['name' => 'Rudi Hartono', 'nik' => '2171323232890032', 'phone_e164' => '08127012032', 'email' => 'rudi.hartono89@yahoo.com', 'address' => 'Jl. Dompak No. 15, Tanjungpinang Timur'],
            ['name' => 'Winda Sari', 'nik' => '2171333333930033', 'phone_e164' => '08127012033', 'email' => 'winda.sari93@gmail.com', 'address' => 'Jl. Kampung Bugis No. 28, Tanjungpinang Kota'],
            ['name' => 'Tono Wijaya', 'nik' => '2171343434870034', 'phone_e164' => '08127012034', 'email' => 'tono.wijaya@outlook.com', 'address' => 'Jl. Gesek No. 6, Bukit Bestari'],
            ['name' => 'Elsa Novita', 'nik' => '2171353535960035', 'phone_e164' => '08127012035', 'email' => 'elsa.novita96@gmail.com', 'address' => 'Jl. Tanjung Ayun No. 11, Tanjungpinang Barat'],
            ['name' => 'Aditya Nugroho', 'nik' => '2171363636910036', 'phone_e164' => '08127012036', 'email' => 'aditya.nugroho91@gmail.com', 'address' => 'Jl. Kijang Lama No. 39, Tanjungpinang Timur'],
            ['name' => 'Kartika Dewi', 'nik' => '2171373737840037', 'phone_e164' => '08127012037', 'email' => 'kartika.dewi84@yahoo.co.id', 'address' => 'Jl. Gurindam 12 No. 3, Tanjungpinang Kota'],
            ['name' => 'Dani Setiabudi', 'nik' => '2171383838880038', 'phone_e164' => '08127012038', 'email' => 'dani.setiabudi@gmail.com', 'address' => 'Jl. Pinang No. 21, Bukit Bestari'],
            ['name' => 'Lina Marliani', 'nik' => '2171393939920039', 'phone_e164' => '08127012039', 'email' => 'lina.marliani92@outlook.com', 'address' => 'Jl. Lorong Bintan No. 17, Tanjungpinang Barat', 'opt_out' => true],
            ['name' => 'Oscar Ramadhan', 'nik' => '2171404040860040', 'phone_e164' => '08127012040', 'email' => 'oscar.ramadhan@gmail.com', 'address' => 'Jl. Batu Hitam No. 44, Tanjungpinang Kota'],
            // --- 41-50 ---
            ['name' => 'Melati Anggraini', 'nik' => '2171414141940041', 'phone_e164' => '08127012041', 'email' => 'melati.anggraini@gmail.com', 'address' => 'Jl. Air Raja No. 9, Tanjungpinang Timur'],
            ['name' => 'Prasetyo Adi', 'nik' => '2171424242870042', 'phone_e164' => '08127012042', 'email' => 'prasetyo.adi87@yahoo.com', 'address' => 'Jl. Sungai Carang No. 51, Bukit Bestari'],
            ['name' => 'Novia Rahmadani', 'nik' => '2171434343950043', 'phone_e164' => '08127012043', 'email' => 'novia.rahmadani@gmail.com', 'address' => 'Jl. Tanjungpinang Lama No. 14, Tanjungpinang Barat'],
            ['name' => 'Gilang Ramadhan', 'nik' => '2171444444900044', 'phone_e164' => '08127012044', 'email' => 'gilang.r90@outlook.com', 'address' => 'Jl. Madong No. 23, Tanjungpinang Kota'],
            ['name' => 'Sinta Maharani', 'nik' => '2171454545830045', 'phone_e164' => '08127012045', 'email' => 'sinta.maharani83@gmail.com', 'address' => 'Jl. Batu Sembilan No. 30, Bukit Bestari'],
            ['name' => 'Yusuf Hakim', 'nik' => '2171464646880046', 'phone_e164' => '08127012046', 'email' => 'yusuf.hakim88@gmail.com', 'address' => 'Jl. Kemboja No. 7, Tanjungpinang Timur'],
            ['name' => 'Laras Setyowati', 'nik' => '2171474747960047', 'phone_e164' => '', 'email' => 'laras.setyo96@yahoo.com', 'address' => 'Jl. Sei Lekop No. 36, Tanjungpinang Barat', 'flag_phone_invalid' => true],
            ['name' => 'Bayu Arifin', 'nik' => '2171484848910048', 'phone_e164' => '08127012048', 'email' => 'bayu.arifin91@gmail.com', 'address' => 'Jl. Taman Bestari No. 18, Bukit Bestari'],
            ['name' => 'Citra Dewanti', 'nik' => '2171494949850049', 'phone_e164' => '08127012049', 'email' => 'citra.dewanti85@outlook.com', 'address' => 'Jl. Penyengat No. 22, Tanjungpinang Kota'],
            ['name' => 'Rendy Saputra', 'nik' => '2171505050930050', 'phone_e164' => '08127012050', 'email' => 'rendy.saputra93@gmail.com', 'address' => 'Jl. Laut Melayu No. 10, Tanjungpinang Timur'],
        ];

        $taxpayers = collect($taxpayersData)->map(function ($data) {
            return Taxpayer::firstOrCreate(['nik' => $data['nik']], $data);
        });

        // --- Kendaraan (Vehicles) — 50 data ---
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
            // --- 21-30 ---
            ['plate_number' => 'BP 3030 HH', 'tp' => 20, 'vehicle_brand' => 'Honda CBR250RR', 'vehicle_year' => 2022, 'due_date' => now()->subDays(3)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 4040 II', 'tp' => 21, 'vehicle_brand' => 'Toyota Fortuner', 'vehicle_year' => 2020, 'due_date' => now()->subDays(25)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 5050 JJ', 'tp' => 22, 'vehicle_brand' => 'Suzuki GSX-R150', 'vehicle_year' => 2021, 'due_date' => now()->addDays(10)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 6060 KK', 'tp' => 23, 'vehicle_brand' => 'Daihatsu Terios', 'vehicle_year' => 2018, 'due_date' => now()->subDays(50)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 7070 LL', 'tp' => 24, 'vehicle_brand' => 'Honda ADV 160', 'vehicle_year' => 2023, 'due_date' => now()->addDays(8)->toDateString(), 'status_payment' => 'paid'],
            ['plate_number' => 'BP 8080 MM', 'tp' => 25, 'vehicle_brand' => 'Toyota Yaris', 'vehicle_year' => 2019, 'due_date' => now()->subDays(40)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 9090 NN', 'tp' => 26, 'vehicle_brand' => 'Yamaha MT-25', 'vehicle_year' => 2022, 'due_date' => now()->addDays(18)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 1111 OO', 'tp' => 27, 'vehicle_brand' => 'Mitsubishi Pajero Sport', 'vehicle_year' => 2020, 'due_date' => now()->subDays(75)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 2222 PP', 'tp' => 28, 'vehicle_brand' => 'Honda Genio', 'vehicle_year' => 2021, 'due_date' => now()->addDays(6)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 3333 QQ', 'tp' => 29, 'vehicle_brand' => 'Kawasaki KLX 150', 'vehicle_year' => 2020, 'due_date' => now()->subDays(14)->toDateString(), 'status_payment' => 'unpaid'],
            // --- 31-40 ---
            ['plate_number' => 'BP 4444 RR', 'tp' => 30, 'vehicle_brand' => 'Honda Brio', 'vehicle_year' => 2022, 'due_date' => now()->addDays(22)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 5555 SS', 'tp' => 31, 'vehicle_brand' => 'Toyota Calya', 'vehicle_year' => 2021, 'due_date' => now()->subDays(18)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 6666 TT', 'tp' => 32, 'vehicle_brand' => 'Yamaha Vixion', 'vehicle_year' => 2019, 'due_date' => now()->subDays(55)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 7777 UU', 'tp' => 33, 'vehicle_brand' => 'Suzuki XL7', 'vehicle_year' => 2023, 'due_date' => now()->addDays(35)->toDateString(), 'status_payment' => 'paid'],
            ['plate_number' => 'BP 8888 VV', 'tp' => 34, 'vehicle_brand' => 'Honda Revo', 'vehicle_year' => 2018, 'due_date' => now()->subDays(100)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 9999 WW', 'tp' => 35, 'vehicle_brand' => 'Daihatsu Ayla', 'vehicle_year' => 2021, 'due_date' => now()->addDays(4)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 1212 XX', 'tp' => 36, 'vehicle_brand' => 'Toyota Agya', 'vehicle_year' => 2020, 'due_date' => now()->subDays(35)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 1313 YY', 'tp' => 37, 'vehicle_brand' => 'Honda Supra GTR', 'vehicle_year' => 2022, 'due_date' => now()->addDays(14)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 1414 ZZ', 'tp' => 38, 'vehicle_brand' => 'Yamaha FreeGo', 'vehicle_year' => 2021, 'due_date' => now()->subDays(8)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 1515 AB', 'tp' => 39, 'vehicle_brand' => 'Mitsubishi Triton', 'vehicle_year' => 2019, 'due_date' => now()->subDays(65)->toDateString(), 'status_payment' => 'unpaid'],
            // --- 41-50 ---
            ['plate_number' => 'BP 1616 BC', 'tp' => 40, 'vehicle_brand' => 'Suzuki Nex II', 'vehicle_year' => 2022, 'due_date' => now()->addDays(9)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 1717 CD', 'tp' => 41, 'vehicle_brand' => 'Honda City', 'vehicle_year' => 2020, 'due_date' => now()->subDays(28)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 1818 DE', 'tp' => 42, 'vehicle_brand' => 'Toyota Hilux', 'vehicle_year' => 2021, 'due_date' => now()->addDays(28)->toDateString(), 'status_payment' => 'paid'],
            ['plate_number' => 'BP 1919 EF', 'tp' => 43, 'vehicle_brand' => 'Kawasaki W175', 'vehicle_year' => 2023, 'due_date' => now()->subDays(12)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 2021 FG', 'tp' => 44, 'vehicle_brand' => 'Honda BR-V', 'vehicle_year' => 2022, 'due_date' => now()->addDays(16)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 2122 GH', 'tp' => 45, 'vehicle_brand' => 'Yamaha WR 155', 'vehicle_year' => 2021, 'due_date' => now()->subDays(22)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 2223 HI', 'tp' => 46, 'vehicle_brand' => 'Daihatsu Rocky', 'vehicle_year' => 2023, 'due_date' => now()->addDays(11)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 2324 IJ', 'tp' => 47, 'vehicle_brand' => 'Toyota Raize', 'vehicle_year' => 2022, 'due_date' => now()->subDays(42)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 2425 JK', 'tp' => 48, 'vehicle_brand' => 'Honda Civic', 'vehicle_year' => 2020, 'due_date' => now()->subDays(85)->toDateString(), 'status_payment' => 'unpaid'],
            ['plate_number' => 'BP 2526 KL', 'tp' => 49, 'vehicle_brand' => 'Suzuki Ignis', 'vehicle_year' => 2021, 'due_date' => now()->addDays(1)->toDateString(), 'status_payment' => 'unpaid'],
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

        // --- Tunggakan (Arrears) — 50 data ---
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
            // --- 13-24 (new arrears) ---
            ['plate' => 'BP 3030 HH', 'owner' => 'Ratna Sari', 'phone' => '08127012021', 'amount' => 420000, 'years' => 1, 'brand' => 'Honda CBR250RR', 'year' => 2022],
            ['plate' => 'BP 4040 II', 'owner' => 'Dedi Kurniadi', 'phone' => '08127012022', 'amount' => 1850000, 'years' => 2, 'brand' => 'Toyota Fortuner', 'year' => 2020],
            ['plate' => 'BP 6060 KK', 'owner' => 'Hendra Gunawan', 'phone' => '08127012024', 'amount' => 3750000, 'years' => 4, 'brand' => 'Daihatsu Terios', 'year' => 2018],
            ['plate' => 'BP 8080 MM', 'owner' => 'Surya Dharma', 'phone' => '08127012026', 'amount' => 2900000, 'years' => 3, 'brand' => 'Toyota Yaris', 'year' => 2019],
            ['plate' => 'BP 1111 OO', 'owner' => 'Joko Susanto', 'phone' => '08127012028', 'amount' => 5600000, 'years' => 6, 'brand' => 'Mitsubishi Pajero Sport', 'year' => 2020],
            ['plate' => 'BP 3333 QQ', 'owner' => 'Fajar Pratama', 'phone' => '', 'amount' => 980000, 'years' => 1, 'brand' => 'Kawasaki KLX 150', 'year' => 2020, 'flag_phone' => true],
            ['plate' => 'BP 5555 SS', 'owner' => 'Rudi Hartono', 'phone' => '08127012032', 'amount' => 1350000, 'years' => 2, 'brand' => 'Toyota Calya', 'year' => 2021],
            ['plate' => 'BP 6666 TT', 'owner' => 'Winda Sari', 'phone' => '08127012033', 'amount' => 4100000, 'years' => 5, 'brand' => 'Yamaha Vixion', 'year' => 2019],
            ['plate' => 'BP 8888 VV', 'owner' => 'Elsa Novita', 'phone' => '08127012035', 'amount' => 7200000, 'years' => 7, 'brand' => 'Honda Revo', 'year' => 2018],
            ['plate' => 'BP 1212 XX', 'owner' => 'Kartika Dewi', 'phone' => '08127012037', 'amount' => 2650000, 'years' => 3, 'brand' => 'Toyota Agya', 'year' => 2020],
            ['plate' => 'BP 1414 ZZ', 'owner' => 'Lina Marliani', 'phone' => '08127012039', 'amount' => 560000, 'years' => 1, 'brand' => 'Yamaha FreeGo', 'year' => 2021],
            ['plate' => 'BP 1515 AB', 'owner' => 'Oscar Ramadhan', 'phone' => '08127012040', 'amount' => 4800000, 'years' => 5, 'brand' => 'Mitsubishi Triton', 'year' => 2019],
            // --- 25-36 ---
            ['plate' => 'BP 1717 CD', 'owner' => 'Prasetyo Adi', 'phone' => '08127012042', 'amount' => 2100000, 'years' => 2, 'brand' => 'Honda City', 'year' => 2020],
            ['plate' => 'BP 1919 EF', 'owner' => 'Gilang Ramadhan', 'phone' => '08127012044', 'amount' => 780000, 'years' => 1, 'brand' => 'Kawasaki W175', 'year' => 2023],
            ['plate' => 'BP 2122 GH', 'owner' => 'Yusuf Hakim', 'phone' => '08127012046', 'amount' => 1670000, 'years' => 2, 'brand' => 'Yamaha WR 155', 'year' => 2021],
            ['plate' => 'BP 2223 HI', 'owner' => 'Laras Setyowati', 'phone' => '', 'amount' => 890000, 'years' => 1, 'brand' => 'Daihatsu Rocky', 'year' => 2023, 'flag_phone' => true],
            ['plate' => 'BP 2324 IJ', 'owner' => 'Bayu Arifin', 'phone' => '08127012048', 'amount' => 3200000, 'years' => 3, 'brand' => 'Toyota Raize', 'year' => 2022],
            ['plate' => 'BP 2425 JK', 'owner' => 'Citra Dewanti', 'phone' => '08127012049', 'amount' => 6400000, 'years' => 6, 'brand' => 'Honda Civic', 'year' => 2020],
            ['plate' => 'BP 2526 KL', 'owner' => 'Rendy Saputra', 'phone' => '08127012050', 'amount' => 450000, 'years' => 1, 'brand' => 'Suzuki Ignis', 'year' => 2021],
            ['plate' => 'BP 5678 IJ', 'owner' => 'Muhammad Reza', 'phone' => '08127012005', 'amount' => 320000, 'years' => 1, 'brand' => 'Honda Beat', 'year' => 2022],
            ['plate' => 'BP 7890 MN', 'owner' => 'Eko Saputra', 'phone' => '08127012007', 'amount' => 670000, 'years' => 1, 'brand' => 'Yamaha Mio', 'year' => 2020],
            ['plate' => 'BP 2233 UV', 'owner' => 'Hendri Kurniawan', 'phone' => '08127012011', 'amount' => 1150000, 'years' => 2, 'brand' => 'Honda Scoopy', 'year' => 2021],
            ['plate' => 'BP 2020 GG', 'owner' => 'Sri Wahyuni', 'phone' => '08127012019', 'amount' => 290000, 'years' => 1, 'brand' => 'Yamaha Aerox', 'year' => 2023],
            ['plate' => 'BP 9900 EE', 'owner' => 'Diana Putri', 'phone' => '08127012017', 'amount' => 510000, 'years' => 1, 'brand' => 'Daihatsu Sigra', 'year' => 2020],
            // --- 37-50 ---
            ['plate' => 'BP 5050 JJ', 'owner' => 'Anisa Rahmawati', 'phone' => '08127012023', 'amount' => 380000, 'years' => 1, 'brand' => 'Suzuki GSX-R150', 'year' => 2021],
            ['plate' => 'BP 9090 NN', 'owner' => 'Mega Wulandari', 'phone' => '08127012027', 'amount' => 740000, 'years' => 1, 'brand' => 'Yamaha MT-25', 'year' => 2022],
            ['plate' => 'BP 2222 PP', 'owner' => 'Nur Azizah', 'phone' => '08127012029', 'amount' => 460000, 'years' => 1, 'brand' => 'Honda Genio', 'year' => 2021],
            ['plate' => 'BP 4444 RR', 'owner' => 'Indah Permata', 'phone' => '08127012031', 'amount' => 1520000, 'years' => 2, 'brand' => 'Honda Brio', 'year' => 2022],
            ['plate' => 'BP 9999 WW', 'owner' => 'Aditya Nugroho', 'phone' => '08127012036', 'amount' => 830000, 'years' => 1, 'brand' => 'Daihatsu Ayla', 'year' => 2021],
            ['plate' => 'BP 1313 YY', 'owner' => 'Dani Setiabudi', 'phone' => '08127012038', 'amount' => 590000, 'years' => 1, 'brand' => 'Honda Supra GTR', 'year' => 2022],
            ['plate' => 'BP 1616 BC', 'owner' => 'Melati Anggraini', 'phone' => '08127012041', 'amount' => 410000, 'years' => 1, 'brand' => 'Suzuki Nex II', 'year' => 2022],
            ['plate' => 'BP 1818 DE', 'owner' => 'Novia Rahmadani', 'phone' => '08127012043', 'amount' => 1980000, 'years' => 2, 'brand' => 'Toyota Hilux', 'year' => 2021],
            ['plate' => 'BP 2021 FG', 'owner' => 'Sinta Maharani', 'phone' => '08127012045', 'amount' => 1340000, 'years' => 2, 'brand' => 'Honda BR-V', 'year' => 2022],
            ['plate' => 'BP 7070 LL', 'owner' => 'Putri Lestari', 'phone' => '08127012025', 'amount' => 720000, 'years' => 1, 'brand' => 'Honda ADV 160', 'year' => 2023],
            ['plate' => 'BP 7777 UU', 'owner' => 'Tono Wijaya', 'phone' => '08127012034', 'amount' => 2350000, 'years' => 3, 'brand' => 'Suzuki XL7', 'year' => 2023],
            ['plate' => 'BP 7788 CC', 'owner' => 'Ahmad Hidayat', 'phone' => '08127012001', 'amount' => 550000, 'years' => 1, 'brand' => 'Yamaha R15', 'year' => 2022],
            ['plate' => 'BP 1122 ST', 'owner' => 'Dewi Kusuma', 'phone' => '08127012010', 'amount' => 270000, 'years' => 1, 'brand' => 'Toyota Rush', 'year' => 2022],
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
            $statuses = [
                'new', 'in_progress', 'in_progress', 'done', 'in_progress',
                'new', 'done', 'in_progress', 'new', 'in_progress',
                'done', 'in_progress', 'new', 'in_progress', 'done',
                'in_progress', 'new', 'done', 'in_progress', 'new',
                'in_progress', 'done', 'new', 'in_progress', 'in_progress',
                'done', 'new', 'in_progress', 'done', 'in_progress',
                'new', 'done', 'in_progress', 'new', 'in_progress',
                'done', 'new', 'in_progress', 'done', 'in_progress',
                'new', 'in_progress', 'done', 'new', 'in_progress',
                'done', 'new', 'in_progress', 'done', 'in_progress',
            ];

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
                    $results = [
                        'Tidak diangkat',
                        'Pemilik menjawab, janji bayar minggu depan',
                        'Kunjungan lapangan, rumah kosong',
                        'Telepon aktif, WP akan bayar besok',
                        'WP tidak ada di tempat, tetangga info pindah',
                        'Berhasil ditemui, WP minta penundaan',
                    ];
                    $numFollowups = rand(1, 3);

                    for ($f = 0; $f < $numFollowups; $f++) {
                        $fDate = now()->subDays($days - $f - 1);
                        Followup::firstOrCreate(
                            ['task_id' => $task->id, 'followup_date' => $fDate->toDateString()],
                            [
                                'employee_id' => $emp->id,
                                'type' => $fTypes[$f % count($fTypes)],
                                'result' => $results[($idx + $f) % count($results)],
                                'followup_date' => $fDate,
                            ]
                        );
                    }
                }

                // Vehicle status for some tasks
                if (in_array($status, ['done', 'in_progress']) && $idx % 3 === 0) {
                    $vStatuses = ['dimiliki', 'lapor_jual', 'pindah_alamat', 'rumah_kosong', 'rusak_berat', 'hilang'];
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

                // Determine channel — use email if available, otherwise whatsapp
                $channel = $tp->email ? 'email' : 'whatsapp';

                MessageLog::firstOrCreate(
                    ['reminder_item_id' => $item->id],
                    [
                        'phone' => $tp->phone_e164 ?: '08120000000',
                        'channel' => $channel,
                        'recipient_email' => $tp->email,
                        'message_body' => "Yth. {$tp->name}, pajak kendaraan {$vehicle->plate_number} akan jatuh tempo. Segera lakukan pembayaran.",
                        'status' => $idx === 4 ? 'failed' : ($idx === 3 ? 'delivered' : 'sent'),
                        'provider' => $channel === 'email' ? 'smtp' : 'fonnte',
                        'sent_at' => $idx === 4 ? null : now()->subDays(3),
                        'error_message' => $idx === 4 ? 'Connection timeout' : null,
                        'retry_count' => $idx === 4 ? 2 : 0,
                    ]
                );
            }
        }

        $this->command->info('✓ Dummy data seeded: 50 taxpayers (with email), 50 vehicles, 50 arrears, tasks, followups, reminder batch');
    }
}
