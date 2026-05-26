<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.schedule.route']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.user', 'booking.schedule.bus', 'booking.schedule.route']);

        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:verified,rejected'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $payment->update([
            'status' => $validated['status'],
            // FIX: Gunakan ?? null agar tidak error jika notes tidak dikirim
            'notes' => $validated['notes'] ?? null, 
            'verified_at' => now(),
        ]);

        // Update booking status
        if ($validated['status'] === 'verified') {
            $payment->booking->update(['status' => 'confirmed']);
        } elseif ($validated['status'] === 'rejected') {
            // Kembalikan kursi jika ditolak
            $payment->booking->schedule->increment('available_seats', $payment->booking->total_seats);
            $payment->booking->update(['status' => 'cancelled']);
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil ' . ($validated['status'] === 'verified' ? 'diverifikasi' : 'ditolak') . '.');
    }
}