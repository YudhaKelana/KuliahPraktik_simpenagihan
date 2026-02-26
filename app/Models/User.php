<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // --- Role helpers ---
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    public function isSupervisor(): bool
    {
        return $this->role === 'supervisor';
    }

    public function hasRole(string|array $roles): bool
    {
        return is_array($roles)
            ? in_array($this->role, $roles)
            : $this->role === $roles;
    }

    // --- Relationships ---
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function createdBatches()
    {
        return $this->hasMany(ReminderBatch::class, 'created_by');
    }

    public function approvedBatches()
    {
        return $this->hasMany(ReminderBatch::class, 'approved_by');
    }

    public function auditTrails()
    {
        return $this->hasMany(AuditTrail::class);
    }
}
