# 🏛️ Samsat Monitoring — Sistem Informasi Monitoring Penagihan Pajak Kendaraan

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Vite-7-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite 7">
</p>

---

## 📌 Apa itu Samsat Monitoring?

**Samsat Monitoring** adalah aplikasi web yang dibuat untuk membantu kantor Samsat dalam mengelola dan memantau proses penagihan pajak kendaraan bermotor. Bayangkan aplikasi ini seperti sebuah "pusat komando" digital — di mana petugas bisa melihat siapa saja wajib pajak yang menunggak, tugas penagihan mana yang sudah atau belum dikerjakan, dan mengirimkan pengingat otomatis lewat WhatsApp, semuanya dari satu layar.

Dengan aplikasi ini, proses yang sebelumnya dilakukan secara manual (mencatat di kertas, menelepon satu per satu, atau melacak status lewat spreadsheet) kini bisa dilakukan secara **terorganisir** dan **transparan**. Atasan bisa langsung melihat perkembangan kinerja tim di dashboard, dan petugas lapangan bisa langsung tahu mana tugas yang perlu diprioritaskan.

### ✨ Fitur Utama (Ringkas)

| Fitur | Deskripsi |
|---|---|
| 📊 **Dashboard** | Ringkasan data: total tunggakan, tugas, performa petugas, tren follow-up, dan status kendaraan — semua dalam satu halaman. |
| 📋 **Monitoring Penagihan** | Daftar tunggakan wajib pajak, pembuatan & pengelolaan tugas penagihan, pencatatan follow-up dan status kendaraan. |
| 📱 **Reminder WhatsApp** | Pengiriman pesan pengingat otomatis ke wajib pajak melalui WhatsApp, lengkap dengan alur persetujuan. |
| 📂 **Import Data** | Unggah data tunggakan dan kendaraan dari file Excel/CSV. |
| 🔐 **Manajemen Pengguna** | Kelola akun petugas dengan pembagian peran: Admin, Supervisor, dan Operator. |
| 📈 **Kinerja Petugas** | Pantau jumlah tugas dan tindak lanjut yang dikerjakan setiap petugas. |
| 📝 **Audit Trail** | Catatan otomatis setiap perubahan data untuk keperluan akuntabilitas. |

---

## 🔧 Detail Teknis

Bagian ini ditujukan untuk tim IT / developer yang ingin menjalankan, mengembangkan, atau melakukan deployment aplikasi.

### Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | **Laravel 12** (PHP 8.2+) |
| Frontend | **Blade** + **Tailwind CSS 4** (via Vite 7) |
| Database | **MySQL 8.0** |
| Queue / Cache / Session | **Database** driver (bawaan Laravel) |
| WhatsApp API | **Fonnte** (pluggable, via environment config) |
| Build Tool | **Vite 7** + `laravel-vite-plugin` |

### Arsitektur Aplikasi

```
app/
├── Http/
│   ├── Controllers/         # Controller per modul (Dashboard, Arrears, Task, Reminder, dll)
│   └── Middleware/
│       └── RoleMiddleware    # Middleware otorisasi berbasis role (admin, supervisor, operator)
├── Models/                  # Eloquent Models (14 model)
│   ├── Taxpayer              → Data wajib pajak
│   ├── Vehicle               → Data kendaraan
│   ├── ArrearsItem           → Item tunggakan pajak
│   ├── Task                  → Tugas penagihan
│   ├── Followup              → Tindak lanjut penagihan
│   ├── VehicleStatus         → Status kendaraan hasil follow-up
│   ├── Employee              → Data pegawai
│   ├── ReminderRule          → Aturan pengiriman reminder
│   ├── ReminderBatch         → Batch pengiriman reminder (approval flow)
│   ├── ReminderItem          → Item per-WP dalam batch
│   ├── MessageLog            → Log pengiriman pesan WhatsApp
│   ├── SpsopkbLetter         → Surat SPSOPKB
│   ├── AuditTrail            → Audit trail perubahan data
│   └── User                  → Akun pengguna + role helper
database/
├── migrations/              # 16 migration files
└── seeders/
    ├── DatabaseSeeder        # Seeder utama
    └── DummyDataSeeder       # Dummy data untuk development
resources/views/
├── dashboard/               # Halaman dashboard
├── monitoring/              # Halaman monitoring penagihan
├── reminder/                # Halaman reminder WhatsApp
├── import/                  # Halaman import data
├── admin/                   # Halaman manajemen pengguna
├── layouts/                 # Layout & navigation
└── components/              # Blade components reusable
```

