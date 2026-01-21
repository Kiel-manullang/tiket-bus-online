<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'otp_code',        // <-- Kolom Baru
        'otp_expires_at',  // <-- Kolom Baru
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code', // Sembunyikan kode OTP biar aman
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime', // Ubah jadi format tanggal
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}