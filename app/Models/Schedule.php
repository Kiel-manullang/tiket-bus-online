<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    protected $fillable = [
        'bus_id',
        'route_id',
        'departure_date',
        'departure_time',
        'arrival_time',
        'price',
        'available_seats',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'departure_date' => 'date',
            'price' => 'decimal:2',
        ];
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->departure_date)->translatedFormat('l, d F Y');
    }

    public function getBookedSeatsAttribute(): array
    {
        $bookedSeats = [];
        $confirmedBookings = $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();
        
        foreach ($confirmedBookings as $booking) {
            $seats = is_array($booking->seat_numbers) ? $booking->seat_numbers : json_decode($booking->seat_numbers, true);
            if (is_array($seats)) {
                $bookedSeats = array_merge($bookedSeats, $seats);
            }
        }
        
        return $bookedSeats;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('departure_date', '>=', now()->toDateString());
    }
}