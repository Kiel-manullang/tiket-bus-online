<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::latest()->paginate(10);
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.buses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'plate_number' => ['required', 'string', 'max:20', 'unique:buses,plate_number'],
            'capacity' => ['required', 'integer', 'min:1', 'max:50'],
            'facilities' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status' => ['required', 'in:active,inactive,maintenance'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('buses', 'public');
        }

        Bus::create($validated);

        return redirect()->route('admin.buses.index')
            ->with('success', 'Armada berhasil ditambahkan.');
    }

    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'plate_number' => ['required', 'string', 'max:20', 'unique:buses,plate_number,' . $bus->id],
            'capacity' => ['required', 'integer', 'min:1', 'max:50'],
            'facilities' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status' => ['required', 'in:active,inactive,maintenance'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('buses', 'public');
        }

        $bus->update($validated);

        return redirect()->route('admin.buses.index')
            ->with('success', 'Armada berhasil diperbarui.');
    }

    public function destroy(Bus $bus)
    {
        if ($bus->schedules()->exists()) {
            return back()->with('error', 'Armada tidak dapat dihapus karena memiliki jadwal.');
        }

        $bus->delete();

        return redirect()->route('admin.buses.index')
            ->with('success', 'Armada berhasil dihapus.');
    }
}