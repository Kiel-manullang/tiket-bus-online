@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.dashboard') }}" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold">Pengaturan QRIS</h1>
            <p class="text-slate-400">Upload gambar QRIS toko/rekening Anda</p>
        </div>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('admin.settings.payment.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h3 class="font-bold text-lg mb-4 text-sky-400">Gambar QRIS Saat Ini</h3>
                
                <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl mb-6 w-72 mx-auto shadow-lg">
                    <img src="{{ asset('storage/settings/qris.jpg') }}?v={{ time() }}" 
                         alt="QRIS Code" 
                         class="w-full h-auto object-contain"
                         onerror="this.src='https://placehold.co/400x400/png?text=Belum+Ada+QRIS';">
                         
                    <p class="text-slate-800 text-xs mt-2 font-medium">Scan untuk membayar</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300">Ganti Gambar QRIS</label>
                    <div class="relative border-2 border-dashed border-white/20 hover:border-sky-500/50 rounded-xl p-6 text-center transition-all">
                        <input type="file" name="qris_image" accept="image/jpeg,image/png,image/jpg" required
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-slate-400">
                            <svg class="w-8 h-8 mx-auto mb-2 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm">Klik untuk upload file baru</p>
                            <p class="text-xs mt-1">Format: JPG, PNG (Max 2MB)</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-white/10 text-right">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 text-white font-semibold shadow-lg shadow-sky-500/25 transition-all">
                        Simpan & Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection