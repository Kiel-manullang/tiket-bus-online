@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold">Kelola Booking</h1>
            <p class="text-slate-400">Daftar semua pemesanan tiket</p>
        </div>
    </div>

    <!-- Filter & Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <a href="{{ route('admin.bookings.index') }}" class="bg-white/5 border {{ !request('status') ? 'border-sky-500/50 bg-sky-500/10' : 'border-white/10' }} rounded-xl p-4 hover:bg-white/10 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-sky-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $bookings->total() }}</p>
                    <p class="text-xs text-slate-400">Semua</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="bg-white/5 border {{ request('status') == 'pending' ? 'border-amber-500/50 bg-amber-500/10' : 'border-white/10' }} rounded-xl p-4 hover:bg-white/10 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-amber-400">{{ \App\Models\Booking::where('status', 'pending')->count() }}</p>
                    <p class="text-xs text-slate-400">Pending</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}" class="bg-white/5 border {{ request('status') == 'confirmed' ? 'border-emerald-500/50 bg-emerald-500/10' : 'border-white/10' }} rounded-xl p-4 hover:bg-white/10 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-emerald-400">{{ \App\Models\Booking::where('status', 'confirmed')->count() }}</p>
                    <p class="text-xs text-slate-400">Terkonfirmasi</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.bookings.index', ['status' => 'completed']) }}" class="bg-white/5 border {{ request('status') == 'completed' ? 'border-indigo-500/50 bg-indigo-500/10' : 'border-white/10' }} rounded-xl p-4 hover:bg-white/10 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-indigo-400">{{ \App\Models\Booking::where('status', 'completed')->count() }}</p>
                    <p class="text-xs text-slate-400">Selesai</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}" class="bg-white/5 border {{ request('status') == 'cancelled' ? 'border-red-500/50 bg-red-500/10' : 'border-white/10' }} rounded-xl p-4 hover:bg-white/10 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-red-400">{{ \App\Models\Booking::where('status', 'cancelled')->count() }}</p>
                    <p class="text-xs text-slate-400">Dibatalkan</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Search -->
    <div class="bg-white/5 border border-white/10 rounded-xl p-4">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari kode booking, nama penumpang..."
                       class="w-full px-4 py-2.5 rounded-lg bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50">
            </div>
            <button type="submit" class="px-6 py-2.5 rounded-lg bg-sky-500/20 hover:bg-sky-500/30 text-sky-400 font-medium border border-sky-500/30 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-300">Kode Booking</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-300">Penumpang</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-300">Jadwal</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Kursi</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Total</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Pembayaran</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Status</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-white/5 transition-colors">
                        <!-- Kode Booking -->
                        <td class="px-6 py-4">
                            <div>
                                <span class="font-mono text-sm font-bold text-sky-400 bg-sky-500/10 px-2 py-1 rounded">
                                    {{ $booking->booking_code }}
                                </span>
                                <p class="text-xs text-slate-400 mt-1">{{ $booking->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </td>
                        
                        <!-- Penumpang -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-white/10 flex items-center justify-center">
                                    <span class="font-bold text-indigo-400">{{ strtoupper(substr($booking->passenger_name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium">{{ $booking->passenger_name }}</p>
                                    <p class="text-xs text-slate-400">{{ $booking->passenger_phone }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Jadwal -->
                        <td class="px-6 py-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-medium text-sm">{{ $booking->schedule->route->origin }}</span>
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                    <span class="font-medium text-sm">{{ $booking->schedule->route->destination }}</span>
                                </div>
                                <p class="text-xs text-slate-400">{{ $booking->schedule->departure_date->format('d M Y') }} • {{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }}</p>
                                <p class="text-xs text-slate-500">{{ $booking->schedule->bus->name }}</p>
                            </div>
                        </td>
                        
                        <!-- Kursi -->
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-purple-500/20 text-purple-400 text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/>
                                </svg>
                                {{ $booking->seats_display }}
                            </span>
                        </td>
                        
                        <!-- Total -->
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-emerald-400">{{ $booking->formatted_price }}</span>
                        </td>
                        
                        <!-- Pembayaran -->
                        <td class="px-6 py-4 text-center">
                            @if($booking->payment)
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium {{ $booking->payment->status_badge }} border">
                                    {{ $booking->payment->status_label }}
                                </span>
                            @else
                                <span class="text-xs text-slate-500">Belum upload</span>
                            @endif
                        </td>
                        
                        <!-- Status -->
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium {{ $booking->status_badge }} border">
                                {{ $booking->status_label }}
                            </span>
                        </td>
                        
                        <!-- Aksi -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="p-2 rounded-lg bg-sky-500/20 hover:bg-sky-500/30 text-sky-400 transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-slate-500/20 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <p class="text-slate-400">Tidak ada booking{{ request('status') ? ' dengan status ' . request('status') : '' }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
        <div class="border-t border-white/10 px-6 py-4">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>

</div>
@endsection