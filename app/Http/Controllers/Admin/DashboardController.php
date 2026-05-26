<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_buses' => Bus::count(),
            'total_routes' => Route::count(),
            'total_schedules' => Schedule::count(),
            'total_bookings' => Booking::count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_revenue' => Payment::where('status', 'verified')->sum('amount'),
            'today_bookings' => Booking::whereDate('created_at', today())->count(),
        ];

        $recentBookings = Booking::with(['user', 'schedule.bus', 'schedule.route', 'payment'])
            ->latest()
            ->limit(10)
            ->get();

        $pendingPayments = Payment::with(['booking.user', 'booking.schedule.route'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'pendingPayments'));
    }
}