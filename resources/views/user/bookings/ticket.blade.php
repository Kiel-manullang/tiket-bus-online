@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('user.bookings.show', $booking) }}" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">E-Ticket</h1>
                <p class="text-slate-400">Tiket digital Anda siap digunakan</p>
            </div>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-sm font-medium transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Tiket
            </button>
            <button id="downloadTicket" class="px-4 py-2 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 text-sm font-semibold transition-all flex items-center gap-2 shadow-lg shadow-sky-500/25">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download
            </button>
        </div>
    </div>

    <!-- Ticket Card -->
    <div id="ticketCard" class="max-w-2xl mx-auto">
        <div class="relative bg-gradient-to-br from-navy-900 via-navy-900 to-navy-800 rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
            
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-40 h-40 bg-sky-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-0 w-6 h-12 bg-navy-950 rounded-r-full -translate-y-1/2"></div>
            <div class="absolute top-1/2 right-0 w-6 h-12 bg-navy-950 rounded-l-full -translate-y-1/2"></div>
            
            <!-- Header -->
            <div class="relative bg-gradient-to-r from-sky-500/20 via-indigo-500/20 to-purple-500/20 border-b border-white/10 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold gradient-text">TiketBus</h2>
                            <p class="text-xs text-slate-400">E-Ticket Official</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-400">Kode Booking</p>
                        <p class="text-xl font-mono font-bold text-sky-400">{{ $booking->booking_code }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="relative p-6 space-y-6">
                
                <!-- Route Info -->
                <div class="flex items-center justify-between">
                    <div class="text-center">
                        <p class="text-3xl font-bold">{{ substr($booking->schedule->route->origin, 0, 3) }}</p>
                        <p class="text-sm text-slate-400 mt-1">{{ $booking->schedule->route->origin }}</p>
                        <p class="text-lg font-semibold text-sky-400 mt-2">{{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }}</p>
                    </div>
                    
                    <div class="flex-1 px-6">
                        <div class="relative flex items-center">
                            <div class="w-3 h-3 rounded-full bg-sky-500 border-2 border-sky-400"></div>
                            <div class="flex-1 border-t-2 border-dashed border-white/20 mx-2 relative">
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-navy-900 px-3">
                                    <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="w-3 h-3 rounded-full bg-indigo-500 border-2 border-indigo-400"></div>
                        </div>
                        <p class="text-center text-xs text-slate-400 mt-2">{{ $booking->schedule->route->duration ?? '~' }}</p>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-3xl font-bold">{{ substr($booking->schedule->route->destination, 0, 3) }}</p>
                        <p class="text-sm text-slate-400 mt-1">{{ $booking->schedule->route->destination }}</p>
                        <p class="text-lg font-semibold text-indigo-400 mt-2">{{ \Carbon\Carbon::parse($booking->schedule->arrival_time)->format('H:i') }}</p>
                    </div>
                </div>

                <!-- Divider with holes -->
                <div class="relative py-4">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-full w-6 h-6 bg-navy-950 rounded-full"></div>
                    <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-full w-6 h-6 bg-navy-950 rounded-full"></div>
                    <div class="border-t-2 border-dashed border-white/10"></div>
                </div>

                <!-- Ticket Details Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <p class="text-xs text-slate-400 mb-1">Penumpang</p>
                        <p class="font-semibold">{{ $booking->passenger_name }}</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <p class="text-xs text-slate-400 mb-1">No. Telepon</p>
                        <p class="font-semibold">{{ $booking->passenger_phone }}</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <p class="text-xs text-slate-400 mb-1">Tanggal</p>
                        <p class="font-semibold">{{ $booking->schedule->departure_date->format('d M Y') }}</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <p class="text-xs text-slate-400 mb-1">Jam Berangkat</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }} WIB</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <p class="text-xs text-slate-400 mb-1">Armada</p>
                        <p class="font-semibold">{{ $booking->schedule->bus->name }}</p>
                        <p class="text-xs text-slate-400">{{ $booking->schedule->bus->plate_number }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-sky-500/20 to-indigo-500/20 rounded-xl p-4 border border-sky-500/30">
                        <p class="text-xs text-sky-300 mb-1">Nomor Kursi</p>
                        <p class="text-2xl font-bold text-sky-400">{{ $booking->seats_display }}</p>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="flex items-center justify-center py-6">
                    <div class="bg-white p-4 rounded-2xl">
                        <div class="w-32 h-32 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgMTI4IDEyOCI+PHJlY3Qgd2lkdGg9IjEyOCIgaGVpZ2h0PSIxMjgiIGZpbGw9IiNmZmYiLz48cmVjdCB4PSI4IiB5PSI4IiB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSI5NiIgeT0iOCIgd2lkdGg9IjI0IiBoZWlnaHQ9IjI0IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iOCIgeT0iOTYiIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjEyIiB5PSIxMiIgd2lkdGg9IjE2IiBoZWlnaHQ9IjE2IiBmaWxsPSIjZmZmIi8+PHJlY3QgeD0iMTAwIiB5PSIxMiIgd2lkdGg9IjE2IiBoZWlnaHQ9IjE2IiBmaWxsPSIjZmZmIi8+PHJlY3QgeD0iMTIiIHk9IjEwMCIgd2lkdGg9IjE2IiBoZWlnaHQ9IjE2IiBmaWxsPSIjZmZmIi8+PHJlY3QgeD0iMTYiIHk9IjE2IiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iMTA0IiB5PSIxNiIgd2lkdGg9IjgiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjE2IiB5PSIxMDQiIHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSI0MCIgeT0iOCIgd2lkdGg9IjgiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjU2IiB5PSI4IiB3aWR0aD0iMTYiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjgwIiB5PSI4IiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iNDAiIHk9IjI0IiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iNjQiIHk9IjI0IiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iNDgiIHk9IjQwIiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iNzIiIHk9IjQwIiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iNDAiIHk9IjU2IiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iNjQiIHk9IjU2IiB3aWR0aD0iMTYiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjU2IiB5PSI3MiIgd2lkdGg9IjgiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjQwIiB5PSI4MCIgd2lkdGg9IjgiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjY0IiB5PSI4MCIgd2lkdGg9IjgiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjgwIiB5PSI4MCIgd2lkdGg9IjgiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9Ijk2IiB5PSI4MCIgd2lkdGg9IjgiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjExMiIgeT0iODAiIHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSI0MCIgeT0iOTYiIHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSI1NiIgeT0iOTYiIHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSI3MiIgeT0iOTYiIHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSI5NiIgeT0iOTYiIHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSI0MCIgeT0iMTEyIiB3aWR0aD0iMjQiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjgwIiB5PSIxMTIiIHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSI5NiIgeT0iMTEyIiB3aWR0aD0iMjQiIGhlaWdodD0iOCIgZmlsbD0iIzAwMCIvPjxyZWN0IHg9IjgiIHk9IjQwIiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iMjQiIHk9IjQwIiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iOCIgeT0iNTYiIHdpZHRoPSIxNiIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iOCIgeT0iNzIiIHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSIyNCIgeT0iNzIiIHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSI5NiIgeT0iNDAiIHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiMwMDAiLz48cmVjdCB4PSIxMTIiIHk9IjQwIiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iOTYiIHk9IjU2IiB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjMDAwIi8+PHJlY3QgeD0iMTEyIiB5PSI1NiIgd2lkdGg9IjgiIGhlaWdodD0iMTYiIGZpbGw9IiMwMDAiLz48L3N2Zz4=')] bg-contain"></div>
                    </div>
                </div>
                <p class="text-center text-xs text-slate-400">Scan QR Code untuk verifikasi tiket</p>

                <!-- Footer Notes -->
                <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 mt-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div class="text-xs text-amber-200/80">
                            <p class="font-semibold text-amber-300 mb-1">Penting!</p>
                            <ul class="space-y-1">
                                <li>• Tunjukkan e-ticket ini saat boarding</li>
                                <li>• Hadir 30 menit sebelum keberangkatan</li>
                                <li>• Tiket tidak dapat dipindahtangankan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ticket Footer -->
            <div class="relative bg-gradient-to-r from-white/5 to-white/5 border-t border-white/10 p-4 text-center">
                <p class="text-xs text-slate-400">
                    Dicetak pada {{ now()->format('d M Y H:i') }} WIB • 
                    <span class="text-sky-400">tiketbus.com</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="max-w-2xl mx-auto grid sm:grid-cols-2 gap-4">
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-sky-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">Lokasi Keberangkatan</h3>
                    <p class="text-sm text-slate-400">Terminal {{ $booking->schedule->route->origin }}</p>
                </div>
            </div>
            <p class="text-sm text-slate-300">Pastikan Anda tiba di lokasi keberangkatan minimal 30 menit sebelum jadwal berangkat.</p>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">Bantuan</h3>
                    <p class="text-sm text-slate-400">Customer Service</p>
                </div>
            </div>
            <p class="text-sm text-slate-300">Hubungi <span class="text-sky-400 font-medium">0812-3456-7890</span> jika ada pertanyaan atau kendala.</p>
        </div>
    </div>

</div>

<style>
    @media print {
        body * { visibility: hidden; }
        #ticketCard, #ticketCard * { visibility: visible; }
        #ticketCard { 
            position: absolute; 
            left: 0; 
            top: 0; 
            width: 100%;
            background: white !important;
            color: black !important;
        }
        header, footer, nav, button { display: none !important; }
    }
</style>
@endsection

@push('scripts')
<script>
    document.getElementById('downloadTicket').addEventListener('click', function() {
        // Simple print for download (in real app, you might use html2canvas + jspdf)
        window.print();
    });
</script>
@endpush