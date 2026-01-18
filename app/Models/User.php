<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, MustVerifyEmailTrait;

    public const ROLE_SUPER_ADMIN = 'super-admin';
    public const ROLE_ADMIN       = 'admin';
    public const ROLE_COLLECTOR   = 'collector';
    public const ROLE_USER        = 'user';

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

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'user_id');
    }

    public function collectedPayments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'collected_by');
    }

    // Role helpers
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

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }
}
