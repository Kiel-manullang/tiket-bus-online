<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'schedule.bus', 'schedule.route', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('booking_code', 'like', '%' . $request->search . '%')
                  ->orWhere('passenger_name', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->latest()->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'schedule.bus', 'schedule.route', 'payment']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled,completed'],
        ]);

        $oldStatus = $booking->status;
        $newStatus = $validated['status'];

        // Jika dibatalkan, kembalikan kursi
        if ($newStatus === 'cancelled' && in_array($oldStatus, ['pending', 'confirmed'])) {
            $booking->schedule->increment('available_seats', $booking->total_seats);
        }

        $booking->update(['status' => $newStatus]);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}