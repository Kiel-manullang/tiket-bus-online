@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.bookings.index') }}" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold">Detail Booking</h1>
            <p class="text-slate-400">{{ $booking->booking_code }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Booking Info -->
            <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500/10 to-indigo-500/10 border-b border-white/10 px-6 py-4">
                    <h3 class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                        Informasi Booking
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Kode Booking</span>
                        <span class="font-mono font-bold text-sky-400">{{ $booking->booking_code }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Tanggal Booking</span>
                        <span class="font-medium">{{ $booking->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Status</span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $booking->status_badge }} border">
                            {{ $booking->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Passenger Info -->
            <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500/10 to-purple-500/10 border-b border-white/10 px-6 py-4">
                    <h3 class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Data Penumpang
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-white/10 flex items-center justify-center flex-shrink-0">
                            <span class="text-lg font-bold text-indigo-400">{{ strtoupper(substr($booking->passenger_name, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-slate-400">Nama Penumpang</p>
                            <p class="font-semibold text-lg">{{ $booking->passenger_name }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400 mb-1">No. Telepon</p>
                        <p class="font-medium">{{ $booking->passenger_phone }}</p>
                    </div>
                    @if($booking->passenger_email)
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Email</p>
                        <p class="font-medium">{{ $booking->passenger_email }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm text-slate-400 mb-1">User Account</p>
                        <p class="font-medium">{{ $booking->user->name }} ({{ $booking->user->email }})</p>
                    </div>
                </div>
            </div>

            <!-- Schedule Info -->
            <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500/10 to-pink-500/10 border-b border-white/10 px-6 py-4">
                    <h3 class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Detail Perjalanan
                    </h3>
                </div>

                <div class="p-6">
                    <!-- Route -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ substr($booking->schedule->route->origin, 0, 3) }}</p>
                            <p class="text-sm text-slate-400 mt-1">{{ $booking->schedule->route->origin }}</p>
                            <p class="text-lg font-semibold text-emerald-400 mt-2">{{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }}</p>
                        </div>
                        
                        <div class="flex-1 px-6">
                            <div class="relative flex items-center">
                                <div class="w-3 h-3 rounded-full bg-emerald-500 border-2 border-emerald-400"></div>
                                <div class="flex-1 border-t-2 border-dashed border-white/20 mx-2"></div>
                                <div class="w-3 h-3 rounded-full bg-red-500 border-2 border-red-400"></div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ substr($booking->schedule->route->destination, 0, 3) }}</p>
                            <p class="text-sm text-slate-400 mt-1">{{ $booking->schedule->route->destination }}</p>
                            <p class="text-lg font-semibold text-red-400 mt-2">{{ \Carbon\Carbon::parse($booking->schedule->arrival_time)->format('H:i') }}</p>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                            <p class="text-xs text-slate-400 mb-1">Tanggal</p>
                            <p class="font-semibold">{{ $booking->schedule->departure_date->format('d M Y') }}</p>
                        </div>
                        <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                            <p class="text-xs text-slate-400 mb-1">Armada</p>
                            <p class="font-semibold">{{ $booking->schedule->bus->name }}</p>
                            <p class="text-xs text-slate-500">{{ $booking->schedule->bus->plate_number }}</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gradient-to-br from-purple-500/20 to-pink-500/20 border border-purple-500/30">
                            <p class="text-xs text-purple-300 mb-1">Nomor Kursi</p>
                            <p class="text-xl font-bold text-purple-400">{{ $booking->seats_display }}</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 border border-emerald-500/30">
                            <p class="text-xs text-emerald-300 mb-1">Total Kursi</p>
                            <p class="text-xl font-bold text-emerald-400">{{ $booking->total_seats }} kursi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            @if($booking->payment)
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
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Metode</span>
                        <span class="font-medium">{{ $booking->payment->payment_method_label }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Jumlah</span>
                        <span class="text-xl font-bold text-emerald-400">{{ $booking->payment->formatted_amount }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Status</span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $booking->payment->status_badge }} border">
                            {{ $booking->payment->status_label }}
                        </span>
                    </div>
                    @if($booking->payment->paid_at)
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Dibayar</span>
                        <span class="text-sm">{{ $booking->payment->paid_at->format('d M Y H:i') }}</span>
                    </div>
                    @endif
                    @if($booking->payment->verified_at)
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Diverifikasi</span>
                        <span class="text-sm">{{ $booking->payment->verified_at->format('d M Y H:i') }}</span>
                    </div>
                    @endif

                    <!-- Bukti Pembayaran -->
                    @if($booking->payment->payment_proof)
                    <div class="pt-4 border-t border-white/10">
                        <p class="text-sm text-slate-400 mb-2">Bukti Pembayaran</p>
                        <a href="{{ asset('storage/' . $booking->payment->payment_proof) }}" target="_blank" class="block">
                            <img src="{{ asset('storage/' . $booking->payment->payment_proof) }}" 
                                 alt="Bukti Pembayaran" 
                                 class="w-full max-h-64 object-contain rounded-xl border border-white/10 bg-navy-900/50">
                        </a>
                    </div>
                    @endif

                    <!-- Notes -->
                    @if($booking->payment->notes)
                    <div class="pt-4 border-t border-white/10">
                        <p class="text-sm text-slate-400 mb-1">Catatan Admin</p>
                        <p class="text-sm bg-navy-900/50 border border-white/10 rounded-lg p-3">{{ $booking->payment->notes }}</p>
                    </div>
                    @endif

                    <!-- Action Buttons for Pending Payment -->
                    @if($booking->payment->status === 'pending')
                    <div class="pt-4 border-t border-white/10 flex gap-3">
                        <form action="{{ route('admin.payments.verify', $booking->payment) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="status" value="verified">
                            <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 font-medium border border-emerald-500/30 transition-all">
                                ✓ Verifikasi
                            </button>
                        </form>
                        <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="flex-1 py-2.5 px-4 rounded-xl bg-red-500/20 hover:bg-red-500/30 text-red-400 font-medium border border-red-500/30 transition-all">
                            ✕ Tolak
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-amber-500/10 border border-amber-500/20 rounded-2xl p-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-amber-300">Belum Ada Pembayaran</p>
                        <p class="text-sm text-amber-200/70">User belum mengupload bukti pembayaran</p>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            
            <!-- Price Summary -->
            <div class="bg-gradient-to-br from-emerald-500/10 via-teal-500/10 to-cyan-500/10 border border-emerald-500/20 rounded-2xl p-6">
                <h3 class="font-bold mb-4">Ringkasan Harga</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Harga per kursi</span>
                        <span>{{ $booking->schedule->formatted_price }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Jumlah kursi</span>
                        <span>× {{ $booking->total_seats }}</span>
                    </div>
                    <div class="border-t border-white/10 pt-3 flex justify-between items-center">
                        <span class="font-semibold">Total</span>
                        <span class="text-2xl font-bold text-emerald-400">{{ $booking->formatted_price }}</span>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h3 class="font-bold mb-4">Ubah Status Booking</h3>
                <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    
                    <select name="status" class="w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white focus:outline-none focus:border-sky-500/50">
                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 text-white font-semibold shadow-lg shadow-sky-500/25 transition-all">
                        Update Status
                    </button>
                </form>
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
                            <p class="text-xs text-slate-400">{{ $booking->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    @if($booking->payment && $booking->payment->paid_at)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-amber-500/20 border-2 border-amber-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Pembayaran Diupload</p>
                            <p class="text-xs text-slate-400">{{ $booking->payment->paid_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($booking->payment && $booking->payment->verified_at)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-500/20 border-2 border-emerald-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Pembayaran Diverifikasi</p>
                            <p class="text-xs text-slate-400">{{ $booking->payment->verified_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($booking->status === 'completed')
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-500/20 border-2 border-indigo-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Perjalanan Selesai</p>
                            <p class="text-xs text-slate-400">{{ $booking->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Reject Modal -->
@if($booking->payment && $booking->payment->status === 'pending')
<div id="rejectModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-navy-900 border border-white/10 rounded-2xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold mb-4">Tolak Pembayaran</h3>
        <form action="{{ route('admin.payments.verify', $booking->payment) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="rejected">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-300 mb-2">Alasan Penolakan</label>
                <textarea name="notes" rows="4" required placeholder="Jelaskan alasan penolakan..." class="w-full px-4 py-3 rounded-xl bg-navy-950/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50"></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="flex-1 px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 font-medium transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-red-500/20 hover:bg-red-500/30 text-red-400 font-medium border border-red-500/30 transition-all">
                    Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection