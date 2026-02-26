<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReminderItem extends Model
{
    protected $fillable = [
        'reminder_batch_id',
        'vehicle_id',
        'reminder_rule_id',
        'taxpayer_id',
        'planned_send_at',
        'status',
        'skip_reason',
    ];

    protected function casts(): array
    {
        return [
            'planned_send_at' => 'datetime',
        ];
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(ReminderBatch::class, 'reminder_batch_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(ReminderRule::class, 'reminder_rule_id');
    }

    public function taxpayer(): BelongsTo
    {
        return $this->belongsTo(Taxpayer::class);
    }

    public function messageLogs(): HasMany
    {
        return $this->hasMany(MessageLog::class);
    }
}
