@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">
                <span class="gradient-text">Riwayat Booking</span>
            </h1>
            <p class="text-slate-400 mt-1">Kelola semua pemesanan tiket Anda</p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 shadow-lg shadow-sky-500/25 btn-glow transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Booking Baru
        </a>
    </div>

    <!-- Bookings List -->
    @if($bookings->count() > 0)
        <div class="space-y-4">
            @foreach($bookings as $booking)
            <div class="group bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-white/20 transition-all card-hover">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                        
                        <!-- Route & Schedule Info -->
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-navy-900 border border-white/10">
                                    {{ $booking->booking_code }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium border {{ $booking->status_badge }}">
                                    {{ $booking->status_label }}
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-4 mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="text-center">
                                        <p class="text-2xl font-bold">{{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }}</p>
                                        <p class="text-sm text-slate-400">{{ $booking->schedule->route->origin }}</p>
                                    </div>
                                    
                                    <div class="flex-1 px-4">
                                        <div class="relative flex items-center">
                                            <div class="w-3 h-3 rounded-full bg-sky-500 border-2 border-sky-300"></div>
                                            <div class="flex-1 h-[2px] bg-gradient-to-r from-sky-500 to-indigo-500"></div>
                                            <svg class="w-6 h-6 text-indigo-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                            </svg>
                                            <div class="flex-1 h-[2px] bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                                            <div class="w-3 h-3 rounded-full bg-purple-500 border-2 border-purple-300"></div>
                                        </div>
                                        <p class="text-center text-xs text-slate-400 mt-1">{{ $booking->schedule->route->duration ?? '~' }}</p>
                                    </div>
                                    
                                    <div class="text-center">
                                        <p class="text-2xl font-bold">{{ \Carbon\Carbon::parse($booking->schedule->arrival_time)->format('H:i') }}</p>
                                        <p class="text-sm text-slate-400">{{ $booking->schedule->route->destination }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <div class="flex items-center gap-2 text-slate-300">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $booking->schedule->departure_date->format('l, d M Y') }}
                                </div>
                                <div class="flex items-center gap-2 text-slate-300">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                    {{ $booking->schedule->bus->name }}
                                </div>
                                <div class="flex items-center gap-2 text-slate-300">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                    </svg>
                                    Kursi: {{ $booking->seats_display }}
                                </div>
                            </div>
                        </div>

                        <!-- Price & Actions -->
                        <div class="flex flex-col items-end gap-3">
                            <div class="text-right">
                                <p class="text-xs text-slate-400">Total Pembayaran</p>
                                <p class="text-2xl font-bold gradient-text">{{ $booking->formatted_price }}</p>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                @if($booking->status === 'pending' && !$booking->payment)
                                    <a href="{{ route('user.bookings.payment', $booking) }}" class="px-4 py-2 rounded-xl text-sm font-medium bg-gradient-to-r from-amber-500 to-orange-500 text-white hover:from-amber-400 hover:to-orange-400 transition-all">
                                        Bayar Sekarang
                                    </a>
                                @elseif($booking->status === 'confirmed')
                                    <a href="{{ route('user.bookings.ticket', $booking) }}" class="px-4 py-2 rounded-xl text-sm font-medium bg-gradient-to-r from-emerald-500 to-green-500 text-white hover:from-emerald-400 hover:to-green-400 transition-all">
                                        Lihat Tiket
                                    </a>
                                @endif
                                
                                <a href="{{ route('user.bookings.show', $booking) }}" class="px-4 py-2 rounded-xl text-sm font-medium bg-white/5 border border-white/10 hover:bg-white/10 transition-all">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Status Bar -->
                @if($booking->payment)
                <div class="px-6 py-3 border-t border-white/10 bg-navy-900/30">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-slate-400">Status Pembayaran:</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium border {{ $booking->payment->status_badge }}">
                                {{ $booking->payment->status_label }}
                            </span>
                        </div>
                        <span class="text-slate-400">{{ $booking->payment->payment_method_label }}</span>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
    @else
        <div class="bg-white/5 border border-white/10 rounded-2xl p-12 text-center">
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-sky-500/20 to-indigo-500/20 flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold mb-2">Belum Ada Booking</h3>
            <p class="text-slate-400 mb-8 max-w-md mx-auto">Anda belum memiliki riwayat pemesanan tiket. Mulai pesan tiket sekarang dan nikmati perjalanan Anda!</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 shadow-lg shadow-sky-500/25 btn-glow transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari Jadwal Bus
            </a>
        </div>
    @endif

</div>
@endsection