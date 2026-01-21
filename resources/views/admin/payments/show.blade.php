@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.payments.index') }}" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold">Detail Pembayaran</h1>
            <p class="text-slate-400">Verifikasi bukti pembayaran</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Payment Info Card -->
            <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500/10 to-teal-500/10 border-b border-white/10 px-6 py-4">
                    <h3 class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Informasi Pembayaran
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-slate-400 mb-1">Kode Booking</p>
                            <span class="font-mono font-bold text-sky-400 bg-sky-500/10 px-2 py-1 rounded">
                                {{ $payment->booking->booking_code }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400 mb-1">Status Pembayaran</p>
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium {{ $payment->status_badge }} border">
                                @if($payment->status === 'pending')
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                @elseif($payment->status === 'verified')
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                @endif
                                {{ $payment->status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white/10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-400 mb-1">Metode Pembayaran</p>
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/10 border border-white/10">
                                    <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    <span class="font-medium">{{ $payment->payment_method_label }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-slate-400 mb-1">Total Pembayaran</p>
                                <p class="text-3xl font-bold text-emerald-400">{{ $payment->formatted_amount }}</p>
                            </div>
                        </div>
                    </div>

                    @if($payment->paid_at)
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Waktu Upload</span>
                        <span class="font-medium">{{ $payment->paid_at->format('d M Y H:i') }}</span>
                    </div>
                    @endif

                    @if($payment->verified_at)
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Waktu Verifikasi</span>
                        <span class="font-medium">{{ $payment->verified_at->format('d M Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Bukti Pembayaran -->
            @if($payment->payment_proof)
            <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500/10 to-indigo-500/10 border-b border-white/10 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Bukti Pembayaran
                        </h3>
                        <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" download class="px-3 py-1.5 rounded-lg bg-sky-500/20 hover:bg-sky-500/30 text-sky-400 text-sm font-medium border border-sky-500/30 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" 
                             alt="Bukti Pembayaran" 
                             class="w-full rounded-xl border border-white/10 bg-navy-900/50">
                        
                        <!-- Zoom Button -->
                        <a href="{{ asset('storage/' . $payment->payment_proof) }}" 
                           target="_blank"
                           class="absolute top-4 right-4 p-2 rounded-lg bg-navy-900/80 border border-white/20 text-white opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-amber-500/10 border border-amber-500/20 rounded-2xl p-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-amber-300">Belum Ada Bukti Pembayaran</p>
                        <p class="text-sm text-amber-200/70">User belum mengupload bukti pembayaran</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Notes Admin -->
            @if($payment->notes)
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h3 class="font-bold mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Catatan Admin
                </h3>
                <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                    <p class="text-slate-300">{{ $payment->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Verification Actions -->
            @if($payment->status === 'pending')
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Aksi Verifikasi
                </h3>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Verifikasi -->
                    <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" onsubmit="return confirm('Verifikasi pembayaran ini? Booking akan otomatis dikonfirmasi.')">
                        @csrf
                        <input type="hidden" name="status" value="verified">
                        <button type="submit" class="w-full py-3 px-4 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 font-semibold border border-emerald-500/30 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Verifikasi Pembayaran
                        </button>
                    </form>

                    <!-- Tolak -->
                    <button type="button" 
                            onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                            class="w-full py-3 px-4 rounded-xl bg-red-500/20 hover:bg-red-500/30 text-red-400 font-semibold border border-red-500/30 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tolak Pembayaran
                    </button>
                </div>

                <p class="text-xs text-slate-500 text-center mt-4">
                    ⚠️ Pastikan bukti pembayaran sudah benar sebelum memverifikasi
                </p>
            </div>
            @endif

        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            
            <!-- Booking Summary -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h3 class="font-bold mb-4">Detail Booking</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Penumpang</p>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-white/10 flex items-center justify-center">
                                <span class="text-sm font-bold text-indigo-400">{{ strtoupper(substr($payment->booking->passenger_name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-sm">{{ $payment->booking->passenger_name }}</p>
                                <p class="text-xs text-slate-400">{{ $payment->booking->passenger_phone }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-white/10">
                        <p class="text-xs text-slate-400 mb-2">Rute</p>
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-sm">{{ $payment->booking->schedule->route->origin }}</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                            <span class="font-medium text-sm">{{ $payment->booking->schedule->route->destination }}</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            {{ $payment->booking->schedule->departure_date->format('d M Y') }} • 
                            {{ \Carbon\Carbon::parse($payment->booking->schedule->departure_time)->format('H:i') }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-white/10">
                        <p class="text-xs text-slate-400 mb-2">Bus</p>
                        <p class="font-medium">{{ $payment->booking->schedule->bus->name }}</p>
                        <p class="text-xs text-slate-500">{{ $payment->booking->schedule->bus->plate_number }}</p>
                    </div>

                    <div class="pt-3 border-t border-white/10">
                        <p class="text-xs text-slate-400 mb-2">Kursi</p>
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-purple-500/20 text-purple-400 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/>
                            </svg>
                            {{ $payment->booking->seats_display }}
                        </span>
                    </div>

                    <div class="pt-3 border-t border-white/10">
                        <p class="text-xs text-slate-400 mb-2">Status Booking</p>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium {{ $payment->booking->status_badge }} border">
                            {{ $payment->booking->status_label }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('admin.bookings.show', $payment->booking) }}" class="block mt-4 w-full py-2.5 px-4 rounded-xl bg-sky-500/20 hover:bg-sky-500/30 text-sky-400 text-sm font-medium border border-sky-500/30 transition-all text-center">
                    Lihat Detail Booking
                </a>
            </div>

            <!-- Timeline -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h3 class="font-bold mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-sky-500/20 border-2 border-sky-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Booking Dibuat</p>
                            <p class="text-xs text-slate-400">{{ $payment->booking->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    @if($payment->paid_at)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-amber-500/20 border-2 border-amber-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Bukti Pembayaran Diupload</p>
                            <p class="text-xs text-slate-400">{{ $payment->paid_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($payment->verified_at)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full {{ $payment->status === 'verified' ? 'bg-emerald-500/20 border-emerald-500' : 'bg-red-500/20 border-red-500' }} border-2 flex items-center justify-center flex-shrink-0">
                            @if($payment->status === 'verified')
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-sm">{{ $payment->status === 'verified' ? 'Pembayaran Diverifikasi' : 'Pembayaran Ditolak' }}</p>
                            <p class="text-xs text-slate-400">{{ $payment->verified_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Reject Modal -->
@if($payment->status === 'pending')
<div id="rejectModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-navy-900 border border-white/10 rounded-2xl max-w-md w-full p-6 shadow-2xl" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                Tolak Pembayaran
            </h3>
            <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="p-1 rounded-lg hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="rejected">
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Alasan Penolakan <span class="text-red-400">*</span>
                </label>
                <textarea name="notes" 
                          rows="4" 
                          required 
                          placeholder="Jelaskan alasan penolakan dengan jelas..."
                          class="w-full px-4 py-3 rounded-xl bg-navy-950/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-red-500/50 focus:ring-2 focus:ring-red-500/20 transition-all"></textarea>
                <p class="text-xs text-slate-500 mt-2">Catatan ini akan dilihat oleh user</p>
            </div>

            <div class="flex gap-3">
                <button type="button" 
                        onclick="document.getElementById('rejectModal').classList.add('hidden')" 
                        class="flex-1 px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 font-medium transition-all">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-500/20 hover:bg-red-500/30 text-red-400 font-semibold border border-red-500/30 transition-all">
                    Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection