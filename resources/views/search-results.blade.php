@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <!-- Search Form -->
    <section class="bg-white/5 border border-white/10 rounded-2xl p-6">
        <form action="{{ route('search') }}" method="GET">
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Dari</label>
                    <select name="origin" required class="w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white focus:outline-none focus:border-sky-500/50">
                        <option value="">Pilih Kota Asal</option>
                        @foreach($routes->unique('origin') as $route)
                            <option value="{{ $route->origin }}" {{ ($validated['origin'] ?? '') == $route->origin ? 'selected' : '' }}>{{ $route->origin }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Ke</label>
                    <select name="destination" required class="w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white focus:outline-none focus:border-sky-500/50">
                        <option value="">Pilih Kota Tujuan</option>
                        @foreach($routes->unique('destination') as $route)
                            <option value="{{ $route->destination }}" {{ ($validated['destination'] ?? '') == $route->destination ? 'selected' : '' }}>{{ $route->destination }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" value="{{ $validated['date'] ?? date('Y-m-d') }}"
                           class="w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white focus:outline-none focus:border-sky-500/50">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-3 px-6 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 shadow-lg shadow-sky-500/25 btn-glow transition-all">
                        Cari Ulang
                    </button>
                </div>
            </div>
        </form>
    </section>

    <!-- Results -->
    <section>
        <h2 class="text-2xl font-bold mb-6">
            Hasil Pencarian: {{ $validated['origin'] }} → {{ $validated['destination'] }}
            <span class="text-slate-400 text-lg font-normal">({{ \Carbon\Carbon::parse($validated['date'])->format('d M Y') }})</span>
        </h2>

        @if($schedules->count() > 0)
            <div class="space-y-4">
                @foreach($schedules as $schedule)
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6 card-hover">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-xl bg-sky-500/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold">{{ $schedule->bus->name }}</h3>
                                    <p class="text-sm text-slate-400">{{ $schedule->bus->plate_number }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-6 text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl font-bold">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</span>
                                    <span class="text-slate-400">{{ $schedule->route->origin }}</span>
                                </div>
                                <div class="flex-1 border-t border-dashed border-white/20 relative">
                                    <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-navy-950 px-2 text-xs text-slate-400">
                                        {{ $schedule->route->duration ?? '~' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl font-bold">{{ \Carbon\Carbon::parse($schedule->arrival_time)->format('H:i') }}</span>
                                    <span class="text-slate-400">{{ $schedule->route->destination }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                    {{ $schedule->available_seats }} kursi tersedia
                                </span>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-400">Harga per kursi</p>
                                <p class="text-2xl font-bold text-sky-400">{{ $schedule->formatted_price }}</p>
                            </div>
                            <a href="{{ route('user.bookings.create', $schedule) }}" class="px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 shadow-lg shadow-sky-500/25 btn-glow transition-all">
                                Pilih
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white/5 border border-white/10 rounded-2xl p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-slate-500/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Tidak Ada Jadwal</h3>
                <p class="text-slate-400">Tidak ditemukan jadwal untuk rute dan tanggal yang dipilih. Coba tanggal lain.</p>
            </div>
        @endif
    </section>

</div>
@endsection