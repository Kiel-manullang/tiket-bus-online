<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_bookings' => $user->bookings()->count(),
            'pending_bookings' => $user->bookings()->where('status', 'pending')->count(),
            'confirmed_bookings' => $user->bookings()->where('status', 'confirmed')->count(),
            'completed_bookings' => $user->bookings()->where('status', 'completed')->count(),
        ];

        $recentBookings = $user->bookings()
            ->with(['schedule.bus', 'schedule.route', 'payment'])
            ->latest()
            ->limit(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentBookings'));
    }
}