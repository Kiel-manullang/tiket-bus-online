@extends('layouts.app')

@section('content')
<div class="space-y-12">
    
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-sky-500/20 via-indigo-500/20 to-purple-500/20 border border-white/10 p-8 md:p-12">
        <div class="absolute top-0 right-0 w-64 h-64 bg-sky-500/20 rounded-full blur-3xl"></div>
        <div class="relative">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">
                Pesan Tiket Bus<br>
                <span class="gradient-text">Kapan Saja, Di Mana Saja</span>
            </h1>
            <p class="text-slate-300 text-lg max-w-xl mb-8">
                Nikmati perjalanan nyaman dengan pemesanan tiket bus online. Cepat, mudah, dan terpercaya.
            </p>

            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="bg-navy-900/50 border border-white/10 rounded-2xl p-6">
                <div class="grid md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Dari</label>
                        <select name="origin" required class="w-full px-4 py-3 rounded-xl bg-navy-950/50 border border-white/10 text-white focus:outline-none focus:border-sky-500/50">
                            <option value="">Pilih Kota Asal</option>
                            @foreach($routes->unique('origin') as $route)
                                <option value="{{ $route->origin }}">{{ $route->origin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Ke</label>
                        <select name="destination" required class="w-full px-4 py-3 rounded-xl bg-navy-950/50 border border-white/10 text-white focus:outline-none focus:border-sky-500/50">
                            <option value="">Pilih Kota Tujuan</option>
                            @foreach($routes->unique('destination') as $route)
                                <option value="{{ $route->destination }}">{{ $route->destination }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal</label>
                        <input type="date" name="date" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-3 rounded-xl bg-navy-950/50 border border-white/10 text-white focus:outline-none focus:border-sky-500/50">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full py-3 px-6 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 shadow-lg shadow-sky-500/25 btn-glow transition-all">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari Tiket
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Features -->
    <section>
        <h2 class="text-2xl font-bold mb-6 text-center">Mengapa Memilih Kami?</h2>
        <div class="grid md:grid-cols-4 gap-4">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 text-center card-hover">
                <div class="w-14 h-14 rounded-2xl bg-sky-500/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Booking Instan</h3>
                <p class="text-sm text-slate-400">Proses pemesanan cepat dan mudah</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 text-center card-hover">
                <div class="w-14 h-14 rounded-2xl bg-indigo-500/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Pembayaran Aman</h3>
                <p class="text-sm text-slate-400">Transaksi dijamin keamanannya</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 text-center card-hover">
                <div class="w-14 h-14 rounded-2xl bg-purple-500/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Pilih Kursi</h3>
                <p class="text-sm text-slate-400">Bebas pilih kursi favorit Anda</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 text-center card-hover">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">E-Ticket</h3>
                <p class="text-sm text-slate-400">Tiket digital langsung di HP Anda</p>
            </div>
        </div>
    </section>

    <!-- Popular Schedules -->
    @if($popularSchedules->count() > 0)
    <section>
        <h2 class="text-2xl font-bold mb-6">Jadwal Tersedia</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($popularSchedules as $schedule)
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 card-hover">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-sm text-slate-400">{{ $schedule->bus->name }}</p>
                        <h3 class="font-semibold text-lg">{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</h3>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        {{ $schedule->available_seats }} kursi
                    </span>
                </div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-sm text-slate-300">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $schedule->departure_date->format('d M Y') }}
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-300">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->arrival_time)->format('H:i') }}
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-white/10">
                    <div>
                        <p class="text-xs text-slate-400">Harga mulai</p>
                        <p class="text-xl font-bold text-sky-400">{{ $schedule->formatted_price }}</p>
                    </div>
                    <a href="{{ route('user.bookings.create', $schedule) }}" class="px-4 py-2 rounded-xl font-medium text-white bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 shadow-lg shadow-sky-500/25 transition-all">
                        Pesan
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection