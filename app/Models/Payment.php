<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'payment_method',
        'payment_proof',
        'amount',
        'status',
        'notes',
        'paid_at',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'transfer_bca' => 'Transfer BCA',
            'transfer_bni' => 'Transfer BNI',
            'transfer_bri' => 'Transfer BRI',
            'transfer_mandiri' => 'Transfer Mandiri',
            'ewallet_dana' => 'DANA',
            'ewallet_gopay' => 'GoPay',
            'ewallet_ovo' => 'OVO',
            default => $this->payment_method,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-amber-500/20 text-amber-400 border-amber-500/30',
            'verified' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
            'rejected' => 'bg-red-500/20 text-red-400 border-red-500/30',
            default => 'bg-slate-500/20 text-slate-400 border-slate-500/30',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }
}