### Role & Permissions

| Role | Akses |
|---|---|
| `admin` | Akses penuh: user management, reminder rules, import data, approval batch, semua fitur monitoring |
| `supervisor` | Monitoring penagihan, approval/reject batch reminder, kinerja petugas |
| `operator` | Monitoring penagihan, import data, buat batch reminder, input follow-up |

### Modul Routing

| Prefix | Modul | Middleware |
|---|---|---|
| `/` | Dashboard | `auth` |
| `/monitoring` | Arrears, Tasks, Follow-up, Vehicle Status, Kinerja, SPSOPKB | `auth` |
| `/import` | Import Excel/CSV | `auth`, `role:admin,operator` |
| `/reminder` | Taxpayers, Vehicles, Rules, Batches, Message Logs | `auth` (rules: `role:admin`, approval: `role:admin,supervisor`) |
| `/admin` | User Management | `auth`, `role:admin` |

---

## 🚀 Instalasi & Setup

### Prasyarat

- **PHP** ≥ 8.2 (beserta ekstensi: `mbstring`, `xml`, `curl`, `mysql`)
- **Composer** ≥ 2.x
- **Node.js** ≥ 18.x & **npm**
- **MySQL** ≥ 8.0
- **Git**

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/<username>/samsat-monitoring.git
cd samsat-monitoring

# 2. Install dependency PHP
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di .env
#    Sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Jalankan migrasi database
php artisan migrate

# 7. (Opsional) Isi data dummy untuk development
php artisan db:seed

# 8. Install dependency frontend
npm install

# 9. Build asset frontend
npm run build
```

### Menjalankan Aplikasi (Development)

```bash
# Cara cepat — jalankan semua servis secara bersamaan:
composer dev

# Atau jalankan manual satu per satu:
php artisan serve          # Server Laravel di http://localhost:8000
npm run dev                # Vite dev server (hot-reload)
php artisan queue:listen   # Queue worker
```

### Konfigurasi WhatsApp (Fonnte)

Tambahkan konfigurasi berikut di file `.env`:

```env
WA_PROVIDER=fonnte
WA_API_URL=https://api.fonnte.com/send
WA_API_TOKEN=your_api_token_here
WA_WEBHOOK_SECRET=your_webhook_secret
WA_RATE_LIMIT_PER_HOUR=100
```

### Konfigurasi Overdue Alert

```env
OVERDUE_WARNING_DAYS=7       # Tugas dianggap 'warning' setelah 7 hari tanpa follow-up
OVERDUE_CRITICAL_DAYS=14     # Tugas dianggap 'critical' setelah 14 hari tanpa follow-up
```

---

## 🧪 Testing

```bash
# Jalankan semua test
composer test

# Atau langsung:
php artisan test
```

---

## 📁 Struktur Environment Variables

| Variable | Keterangan | Contoh |
|---|---|---|
| `DB_CONNECTION` | Driver database | `mysql` |
| `DB_DATABASE` | Nama database | `samsat_monitoring` |
| `WA_PROVIDER` | Provider WhatsApp | `fonnte` |
| `WA_API_TOKEN` | API token WhatsApp | `(rahasia)` |
| `OVERDUE_WARNING_DAYS` | Batas hari warning | `7` |
| `OVERDUE_CRITICAL_DAYS` | Batas hari critical | `14` |

---

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch fitur baru: `git checkout -b fitur/nama-fitur`
3. Commit perubahan: `git commit -m "Menambahkan fitur XYZ"`
4. Push ke branch: `git push origin fitur/nama-fitur`
5. Buat Pull Request

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">
  Dibuat dengan ❤️ oleh Tim Magang — 2025
</p>
