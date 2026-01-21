<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Route;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua rute untuk dropdown
        $routes = Route::where('status', 'active')->get();
        
        // Ambil jadwal populer (yang akan datang)
        $popularSchedules = Schedule::with(['bus', 'route'])
            ->where('status', 'active')
            ->whereDate('departure_date', '>=', now()) // Hanya tanggal hari ini ke depan
            ->where('available_seats', '>', 0)
            ->orderBy('departure_date')
            ->limit(6)
            ->get();

        return view('home', compact('routes', 'popularSchedules'));
    }

    public function search(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'origin' => ['required', 'string'],
            'destination' => ['required', 'string'],
            'date' => ['required', 'date'],
        ]);

        // Cari Jadwal
        $schedules = Schedule::with(['bus', 'route'])
            ->where('status', 'active') // Pastikan jadwal aktif
            ->where('available_seats', '>', 0) // Kursi masih ada
            
            // Filter Tanggal (Gunakan whereDate agar format waktu 00:00:00 tidak mengganggu)
            ->whereDate('departure_date', $validated['date'])
            
            // Filter Rute (Asal & Tujuan)
            ->whereHas('route', function ($query) use ($validated) {
                $query->where('status', 'active') // Pastikan rute aktif
                      ->where('origin', 'LIKE', '%' . $validated['origin'] . '%')
                      ->where('destination', 'LIKE', '%' . $validated['destination'] . '%');
            })
            ->orderBy('departure_time')
            ->get();

        // Ambil data rute lagi untuk dropdown di halaman hasil (biar user bisa cari ulang)
        $routes = Route::where('status', 'active')->get();

        return view('search-results', compact('schedules', 'routes', 'validated'));
    }
}