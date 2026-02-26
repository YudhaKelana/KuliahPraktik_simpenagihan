<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ArrearsItem extends Model
{
    protected $fillable = [
        'plate_number',
        'registration_number',
        'owner_name',
        'phone',
        'address',
        'district',
        'sub_district',
        'postal_code',
        'arrears_amount',
        'arrears_years',
        'calculation_date',
        'vehicle_type',
        'vehicle_brand',
        'vehicle_year',
        'notes',
        'flag_phone_invalid',
        'flag_address_suspect',
        'import_batch',
    ];

    protected function casts(): array
    {
        return [
            'arrears_amount' => 'decimal:2',
            'arrears_years' => 'integer',
            'calculation_date' => 'date',
            'vehicle_year' => 'integer',
            'flag_phone_invalid' => 'boolean',
            'flag_address_suspect' => 'boolean',
        ];
    }

    public function task(): HasOne
    {
        return $this->hasOne(Task::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // --- Masking ---
    public function getMaskedPhoneAttribute(): string
    {
        if (empty($this->phone)) {
            return '-';
        }
        $len = strlen($this->phone);
        if ($len <= 4) {
            return str_repeat('*', $len);
        }
        return substr($this->phone, 0, 4) . str_repeat('*', $len - 7) . substr($this->phone, -3);
    }

    // --- Data quality ---
    public function getIsDataIncompleteAttribute(): bool
    {
        return $this->flag_phone_invalid || $this->flag_address_suspect || empty($this->phone);
    }
}
