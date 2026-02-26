<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReminderBatch extends Model
{
    protected $fillable = [
        'created_by',
        'approved_by',
        'status',
        'total_items',
        'sent_count',
        'failed_count',
        'skipped_count',
        'filter_description',
        'reject_reason',
        'approved_at',
        'scheduled_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'scheduled_at' => 'datetime',
            'completed_at' => 'datetime',
            'total_items' => 'integer',
            'sent_count' => 'integer',
            'failed_count' => 'integer',
            'skipped_count' => 'integer',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReminderItem::class);
    }

    public function getProgressPercentAttribute(): float
    {
        if ($this->total_items === 0) {
            return 0;
        }
        return round(($this->sent_count + $this->failed_count + $this->skipped_count) / $this->total_items * 100, 1);
    }
}
