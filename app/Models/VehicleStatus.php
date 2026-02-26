<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleStatus extends Model
{
    protected $fillable = [
        'task_id',
        'status',
        'status_date',
        'notes',
        'reported_by',
    ];

    protected function casts(): array
    {
        return [
            'status_date' => 'date',
        ];
    }

    public const STATUSES = [
        'dimiliki' => 'Dimiliki',
        'lapor_jual' => 'Lapor Jual',
        'rusak_berat' => 'Rusak Berat',
        'hilang' => 'Hilang',
        'kecelakaan' => 'Kecelakaan (Laka)',
        'alamat_tidak_jelas' => 'Alamat Tidak Jelas',
        'pindah_alamat' => 'Pindah Alamat',
        'rumah_kosong' => 'Rumah Kosong',
        'lainnya' => 'Lainnya',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'reported_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
