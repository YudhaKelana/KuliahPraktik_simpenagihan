<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'taxpayer_id',
        'plate_number',
        'registration_number',
        'vehicle_type',
        'vehicle_brand',
        'vehicle_year',
        'due_date',
        'status_payment',
        'paid_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'paid_date' => 'date',
            'vehicle_year' => 'integer',
        ];
    }

    public function taxpayer(): BelongsTo
    {
        return $this->belongsTo(Taxpayer::class);
    }

    public function reminderItems(): HasMany
    {
        return $this->hasMany(ReminderItem::class);
    }

    public function getIsPaidAttribute(): bool
    {
        return $this->status_payment === 'paid';
    }
}
