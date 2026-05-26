<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_id',
        'booking_code',
        'passenger_name',
        'passenger_phone',
        'passenger_email',
        'seat_numbers',
        'total_seats',
        'total_price',
        'status',
        'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'seat_numbers' => 'array',
            'total_price' => 'decimal:2',
            'expired_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getSeatsDisplayAttribute(): string
    {
        $seats = is_array($this->seat_numbers) ? $this->seat_numbers : json_decode($this->seat_numbers, true);
        return is_array($seats) ? implode(', ', $seats) : '-';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-amber-500/20 text-amber-400 border-amber-500/30',
            'confirmed' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
            'cancelled' => 'bg-red-500/20 text-red-400 border-red-500/30',
            'completed' => 'bg-sky-500/20 text-sky-400 border-sky-500/30',
            'expired' => 'bg-slate-500/20 text-slate-400 border-slate-500/30',
            default => 'bg-slate-500/20 text-slate-400 border-slate-500/30',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'confirmed' => 'Terkonfirmasi',
            'cancelled' => 'Dibatalkan',
            'completed' => 'Selesai',
            'expired' => 'Kedaluwarsa',
            default => $this->status,
        };
    }

    public static function generateBookingCode(): string
    {
        do {
            $code = 'TKT' . strtoupper(substr(uniqid(), -8));
        } while (self::where('booking_code', $code)->exists());
        
        return $code;
    }
}