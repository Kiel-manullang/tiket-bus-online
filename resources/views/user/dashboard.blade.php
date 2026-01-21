@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Banner Premium -->
    <section class="relative overflow-hidden rounded-3xl border border-white/10">
        <!-- Animated Background -->
        <div class="absolute inset-0 bg-gradient-to-r from-sky-600/20 via-indigo-600/20 to-purple-600/20"></div>
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-72 h-72 bg-sky-500/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 0.5s;"></div>
        </div>
        
        <!-- Content -->
        <div class="relative p-8 md:p-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <!-- Avatar Premium -->
                    <div class="relative">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-sky-400 via-indigo-500 to-purple-500 p-[2px] shadow-2xl shadow-sky-500/25">
                            <div class="w-full h-full rounded-2xl bg-navy-950 flex items-center justify-center">
                                <span class="text-3xl font-bold gradient-text">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 rounded-full border-4 border-navy-950 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-slate-400 text-sm mb-1">Selamat datang kembali,</p>
                        <h1 class="text-3xl md:text-4xl font-bold">
                            <span class="gradient-text">{{ auth()->user()->name }}</span>
                        </h1>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-sky-500/20 text-sky-300 border border-sky-500/30">
                                ✨ Member Aktif
                            </span>
                            <span class="text-sm text-slate-400">
                                Bergabung {{ auth()->user()->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 shadow-lg shadow-sky-500/25 btn-glow transition-all group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Pesan Tiket Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Cards Premium -->
    <section class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Booking -->
        <div class="group relative overflow-hidden bg-white/5 border border-white/10 rounded-2xl p-6 card-hover">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-500/20 to-sky-600/20 flex items-center justify-center border border-sky-500/20 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                    <div class="flex items-center gap-1 text-emerald-400 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>+{{ $stats['total_bookings'] > 0 ? rand(5, 15) : 0 }}%</span>
                    </div>
                </div>
                <p class="text-4xl font-bold mb-1">{{ $stats['total_bookings'] }}</p>
                <p class="text-sm text-slate-400">Total Booking</p>
            </div>
        </div>

        <!-- Pending -->
        <div class="group relative overflow-hidden bg-white/5 border border-white/10 rounded-2xl p-6 card-hover">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500/20 to-amber-600/20 flex items-center justify-center border border-amber-500/20 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    @if($stats['pending_bookings'] > 0)
                    <span class="flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                    </span>
                    @endif
                </div>
                <p class="text-4xl font-bold mb-1">{{ $stats['pending_bookings'] }}</p>
                <p class="text-sm text-slate-400">Menunggu Pembayaran</p>
            </div>
        </div>

        <!-- Confirmed -->
        <div class="group relative overflow-hidden bg-white/5 border border-white/10 rounded-2xl p-6 card-hover">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 flex items-center justify-center border border-emerald-500/20 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="px-2 py-1 rounded-lg text-xs font-medium bg-emerald-500/20 text-emerald-400">Active</span>
                </div>
                <p class="text-4xl font-bold mb-1">{{ $stats['confirmed_bookings'] }}</p>
                <p class="text-sm text-slate-400">Terkonfirmasi</p>
            </div>
        </div>

        <!-- Completed -->
        <div class="group relative overflow-hidden bg-white/5 border border-white/10 rounded-2xl p-6 card-hover">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-indigo-600/20 flex items-center justify-center border border-indigo-500/20 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold mb-1">{{ $stats['completed_bookings'] }}</p>
                <p class="text-sm text-slate-400">Perjalanan Selesai</p>
            </div>
        </div>
    </section>

    <!-- Quick Actions & Recent Bookings -->
    <div class="grid lg:grid-cols-3 gap-6">
        
        <!-- Quick Actions Premium -->
        <div class="lg:col-span-1">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-sky-500 to-indigo-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </span>
                    Menu Cepat
                </h2>
                
                <div class="space-y-3">
                    <a href="{{ route('home') }}" class="group flex items-center gap-4 p-4 rounded-xl bg-navy-900/50 border border-white/10 hover:bg-white/5 hover:border-sky-500/30 transition-all">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500/20 to-sky-600/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold group-hover:text-sky-400 transition-colors">Cari Jadwal</p>
                            <p class="text-xs text-slate-400">Temukan jadwal bus terbaik</p>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-sky-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <a href="{{ route('user.bookings.index') }}" class="group flex items-center gap-4 p-4 rounded-xl bg-navy-900/50 border border-white/10 hover:bg-white/5 hover:border-indigo-500/30 transition-all">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500/20 to-indigo-600/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold group-hover:text-indigo-400 transition-colors">Riwayat Booking</p>
                            <p class="text-xs text-slate-400">Lihat semua pemesanan Anda</p>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <a href="#" class="group flex items-center gap-4 p-4 rounded-xl bg-navy-900/50 border border-white/10 hover:bg-white/5 hover:border-purple-500/30 transition-all">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold group-hover:text-purple-400 transition-colors">Profil Saya</p>
                            <p class="text-xs text-slate-400">Kelola informasi akun</p>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Premium -->
        <div class="lg:col-span-2">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        Booking Terakhir
                    </h2>
                    <a href="{{ route('user.bookings.index') }}" class="text-sm text-sky-400 hover:text-sky-300 flex items-center gap-1">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                @if($recentBookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentBookings as $booking)
                        <a href="{{ route('user.bookings.show', $booking) }}" class="group block p-4 rounded-xl bg-navy-900/50 border border-white/10 hover:bg-white/5 hover:border-white/20 transition-all">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500/20 to-indigo-500/20 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p class="font-semibold">{{ $booking->schedule->route->origin }} → {{ $booking->schedule->route->destination }}</p>
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium border {{ $booking->status_badge }}">
                                                {{ $booking->status_label }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-3 mt-1 text-sm text-slate-400">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $booking->schedule->departure_date->format('d M Y') }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }}
                                            </span>
                                            <span>Kursi: {{ $booking->seats_display }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-sky-400">{{ $booking->formatted_price }}</p>
                                    <p class="text-xs text-slate-400">{{ $booking->booking_code }}</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 rounded-2xl bg-navy-900/50 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Belum Ada Booking</h3>
                        <p class="text-slate-400 mb-6">Anda belum memiliki riwayat pemesanan tiket</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 shadow-lg shadow-sky-500/25 btn-glow transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Pesan Tiket Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection