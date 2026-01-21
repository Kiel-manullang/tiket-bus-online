@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold">Kelola Pembayaran</h1>
            <p class="text-slate-400">Verifikasi dan kelola pembayaran tiket</p>
        </div>
    </div>

    <!-- Filter & Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.payments.index') }}" class="bg-white/5 border {{ !request('status') ? 'border-sky-500/50 bg-sky-500/10' : 'border-white/10' }} rounded-xl p-4 hover:bg-white/10 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-sky-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $payments->total() }}</p>
                    <p class="text-xs text-slate-400">Semua</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" class="bg-white/5 border {{ request('status') == 'pending' ? 'border-amber-500/50 bg-amber-500/10' : 'border-white/10' }} rounded-xl p-4 hover:bg-white/10 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-amber-400">{{ \App\Models\Payment::where('status', 'pending')->count() }}</p>
                    <p class="text-xs text-slate-400">Pending</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.payments.index', ['status' => 'verified']) }}" class="bg-white/5 border {{ request('status') == 'verified' ? 'border-emerald-500/50 bg-emerald-500/10' : 'border-white/10' }} rounded-xl p-4 hover:bg-white/10 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-emerald-400">{{ \App\Models\Payment::where('status', 'verified')->count() }}</p>
                    <p class="text-xs text-slate-400">Terverifikasi</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.payments.index', ['status' => 'rejected']) }}" class="bg-white/5 border {{ request('status') == 'rejected' ? 'border-red-500/50 bg-red-500/10' : 'border-white/10' }} rounded-xl p-4 hover:bg-white/10 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-red-400">{{ \App\Models\Payment::where('status', 'rejected')->count() }}</p>
                    <p class="text-xs text-slate-400">Ditolak</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Total Revenue -->
    <div class="bg-gradient-to-br from-emerald-500/10 via-teal-500/10 to-cyan-500/10 border border-emerald-500/20 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center">
                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-emerald-300 font-medium">Total Pendapatan Terverifikasi</p>
                    <p class="text-xs text-slate-400">Dari semua pembayaran yang sudah diverifikasi</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-4xl font-bold text-emerald-400">
                    Rp {{ number_format(\App\Models\Payment::where('status', 'verified')->sum('amount'), 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-300">Kode Booking</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-300">Penumpang</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-300">Metode</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Jumlah</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Dibayar</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Status</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-white/5 transition-colors">
                        <!-- Kode Booking -->
                        <td class="px-6 py-4">
                            <div>
                                <span class="font-mono text-sm font-bold text-sky-400 bg-sky-500/10 px-2 py-1 rounded">
                                    {{ $payment->booking->booking_code }}
                                </span>
                                <p class="text-xs text-slate-400 mt-1">{{ $payment->booking->schedule->route->origin }} → {{ $payment->booking->schedule->route->destination }}</p>
                            </div>
                        </td>
                        
                        <!-- Penumpang -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-white/10 flex items-center justify-center">
                                    <span class="font-bold text-indigo-400">{{ strtoupper(substr($payment->booking->passenger_name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium">{{ $payment->booking->passenger_name }}</p>
                                    <p class="text-xs text-slate-400">{{ $payment->booking->passenger_phone }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Metode -->
                        <td class="px-6 py-4">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/10 border border-white/10">
                                <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $payment->payment_method_label }}</span>
                            </div>
                        </td>
                        
                        <!-- Jumlah -->
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-emerald-400">{{ $payment->formatted_amount }}</span>
                        </td>
                        
                        <!-- Dibayar -->
                        <td class="px-6 py-4 text-center">
                            @if($payment->paid_at)
                                <div>
                                    <p class="text-sm">{{ $payment->paid_at->format('d M Y') }}</p>
                                    <p class="text-xs text-slate-400">{{ $payment->paid_at->format('H:i') }}</p>
                                </div>
                            @else
                                <span class="text-xs text-slate-500">-</span>
                            @endif
                        </td>
                        
                        <!-- Status -->
                        <td class="px-6 py-4 text-center">
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
                        </td>
                        
                        <!-- Aksi -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.payments.show', $payment) }}" class="p-2 rounded-lg bg-sky-500/20 hover:bg-sky-500/30 text-sky-400 transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                
                                @if($payment->status === 'pending')
                                <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="verified">
                                    <button type="submit" class="p-2 rounded-lg bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 transition-colors" title="Verifikasi" onclick="return confirm('Verifikasi pembayaran ini?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-slate-500/20 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <p class="text-slate-400">Tidak ada pembayaran{{ request('status') ? ' dengan status ' . request('status') : '' }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($payments->hasPages())
        <div class="border-t border-white/10 px-6 py-4">
            {{ $payments->links() }}
        </div>
        @endif
    </div>

</div>
@endsection