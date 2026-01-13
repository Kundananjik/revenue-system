<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define Role Constants for better code maintenance
    const ROLE_SUPER_ADMIN = 'super-admin';
    const ROLE_ADMIN       = 'admin';
    const ROLE_COLLECTOR   = 'collector';
    const ROLE_CITIZEN     = 'citizen';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relationship: A user can have many payments (as a payer).
     */
    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'user_id');
    }

    /**
     * Relationship: If the user is a collector, they manage many payments.
     */
    public function collectedPayments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'collected_by');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- Role Helpers ---

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCollector(): bool
    {
        return $this->role === self::ROLE_COLLECTOR;
    }

    public function isCitizen(): bool
    {
        return $this->role === self::ROLE_CITIZEN;
    }
}