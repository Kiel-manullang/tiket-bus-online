@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.routes.index') }}" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold">Tambah Rute Baru</h1>
            <p class="text-slate-400">Buat rute perjalanan baru</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.routes.store') }}" method="POST" class="max-w-3xl">
        @csrf

        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-indigo-500/10 to-purple-500/10 border-b border-white/10 px-6 py-4">
                <h3 class="font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Informasi Rute
                </h3>
            </div>

            <!-- Form Body -->
            <div class="p-6 space-y-6">

                <!-- Origin & Destination -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Kota Asal -->
                    <div>
                        <label for="origin" class="block text-sm font-medium text-slate-300 mb-2">
                            Kota Asal <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <input type="text" 
                                   id="origin" 
                                   name="origin" 
                                   value="{{ old('origin') }}" 
                                   required
                                   placeholder="Contoh: Jakarta"
                                   class="w-full pl-14 pr-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>
                        @error('origin')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kota Tujuan -->
                    <div>
                        <label for="destination" class="block text-sm font-medium text-slate-300 mb-2">
                            Kota Tujuan <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <input type="text" 
                                   id="destination" 
                                   name="destination" 
                                   value="{{ old('destination') }}" 
                                   required
                                   placeholder="Contoh: Bandung"
                                   class="w-full pl-14 pr-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>
                        @error('destination')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Route Preview -->
                <div class="p-4 rounded-xl bg-gradient-to-r from-emerald-500/10 via-sky-500/10 to-red-500/10 border border-white/10">
                    <div class="flex items-center justify-center gap-4">
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                            </div>
                            <p id="previewOrigin" class="font-semibold text-emerald-400">Asal</p>
                        </div>

                        <div class="flex-1 max-w-xs">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                <div class="flex-1 border-t-2 border-dashed border-white/30 mx-2 relative">
                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-navy-950 px-2">
                                        <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="w-12 h-12 rounded-xl bg-red-500/20 border border-red-500/30 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                            </div>
                            <p id="previewDestination" class="font-semibold text-red-400">Tujuan</p>
                        </div>
                    </div>
                </div>

                <!-- Distance & Duration -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Jarak -->
                    <div>
                        <label for="distance" class="block text-sm font-medium text-slate-300 mb-2">
                            Jarak Tempuh
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   id="distance" 
                                   name="distance" 
                                   value="{{ old('distance') }}" 
                                   min="1"
                                   placeholder="150"
                                   class="w-full px-4 py-3 pr-14 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">km</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Opsional - Jarak dalam kilometer</p>
                        @error('distance')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Durasi -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-slate-300 mb-2">
                            Estimasi Durasi
                        </label>
                        <input type="text" 
                               id="duration" 
                               name="duration" 
                               value="{{ old('duration') }}" 
                               placeholder="3 jam 30 menit"
                               class="w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        <p class="text-xs text-slate-500 mt-1">Opsional - Contoh: 3 jam 30 menit</p>
                        @error('duration')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-3">
                        Status <span class="text-red-400">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="active" class="peer sr-only" {{ old('status', 'active') === 'active' ? 'checked' : '' }} required>
                            <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 hover:border-white/20 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Aktif</p>
                                        <p class="text-xs text-slate-400">Rute dapat digunakan untuk jadwal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-white/20 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-all">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="inactive" class="peer sr-only" {{ old('status') === 'inactive' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-slate-500 peer-checked:bg-slate-500/10 hover:border-white/20 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-slate-500/20 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Nonaktif</p>
                                        <p class="text-xs text-slate-400">Rute tidak akan muncul di jadwal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-white/20 peer-checked:border-slate-500 peer-checked:bg-slate-500 flex items-center justify-center transition-all">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                            </div>
                        </label>
                    </div>
                    @error('status')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Form Footer -->
            <div class="bg-white/5 border-t border-white/10 px-6 py-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.routes.index') }}" class="px-6 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 font-medium transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 text-white font-semibold shadow-lg shadow-sky-500/25 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Rute
                </button>
            </div>
        </div>
    </form>

</div>

@push('scripts')
<script>
    // Live preview for route
    const originInput = document.getElementById('origin');
    const destinationInput = document.getElementById('destination');
    const previewOrigin = document.getElementById('previewOrigin');
    const previewDestination = document.getElementById('previewDestination');

    originInput.addEventListener('input', function() {
        previewOrigin.textContent = this.value || 'Asal';
    });

    destinationInput.addEventListener('input', function() {
        previewDestination.textContent = this.value || 'Tujuan';
    });
</script>
@endpush
@endsection