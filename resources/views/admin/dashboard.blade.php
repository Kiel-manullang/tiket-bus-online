@extends('layouts.app')

@section('content')
<div class="space-y-8">

    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-500/20 via-purple-500/20 to-pink-500/20 border border-white/10 p-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Admin Dashboard</h1>
                    <p class="text-slate-300 mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.schedules.create') }}" class="px-4 py-2 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 text-sm font-semibold shadow-lg shadow-sky-500/25 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Jadwal
                </a>
                <a href="{{ route('admin.payments.index') }}?status=pending" class="px-4 py-2 rounded-xl bg-amber-500/20 hover:bg-amber-500/30 border border-amber-500/30 text-amber-300 text-sm font-medium transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $stats['pending_payments'] ?? 0 }} Menunggu Verifikasi
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Users -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 card-hover">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-500/20 to-sky-500/10 border border-sky-500/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_users'] ?? 0) }}</p>
                    <p class="text-sm text-slate-400">Total User</p>
                </div>
            </div>
        </div>

        <!-- Total Buses -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 card-hover">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-indigo-500/10 border border-indigo-500/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_buses'] ?? 0) }}</p>
                    <p class="text-sm text-slate-400">Armada</p>
                </div>
            </div>
        </div>

        <!-- Total Routes -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 card-hover">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500/20 to-purple-500/10 border border-purple-500/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_routes'] ?? 0) }}</p>
                    <p class="text-sm text-slate-400">Rute</p>
                </div>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 card-hover">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-emerald-500/10 border border-emerald-500/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_bookings'] ?? 0) }}</p>
                    <p class="text-sm text-slate-400">Total Booking</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue & Today Stats -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Revenue Card -->
        <div class="bg-gradient-to-br from-emerald-500/10 via-teal-500/10 to-cyan-500/10 border border-emerald-500/20 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Total Pendapatan
                </h3>
                <span class="text-xs text-emerald-400 bg-emerald-500/20 px-2 py-1 rounded-lg">Terverifikasi</span>
            </div>
            <p class="text-4xl font-bold text-emerald-400">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</p>
            <p class="text-sm text-slate-400 mt-2">Dari semua pembayaran yang terverifikasi</p>
        </div>

        <!-- Today Stats -->
        <div class="bg-gradient-to-br from-amber-500/10 via-orange-500/10 to-red-500/10 border border-amber-500/20 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Statistik Hari Ini
                </h3>
                <span class="text-xs text-amber-400 bg-amber-500/20 px-2 py-1 rounded-lg">{{ now()->format('d M Y') }}</span>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-3xl font-bold text-amber-400">{{ $stats['today_bookings'] ?? 0 }}</p>
                    <p class="text-sm text-slate-400">Booking Hari Ini</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-orange-400">{{ $stats['pending_payments'] ?? 0 }}</p>
                    <p class="text-sm text-slate-400">Menunggu Verifikasi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Menu -->
    <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
        <h3 class="text-lg font-bold mb-6">Menu Kelola</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('admin.buses.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl bg-navy-900/50 border border-white/10 hover:bg-white/5 hover:border-sky-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-sky-500/20 flex items-center justify-center group-hover:bg-sky-500/30 transition-colors">
                    <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">Armada</span>
            </a>

            <a href="{{ route('admin.routes.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl bg-navy-900/50 border border-white/10 hover:bg-white/5 hover:border-indigo-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/20 flex items-center justify-center group-hover:bg-indigo-500/30 transition-colors">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">Rute</span>
            </a>

            <a href="{{ route('admin.schedules.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl bg-navy-900/50 border border-white/10 hover:bg-white/5 hover:border-purple-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center group-hover:bg-purple-500/30 transition-colors">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">Jadwal</span>
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl bg-navy-900/50 border border-white/10 hover:bg-white/5 hover:border-emerald-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center group-hover:bg-emerald-500/30 transition-colors">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">Booking</span>
            </a>

            <a href="{{ route('admin.payments.index') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl bg-navy-900/50 border border-white/10 hover:bg-white/5 hover:border-amber-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center group-hover:bg-amber-500/30 transition-colors">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">Pembayaran</span>
            </a>

            <a href="{{ route('admin.settings.payment') }}" class="group flex flex-col items-center gap-3 p-4 rounded-2xl bg-navy-900/50 border border-white/10 hover:bg-white/5 hover:border-pink-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-pink-500/20 flex items-center justify-center group-hover:bg-pink-500/30 transition-colors">
                    <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1H-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">Set QRIS</span>
            </a>
        </div>
    </div>

    <!-- Recent Bookings & Pending Payments -->
    <div class="grid lg:grid-cols-2 gap-6">
        
        <!-- Recent Bookings -->
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-sky-500/10 to-indigo-500/10 border-b border-white/10 px-6 py-4 flex items-center justify-between">
                <h3 class="font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    Booking Terbaru
                </h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-sm text-sky-400 hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-white/10">
                @forelse($recentBookings as $booking)
                <div class="p-4 hover:bg-white/5 transition-colors">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500/20 to-indigo-500/20 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-bold text-sky-400">{{ strtoupper(substr($booking->passenger_name, 0, 1)) }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-medium truncate">{{ $booking->passenger_name }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ $booking->schedule->route->origin }} → {{ $booking->schedule->route->destination }}</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $booking->status_badge }} border">
                                {{ $booking->status_label }}
                            </span>
                            <p class="text-xs text-slate-400 mt-1">{{ $booking->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center">
                    <p class="text-slate-400">Belum ada booking</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border-b border-white/10 px-6 py-4 flex items-center justify-between">
                <h3 class="font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Menunggu Verifikasi
                </h3>
                <a href="{{ route('admin.payments.index') }}?status=pending" class="text-sm text-amber-400 hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-white/10">
                @forelse($pendingPayments as $payment)
                <a href="{{ route('admin.payments.show', $payment) }}" class="block p-4 hover:bg-white/5 transition-colors">
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-medium text-amber-300">{{ $payment->booking->booking_code }}</p>
                            <p class="text-sm text-slate-400 truncate">{{ $payment->booking->passenger_name }}</p>
                            <p class="text-xs text-slate-500">{{ $payment->payment_method_label }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-bold text-amber-400">{{ $payment->formatted_amount }}</p>
                            <p class="text-xs text-slate-400">{{ $payment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
                @empty
                <div class="p-8 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500/20 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-emerald-400 font-medium">Semua pembayaran terverifikasi!</p>
                    <p class="text-sm text-slate-400 mt-1">Tidak ada yang menunggu</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection