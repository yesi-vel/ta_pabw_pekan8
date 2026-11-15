<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role', // Tambahkan ini
        'password',
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
            //'role' => UserRole::class, // Cast otomatis ke Enum UserRole
        ];
    }

    // Cek apakah user adalah admin
    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    // Cek role user
    public function hasRole(UserRole|string ...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->role === ($role instanceof UserRole ? $role : UserRole::tryFrom($role))) {
                return true;
            }
        }
        return false;
    }
}