@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('user.bookings.index') }}" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold">Detail Booking</h1>
                <span class="px-3 py-1 rounded-full text-sm font-medium border {{ $booking->status_badge }}">
                    {{ $booking->status_label }}
                </span>
            </div>
            <p class="text-slate-400">Kode Booking: <span class="font-mono font-bold text-white">{{ $booking->booking_code }}</span></p>
        </div>
        
        @if($booking->status === 'confirmed')
            <a href="{{ route('user.bookings.ticket', $booking) }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-400 hover:to-green-400 shadow-lg shadow-emerald-500/25 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                Lihat E-Ticket
            </a>
        @endif
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Trip Details -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-sky-500 to-indigo-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </span>
                    Detail Perjalanan
                </h2>

                <div class="flex items-center gap-6 mb-6">
                    <div class="text-center">
                        <p class="text-3xl font-bold">{{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }}</p>
                        <p class="text-slate-400">{{ $booking->schedule->route->origin }}</p>
                    </div>
                    
                    <div class="flex-1">
                        <div class="relative flex items-center">
                            <div class="w-4 h-4 rounded-full bg-sky-500 border-4 border-sky-500/30"></div>
                            <div class="flex-1 h-1 bg-gradient-to-r from-sky-500 to-indigo-500 rounded-full"></div>
                            <div class="px-3 py-1 rounded-full bg-navy-900/50 border border-white/10 text-xs text-slate-300">
                                {{ $booking->schedule->route->duration ?? '~' }}
                            </div>
                            <div class="flex-1 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></div>
                            <div class="w-4 h-4 rounded-full bg-purple-500 border-4 border-purple-500/30"></div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-3xl font-bold">{{ \Carbon\Carbon::parse($booking->schedule->arrival_time)->format('H:i') }}</p>
                        <p class="text-slate-400">{{ $booking->schedule->route->destination }}</p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <p class="text-sm text-slate-400 mb-1">Tanggal</p>
                        <p class="font-semibold">{{ $booking->schedule->departure_date->format('l, d F Y') }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <p class="text-sm text-slate-400 mb-1">Bus</p>
                        <p class="font-semibold">{{ $booking->schedule->bus->name }} ({{ $booking->schedule->bus->plate_number }})</p>
                    </div>
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <p class="text-sm text-slate-400 mb-1">Nomor Kursi</p>
                        <p class="font-semibold">{{ $booking->seats_display }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <p class="text-sm text-slate-400 mb-1">Jumlah Kursi</p>
                        <p class="font-semibold">{{ $booking->total_seats }} kursi</p>
                    </div>
                </div>
            </div>

            <!-- Passenger Info -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </span>
                    Data Penumpang
                </h2>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <p class="text-sm text-slate-400 mb-1">Nama</p>
                        <p class="font-semibold">{{ $booking->passenger_name }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <p class="text-sm text-slate-400 mb-1">No. Telepon</p>
                        <p class="font-semibold">{{ $booking->passenger_phone }}</p>
                    </div>
                    @if($booking->passenger_email)
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10 sm:col-span-2">
                        <p class="text-sm text-slate-400 mb-1">Email</p>
                        <p class="font-semibold">{{ $booking->passenger_email }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Info -->
            @if($booking->payment)
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </span>
                    Informasi Pembayaran
                </h2>

                <div class="grid sm:grid-cols-2 gap-4 mb-4">
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <p class="text-sm text-slate-400 mb-1">Metode Pembayaran</p>
                        <p class="font-semibold">{{ $booking->payment->payment_method_label }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <p class="text-sm text-slate-400 mb-1">Status</p>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium border {{ $booking->payment->status_badge }}">
                            {{ $booking->payment->status_label }}
                        </span>
                    </div>
                    @if($booking->payment->paid_at)
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <p class="text-sm text-slate-400 mb-1">Tanggal Bayar</p>
                        <p class="font-semibold">{{ $booking->payment->paid_at->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                    @if($booking->payment->verified_at)
                    <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <p class="text-sm text-slate-400 mb-1">Tanggal Verifikasi</p>
                        <p class="font-semibold">{{ $booking->payment->verified_at->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                </div>

                @if($booking->payment->payment_proof)
                <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                    <p class="text-sm text-slate-400 mb-3">Bukti Pembayaran</p>
                    <img src="{{ asset('storage/' . $booking->payment->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-sm rounded-xl border border-white/10">
                </div>
                @endif

                @if($booking->payment->notes)
                <div class="mt-4 p-4 rounded-xl bg-amber-500/10 border border-amber-500/20">
                    <p class="text-sm text-amber-400 font-medium mb-1">Catatan Admin</p>
                    <p class="text-slate-300">{{ $booking->payment->notes }}</p>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Right Column: Summary & Actions -->
        <div class="space-y-6">
            
            <!-- Price Summary -->
            <div class="bg-gradient-to-br from-sky-500/10 via-indigo-500/10 to-purple-500/10 border border-white/10 rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-6">Ringkasan Pembayaran</h2>

                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Harga per kursi</span>
                        <span>{{ $booking->schedule->formatted_price }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Jumlah kursi</span>
                        <span>{{ $booking->total_seats }}x</span>
                    </div>
                    <div class="border-t border-white/10 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total</span>
                            <span class="text-2xl font-bold gradient-text">{{ $booking->formatted_price }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 space-y-3">
                @if($booking->status === 'pending' && !$booking->payment)
                    <a href="{{ route('user.bookings.payment', $booking) }}" class="flex items-center justify-center gap-2 w-full py-3 px-4 rounded-xl font-semibold text-white bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Bayar Sekarang
                    </a>

                    <form action="{{ route('user.bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-2 w-full py-3 px-4 rounded-xl font-medium text-red-400 bg-red-500/10 border border-red-500/20 hover:bg-red-500/20 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Batalkan Booking
                        </button>
                    </form>
                @endif

                @if($booking->status === 'confirmed')
                    <a href="{{ route('user.bookings.ticket', $booking) }}" class="flex items-center justify-center gap-2 w-full py-3 px-4 rounded-xl font-semibold text-white bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-400 hover:to-green-400 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                        Lihat E-Ticket
                    </a>
                @endif

                <a href="{{ route('user.bookings.index') }}" class="flex items-center justify-center gap-2 w-full py-3 px-4 rounded-xl font-medium text-slate-300 bg-white/5 border border-white/10 hover:bg-white/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>

            <!-- Timeline -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h3 class="font-bold mb-4">Status Timeline</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium">Booking Dibuat</p>
                            <p class="text-sm text-slate-400">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    @if($booking->payment)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium">Pembayaran Diupload</p>
                            <p class="text-sm text-slate-400">{{ $booking->payment->paid_at?->format('d M Y, H:i') ?? '-' }}</p>
                        </div>
                    </div>
                    @endif

                    @if($booking->status === 'confirmed')
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium">Pembayaran Terverifikasi</p>
                            <p class="text-sm text-slate-400">{{ $booking->payment?->verified_at?->format('d M Y, H:i') ?? '-' }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection