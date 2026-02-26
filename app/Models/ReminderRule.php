<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderRule extends Model
{
    protected $fillable = [
        'name',
        'days_before_due',
        'template_code',
        'template_text',
        'send_window_start',
        'send_window_end',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'days_before_due' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
