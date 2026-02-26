<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpsopkbLetter extends Model
{
    protected $fillable = [
        'task_id',
        'letter_number',
        'issued_date',
        'paid_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'issued_date' => 'date',
            'paid_date' => 'date',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
