<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.payment');
    }

    public function update(Request $request)
    {
        $request->validate([
            'qris_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('qris_image')) {
            // Simpan gambar dengan nama tetap 'qris.jpg' agar mudah dipanggil
            $request->file('qris_image')->storeAs('settings', 'qris.jpg', 'public');
        }

        return back()->with('success', 'Gambar QRIS berhasil diperbarui! User sekarang akan melihat gambar baru ini.');
    }
}