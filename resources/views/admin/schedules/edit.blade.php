@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.schedules.index') }}" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold">Edit Jadwal</h1>
            <p class="text-slate-400">{{ $schedule->route->origin }} → {{ $schedule->route->destination }} ({{ $schedule->departure_date->format('d M Y') }})</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST" class="max-w-3xl">
        @csrf
        @method('PUT')

        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-purple-500/10 to-pink-500/10 border-b border-white/10 px-6 py-4">
                <h3 class="font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Informasi Jadwal
                </h3>
            </div>

            <!-- Form Body -->
            <div class="p-6 space-y-6">

                <!-- Pilih Armada -->
                <div>
                    <label for="bus_id" class="block text-sm font-medium text-slate-300 mb-2">
                        Pilih Armada <span class="text-red-400">*</span>
                    </label>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($buses as $bus)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="bus_id" value="{{ $bus->id }}" class="peer sr-only" {{ old('bus_id', $schedule->bus_id) == $bus->id ? 'checked' : '' }} required>
                            <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-sky-500 peer-checked:bg-sky-500/10 hover:border-white/20 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500/20 to-indigo-500/20 border border-white/10 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold">{{ $bus->name }}</p>
                                        <p class="text-xs text-slate-400 font-mono">{{ $bus->plate_number }}</p>
                                        <p class="text-xs text-sky-400 mt-1">{{ $bus->capacity }} kursi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-white/20 peer-checked:border-sky-500 peer-checked:bg-sky-500 flex items-center justify-center transition-all">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('bus_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilih Rute -->
                <div>
                    <label for="route_id" class="block text-sm font-medium text-slate-300 mb-2">
                        Pilih Rute <span class="text-red-400">*</span>
                    </label>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($routes as $route)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="route_id" value="{{ $route->id }}" class="peer sr-only" {{ old('route_id', $schedule->route_id) == $route->id ? 'checked' : '' }} required>
                            <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-indigo-500 peer-checked:bg-indigo-500/10 hover:border-white/20 transition-all">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="font-medium">{{ $route->origin }}</span>
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                    <span class="font-medium">{{ $route->destination }}</span>
                                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-slate-400">
                                    @if($route->distance)
                                    <span>{{ $route->distance }} km</span>
                                    @endif
                                    @if($route->duration)
                                    <span>{{ $route->duration }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-white/20 peer-checked:border-indigo-500 peer-checked:bg-indigo-500 flex items-center justify-center transition-all">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('route_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Keberangkatan -->
                <div>
                    <label for="departure_date" class="block text-sm font-medium text-slate-300 mb-2">
                        Tanggal Keberangkatan <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2">
                            <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="date" 
                               id="departure_date" 
                               name="departure_date" 
                               value="{{ old('departure_date', $schedule->departure_date->format('Y-m-d')) }}" 
                               required
                               class="w-full pl-14 pr-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                    </div>
                    @error('departure_date')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Berangkat & Tiba -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Jam Berangkat -->
                    <div>
                        <label for="departure_time" class="block text-sm font-medium text-slate-300 mb-2">
                            Jam Berangkat <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <input type="time" 
                                   id="departure_time" 
                                   name="departure_time" 
                                   value="{{ old('departure_time', \Carbon\Carbon::parse($schedule->departure_time)->format('H:i')) }}" 
                                   required
                                   class="w-full pl-14 pr-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>
                        @error('departure_time')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Tiba -->
                    <div>
                        <label for="arrival_time" class="block text-sm font-medium text-slate-300 mb-2">
                            Estimasi Jam Tiba <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <input type="time" 
                                   id="arrival_time" 
                                   name="arrival_time" 
                                   value="{{ old('arrival_time', \Carbon\Carbon::parse($schedule->arrival_time)->format('H:i')) }}" 
                                   required
                                   class="w-full pl-14 pr-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>
                        @error('arrival_time')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Harga -->
                <div>
                    <label for="price" class="block text-sm font-medium text-slate-300 mb-2">
                        Harga Tiket per Kursi <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">Rp</div>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $schedule->price) }}" 
                               required
                               min="0"
                               step="1000"
                               class="w-full pl-14 pr-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                    </div>
                    @error('price')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview Harga -->
                <div class="p-4 rounded-xl bg-gradient-to-r from-emerald-500/10 to-teal-500/10 border border-emerald-500/20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-emerald-300">Preview Harga</p>
                                <p class="text-xs text-slate-400">Harga tiket per kursi</p>
                            </div>
                        </div>
                        <p id="pricePreview" class="text-2xl font-bold text-emerald-400">{{ $schedule->formatted_price }}</p>
                    </div>
                </div>

                <!-- Kursi Tersedia Info -->
                <div class="p-4 rounded-xl bg-sky-500/10 border border-sky-500/20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-sky-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-sky-300">Kursi Tersedia</p>
                                <p class="text-xs text-slate-400">Dari total {{ $schedule->bus->capacity }} kursi</p>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-sky-400">{{ $schedule->available_seats }}</p>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-3">
                        Status <span class="text-red-400">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="active" class="peer sr-only" {{ old('status', $schedule->status) === 'active' ? 'checked' : '' }} required>
                            <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 hover:border-white/20 transition-all text-center">
                                <div class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-sm">Aktif</p>
                            </div>
                            <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-white/20 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-all">
                                <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="cancelled" class="peer sr-only" {{ old('status', $schedule->status) === 'cancelled' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-red-500 peer-checked:bg-red-500/10 hover:border-white/20 transition-all text-center">
                                <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-sm">Dibatalkan</p>
                            </div>
                            <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-white/20 peer-checked:border-red-500 peer-checked:bg-red-500 flex items-center justify-center transition-all">
                                <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="completed" class="peer sr-only" {{ old('status', $schedule->status) === 'completed' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-sky-500 peer-checked:bg-sky-500/10 hover:border-white/20 transition-all text-center">
                                <div class="w-10 h-10 rounded-lg bg-sky-500/20 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-sm">Selesai</p>
                            </div>
                            <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-white/20 peer-checked:border-sky-500 peer-checked:bg-sky-500 flex items-center justify-center transition-all">
                                <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                            </div>
                        </label>
                    </div>
                    @error('status')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warning jika ada booking -->
                @if($schedule->bookings->count() > 0)
                <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/20">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-amber-300">Perhatian</p>
                            <p class="text-sm text-amber-200/70">
                                Jadwal ini memiliki <strong>{{ $schedule->bookings->count() }} booking</strong>. 
                                Perubahan pada jadwal dapat mempengaruhi penumpang yang sudah memesan.
                            </p>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- Form Footer -->
            <div class="bg-white/5 border-t border-white/10 px-6 py-4 flex items-center justify-between">
                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-xl bg-red-500/20 hover:bg-red-500/30 text-red-400 font-medium border border-red-500/30 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Jadwal
                    </button>
                </form>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.schedules.index') }}" class="px-6 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 font-medium transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 text-white font-semibold shadow-lg shadow-sky-500/25 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Jadwal
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

@push('scripts')
<script>
    // Price preview
    const priceInput = document.getElementById('price');
    const pricePreview = document.getElementById('pricePreview');
    
    if (priceInput && pricePreview) {
        function updatePricePreview() {
            const value = parseInt(priceInput.value) || 0;
            pricePreview.textContent = 'Rp ' + value.toLocaleString('id-ID');
        }
        
        priceInput.addEventListener('input', updatePricePreview);
    }
</script>
@endpush
@endsection