<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageLog extends Model
{
    protected $fillable = [
        'reminder_item_id',
        'provider',
        'provider_message_id',
        'phone',
        'message_body',
        'status',
        'error_message',
        'retry_count',
        'sent_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
            'retry_count' => 'integer',
        ];
    }

    public function reminderItem(): BelongsTo
    {
        return $this->belongsTo(ReminderItem::class);
    }
}
