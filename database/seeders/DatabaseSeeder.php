<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\ReminderRule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Default Users ---
        $admin = User::firstOrCreate(
            ['email' => 'admin@samsat.go.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $operator = User::firstOrCreate(
            ['email' => 'operator@samsat.go.id'],
            [
                'name' => 'Operator Samsat',
                'password' => Hash::make('password'),
                'role' => 'operator',
                'is_active' => true,
            ]
        );

        $supervisor = User::firstOrCreate(
            ['email' => 'supervisor@samsat.go.id'],
            [
                'name' => 'Supervisor Samsat',
                'password' => Hash::make('password'),
                'role' => 'supervisor',
                'is_active' => true,
            ]
        );

        // --- Default Employees ---
        Employee::firstOrCreate(
            ['nip' => '198501012010011001'],
            [
                'user_id' => $operator->id,
                'name' => 'Budi Santoso',
                'jabatan' => 'Petugas Penagihan',
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );

        Employee::firstOrCreate(
            ['nip' => '199001012015021001'],
            [
                'name' => 'Siti Aminah',
                'jabatan' => 'Petugas Penagihan',
                'phone' => '081298765432',
                'is_active' => true,
            ]
        );

        Employee::firstOrCreate(
            ['nip' => '198801012012031001'],
            [
                'name' => 'Ahmad Rizki',
                'jabatan' => 'Petugas Lapangan',
                'phone' => '081356789012',
                'is_active' => true,
            ]
        );

        // --- Default Reminder Rules ---
        ReminderRule::firstOrCreate(
            ['days_before_due' => 7],
            [
                'name' => 'Pengingat H-7',
                'template_code' => 'h_minus_7',
                'template_text' => 'Yth. {nama}, pajak kendaraan {nopol} akan jatuh tempo pada {tanggal_jatuh_tempo}. Segera lakukan pembayaran. Terima kasih. — Samsat Tanjungpinang',
                'send_window_start' => '08:00',
                'send_window_end' => '16:00',
                'is_active' => true,
            ]
        );

        ReminderRule::firstOrCreate(
            ['days_before_due' => 1],
            [
                'name' => 'Pengingat H-1',
                'template_code' => 'h_minus_1',
                'template_text' => 'Yth. {nama}, BESOK adalah batas akhir pembayaran pajak kendaraan {nopol} ({tanggal_jatuh_tempo}). Segera lakukan pembayaran untuk menghindari denda. Terima kasih. — Samsat Tanjungpinang',
                'send_window_start' => '08:00',
                'send_window_end' => '16:00',
                'is_active' => true,
            ]
        );

        // --- Dummy Data ---
        $this->call(DummyDataSeeder::class);
    }
}
