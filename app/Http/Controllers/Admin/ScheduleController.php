<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Route;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['bus', 'route'])
            ->latest()
            ->paginate(10);

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $buses = Bus::active()->get();
        $routes = Route::active()->get();

        return view('admin.schedules.create', compact('buses', 'routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id' => ['required', 'exists:buses,id'],
            'route_id' => ['required', 'exists:routes,id'],
            'departure_date' => ['required', 'date', 'after_or_equal:today'],
            'departure_time' => ['required', 'date_format:H:i'],
            'arrival_time' => ['required', 'date_format:H:i', 'after:departure_time'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,cancelled'],
        ]);

        $bus = Bus::findOrFail($validated['bus_id']);
        $validated['available_seats'] = $bus->capacity;

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        $buses = Bus::active()->get();
        $routes = Route::active()->get();

        return view('admin.schedules.edit', compact('schedule', 'buses', 'routes'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'bus_id' => ['required', 'exists:buses,id'],
            'route_id' => ['required', 'exists:routes,id'],
            'departure_date' => ['required', 'date'],
            'departure_time' => ['required', 'date_format:H:i'],
            'arrival_time' => ['required', 'date_format:H:i', 'after:departure_time'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,cancelled,completed'],
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        if ($schedule->bookings()->whereIn('status', ['pending', 'confirmed'])->exists()) {
            return back()->with('error', 'Jadwal tidak dapat dihapus karena memiliki booking aktif.');
        }

        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}