<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
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

    // 1-to-Many: User hasMany Report (sebagai pelapor/warga)
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // 1-to-Many: User hasMany StatusHistory (sebagai updater/petugas)
    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class, 'updated_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }
}
