<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Taxpayer extends Model
{
    protected $fillable = [
        'name',
        'nik',
        'phone_e164',
        'address',
        'district',
        'sub_district',
        'postal_code',
        'opt_out',
        'opt_out_at',
        'flag_phone_invalid',
        'flag_address_suspect',
    ];

    protected function casts(): array
    {
        return [
            'opt_out' => 'boolean',
            'opt_out_at' => 'datetime',
            'flag_phone_invalid' => 'boolean',
            'flag_address_suspect' => 'boolean',
        ];
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function reminderItems(): HasMany
    {
        return $this->hasMany(ReminderItem::class);
    }

    public function getMaskedPhoneAttribute(): string
    {
        if (empty($this->phone_e164)) {
            return '-';
        }
        $phone = $this->phone_e164;
        $len = strlen($phone);
        if ($len <= 4) {
            return str_repeat('*', $len);
        }
        return substr($phone, 0, 4) . str_repeat('*', $len - 7) . substr($phone, -3);
    }
}
