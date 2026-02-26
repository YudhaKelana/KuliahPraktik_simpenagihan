<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    protected $fillable = [
        'arrears_item_id',
        'employee_id',
        'status',
        'assigned_date',
        'due_date',
        'completed_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'assigned_date' => 'date',
            'due_date' => 'date',
            'completed_date' => 'date',
        ];
    }

    // --- Relationships ---
    public function arrearsItem(): BelongsTo
    {
        return $this->belongsTo(ArrearsItem::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function followups(): HasMany
    {
        return $this->hasMany(Followup::class);
    }

    public function latestFollowup(): HasOne
    {
        return $this->hasOne(Followup::class)->latestOfMany();
    }

    public function vehicleStatuses(): HasMany
    {
        return $this->hasMany(VehicleStatus::class);
    }

    public function latestVehicleStatus(): HasOne
    {
        return $this->hasOne(VehicleStatus::class)->latestOfMany();
    }

    public function spsopkbLetter(): HasOne
    {
        return $this->hasOne(SpsopkbLetter::class);
    }

    // --- Computed flags ---
    public function getAgeDaysAttribute(): int
    {
        return $this->assigned_date
            ? $this->assigned_date->diffInDays(now())
            : 0;
    }

    public function getDaysSinceLastFollowupAttribute(): ?int
    {
        $latest = $this->latestFollowup;
        if (!$latest) {
            return null;
        }
        return Carbon::parse($latest->followup_date)->diffInDays(now());
    }

    public function getOverdueLevelAttribute(): ?string
    {
        if ($this->status === 'done') {
            return null;
        }

        $hasFollowup = $this->followups()->exists();
        if ($hasFollowup) {
            return null;
        }

        $age = $this->age_days;
        $critical = config('samsat.overdue_critical_days', 14);
        $warning = config('samsat.overdue_warning_days', 7);

        if ($age >= $critical) {
            return 'critical';
        }
        if ($age >= $warning) {
            return 'warning';
        }

        return null;
    }

    public function getIsMissingStatusAttribute(): bool
    {
        return $this->followups()->exists() && !$this->vehicleStatuses()->exists();
    }

    public function getIsSpsopkbCandidateAttribute(): bool
    {
        if ($this->status === 'done') {
            return false;
        }

        $minFollowups = config('samsat.spsopkb_min_followups', 2);
        $minAge = config('samsat.spsopkb_min_age_days', 14);

        return $this->followups()->count() >= $minFollowups
            && $this->age_days >= $minAge;
    }
}
