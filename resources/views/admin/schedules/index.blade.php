@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold">Kelola Jadwal</h1>
            <p class="text-slate-400">Daftar semua jadwal keberangkatan bus</p>
        </div>
        <a href="{{ route('admin.schedules.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 text-white font-semibold shadow-lg shadow-sky-500/25 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Jadwal
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $schedules->total() }}</p>
                    <p class="text-xs text-slate-400">Total Jadwal</p>
                </div>
            </div>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $schedules->where('status', 'active')->count() }}</p>
                    <p class="text-xs text-slate-400">Jadwal Aktif</p>
                </div>
            </div>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-sky-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $schedules->where('departure_date', '>=', now()->toDateString())->count() }}</p>
                    <p class="text-xs text-slate-400">Akan Datang</p>
                </div>
            </div>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $schedules->where('status', 'cancelled')->count() }}</p>
                    <p class="text-xs text-slate-400">Dibatalkan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-300">Jadwal</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-300">Rute</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-300">Armada</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Waktu</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Harga</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Kursi</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Status</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($schedules as $schedule)
                    <tr class="hover:bg-white/5 transition-colors">
                        <!-- Tanggal -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500/20 to-pink-500/20 border border-white/10 flex flex-col items-center justify-center">
                                    <span class="text-lg font-bold text-purple-400">{{ $schedule->departure_date->format('d') }}</span>
                                    <span class="text-xs text-slate-400">{{ $schedule->departure_date->format('M') }}</span>
                                </div>
                                <div>
                                    <p class="font-medium">{{ $schedule->departure_date->format('l') }}</p>
                                    <p class="text-xs text-slate-400">{{ $schedule->departure_date->format('Y') }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Rute -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-medium">{{ $schedule->route->origin }}</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                                <span class="font-medium">{{ $schedule->route->destination }}</span>
                            </div>
                            @if($schedule->route->duration)
                            <p class="text-xs text-slate-400 mt-1">{{ $schedule->route->duration }}</p>
                            @endif
                        </td>
                        
                        <!-- Armada -->
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium">{{ $schedule->bus->name }}</p>
                                <p class="text-xs text-slate-400 font-mono">{{ $schedule->bus->plate_number }}</p>
                            </div>
                        </td>
                        
                        <!-- Waktu -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-lg font-bold text-sky-400">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</span>
                                <span class="text-xs text-slate-500">s/d</span>
                                <span class="text-sm text-slate-300">{{ \Carbon\Carbon::parse($schedule->arrival_time)->format('H:i') }}</span>
                            </div>
                        </td>
                        
                        <!-- Harga -->
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-emerald-400">{{ $schedule->formatted_price }}</span>
                        </td>
                        
                        <!-- Kursi -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-lg font-bold {{ $schedule->available_seats > 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                    {{ $schedule->available_seats }}
                                </span>
                                <span class="text-xs text-slate-400">dari {{ $schedule->bus->capacity }}</span>
                            </div>
                        </td>
                        
                        <!-- Status -->
                        <td class="px-6 py-4 text-center">
                            @if($schedule->status === 'active')
                                @if($schedule->departure_date < now()->toDateString())
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-slate-500/20 text-slate-400 border border-slate-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Lewat
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Aktif
                                    </span>
                                @endif
                            @elseif($schedule->status === 'cancelled')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    Batal
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-sky-500/20 text-sky-400 border border-sky-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                                    Selesai
                                </span>
                            @endif
                        </td>
                        
                        <!-- Aksi -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.schedules.edit', $schedule) }}" class="p-2 rounded-lg bg-sky-500/20 hover:bg-sky-500/30 text-sky-400 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-red-500/20 hover:bg-red-500/30 text-red-400 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-slate-500/20 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-slate-400 mb-4">Belum ada jadwal terdaftar</p>
                            <a href="{{ route('admin.schedules.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-500/20 hover:bg-sky-500/30 text-sky-400 font-medium transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Jadwal Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($schedules->hasPages())
        <div class="border-t border-white/10 px-6 py-4">
            {{ $schedules->links() }}
        </div>
        @endif
    </div>

</div>
@endsection