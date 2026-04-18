# Database Seeders

## ReminderDataSeeder

Seeder untuk data reminder system dengan fokus pada testing batch reminder ke depan.

### Data yang di-generate:

#### 1. Taxpayers (25 WP)
- **22 WP Valid**: Siap menerima reminder (nomor telepon valid, tidak opt-out)
- **3 WP Khusus**: Akan di-skip saat batch reminder
  - 1 WP tanpa nomor telepon
  - 1 WP opt-out
  - 1 WP dengan nomor telepon invalid

#### 2. Vehicles (28 Kendaraan)

Distribusi berdasarkan jatuh tempo:

| Kategori | Jumlah | Offset Hari | Keterangan |
|----------|--------|-------------|------------|
| Urgent | 3 | 1-3 hari | Ideal untuk H-1 reminder |
| H-7 | 5 | 5-7 hari | Ideal untuk H-7 reminder |
| Medium | 3 | 10-14 hari | Testing range menengah |
| Long | 3 | 20-30 hari | Testing range panjang |
| Very Long | 2 | 45-60 hari | Testing range sangat panjang |
| Special | 3 | 7 hari | WP dengan kondisi khusus (skip) |
| Paid | 2 | 7-10 hari | Sudah bayar (tidak masuk batch) |
| Additional | 7 | 8-22 hari | Variasi tambahan |

**Total**: 26 unpaid, 2 paid

#### 3. Multiple Vehicles
Beberapa WP memiliki 2 kendaraan untuk testing:
- Andi Wijaya: 2 kendaraan (jatuh tempo berbeda)
- Siti Nurhaliza: 2 kendaraan
- Rina Kusuma: 2 kendaraan

### Cara Menggunakan

```bash
# Fresh migration + seed
php artisan migrate:fresh --seed

# Atau seed saja
php artisan db:seed --class=ReminderDataSeeder
```

### Testing Scenario

1. **Buat Batch H-7**
   - Filter: 5-7 hari dari sekarang
   - Expected: ~5 kendaraan masuk batch
   - Expected skip: 3 kendaraan (phone invalid/opt-out)

2. **Buat Batch H-1**
   - Filter: 1-3 hari dari sekarang
   - Expected: ~3 kendaraan masuk batch

3. **Buat Batch Range Lebar**
   - Filter: 1-30 hari dari sekarang
   - Expected: ~20+ kendaraan masuk batch
   - Expected skip: 3 kendaraan dengan kondisi khusus
   - Kendaraan paid tidak akan masuk

### Format Nomor Telepon

Semua nomor menggunakan format E.164: `+6281234567XXX`

Ini memastikan kompatibilitas dengan WhatsApp API.
