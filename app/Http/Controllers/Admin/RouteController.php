<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::latest()->paginate(10);
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin' => ['required', 'string', 'max:100'],
            'destination' => ['required', 'string', 'max:100'],
            'distance' => ['nullable', 'integer', 'min:1'],
            'duration' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Route::create($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Rute berhasil ditambahkan.');
    }

    public function edit(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'origin' => ['required', 'string', 'max:100'],
            'destination' => ['required', 'string', 'max:100'],
            'distance' => ['nullable', 'integer', 'min:1'],
            'duration' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $route->update($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Rute berhasil diperbarui.');
    }

    public function destroy(Route $route)
    {
        if ($route->schedules()->exists()) {
            return back()->with('error', 'Rute tidak dapat dihapus karena memiliki jadwal.');
        }

        $route->delete();

        return redirect()->route('admin.routes.index')
            ->with('success', 'Rute berhasil dihapus.');
    }
}