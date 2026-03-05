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

    // --- Role Constants ---
    const ROLE_ADMIN = 'administrator_sistem';
    const ROLE_KOORDINATOR = 'koordinator_penagihan';
    const ROLE_PETUGAS = 'petugas_penagihan';

    const ROLE_LABELS = [
        self::ROLE_ADMIN => 'Administrator Sistem',
        self::ROLE_KOORDINATOR => 'Koordinator Penagihan',
        self::ROLE_PETUGAS => 'Petugas Penagihan',
    ];

    // --- Role helpers ---
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isKoordinator(): bool
    {
        return $this->role === self::ROLE_KOORDINATOR;
    }

    public function isPetugas(): bool
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function hasRole(string|array $roles): bool
    {
        return is_array($roles)
            ? in_array($this->role, $roles)
            : $this->role === $roles;
    }

    public function getRoleLabel(): string
    {
        return self::ROLE_LABELS[$this->role] ?? ucfirst($this->role);
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
