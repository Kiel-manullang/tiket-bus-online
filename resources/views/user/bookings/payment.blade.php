@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('user.bookings.show', $booking) }}" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold">Pembayaran</h1>
            <p class="text-slate-400">Selesaikan pembayaran untuk tiket Anda</p>
        </div>
    </div>

    <!-- Timer Warning -->
    @if($booking->expired_at)
    <div class="relative overflow-hidden bg-gradient-to-r from-amber-500/10 via-orange-500/10 to-red-500/10 border border-amber-500/20 rounded-2xl p-6">
        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center animate-pulse">
                    <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-amber-300">Batas Waktu Pembayaran</h3>
                    <p class="text-sm text-amber-200/70">Selesaikan pembayaran sebelum waktu habis</p>
                </div>
            </div>
            <div class="text-center sm:text-right bg-navy-900/50 rounded-xl px-6 py-3 border border-amber-500/20">
                <p class="text-xs text-amber-300/70 mb-1">Waktu tersisa</p>
                <div id="countdown" class="text-2xl font-bold text-amber-400 font-mono" data-expired="{{ $booking->expired_at->toIso8601String() }}">
                    --:--:--
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        
        <!-- Left: Payment Form -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Booking Summary -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    Ringkasan Booking
                </h3>

                <div class="p-4 rounded-xl bg-navy-900/50 border border-white/10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="font-mono text-sm font-bold text-sky-400 bg-sky-500/10 px-2 py-0.5 rounded">{{ $booking->booking_code }}</span>
                            <h4 class="text-lg font-semibold mt-1">{{ $booking->schedule->route->origin }} → {{ $booking->schedule->route->destination }}</h4>
                            <p class="text-sm text-slate-400">{{ $booking->schedule->bus->name }} • {{ $booking->schedule->bus->plate_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-400">Total Tagihan</p>
                            <p class="text-2xl font-bold gradient-text">{{ $booking->formatted_price }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <form action="{{ route('user.bookings.payment.store', $booking) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="paymentForm">
                @csrf
                
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Pilih Metode Pembayaran
                    </h3>

                    <!-- 1. QRIS SECTION (Dinamis dari Admin) -->
                    <div class="mb-6">
                        <label class="group relative cursor-pointer block">
                            <input type="radio" name="payment_method" value="qris" class="sr-only peer" id="method_qris">
                            <div class="p-5 rounded-2xl bg-gradient-to-br from-navy-900 to-navy-800 border-2 border-white/10 peer-checked:border-red-500 peer-checked:from-red-500/10 peer-checked:to-orange-500/10 transition-all shadow-lg hover:border-white/30">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <!-- Logo QRIS -->
                                        <div class="w-16 h-10 bg-white rounded-lg flex items-center justify-center p-1">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png" alt="QRIS" class="h-full w-auto object-contain">
                                        </div>
                                        <div>
                                            <p class="font-bold text-lg">QRIS (Scan & Bayar)</p>
                                            <p class="text-xs text-slate-400">Gunakan BRImo, Dana, GoPay, ShopeePay, dll.</p>
                                        </div>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-white/20 peer-checked:border-red-500 peer-checked:bg-red-500 flex items-center justify-center transition-all">
                                        <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Area Gambar QR -->
                                <div id="qris_display" class="hidden mt-6 pt-6 border-t border-white/10 text-center animate-fade-in">
                                    <p class="text-sm font-medium mb-4 text-slate-300">Scan QR Code di bawah ini:</p>
                                    
                                    <div class="inline-block p-4 bg-white rounded-2xl shadow-xl">
                                        <!-- GAMBAR QRIS DARI ADMIN -->
                                        <img src="{{ asset('storage/settings/qris.jpg') }}?v={{ time() }}" 
                                             alt="Scan QRIS" 
                                             class="w-56 h-auto object-contain"
                                             onerror="this.parentElement.innerHTML='<div class=\'text-red-500 p-4\'>QRIS belum tersedia.<br>Silakan gunakan Transfer Bank.</div>'">
                                    </div>

                                    <div class="mt-4 p-3 bg-amber-500/10 border border-amber-500/20 rounded-xl max-w-sm mx-auto">
                                        <p class="text-xs text-amber-300">Total yang harus dibayar:</p>
                                        <p class="text-xl font-bold text-amber-400">{{ $booking->formatted_price }}</p>
                                        <p class="text-[10px] text-slate-400 mt-1">*Pastikan nominal sesuai hingga digit terakhir</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- 2. Transfer Bank Manual -->
                    <div class="space-y-4 mb-6">
                        <p class="text-sm font-medium text-slate-400">Transfer Bank Manual:</p>
                        <div class="grid sm:grid-cols-2 gap-3">
                            
                            <!-- BCA -->
                            <label class="payment-method-card group relative cursor-pointer">
                                <input type="radio" name="payment_method" value="transfer_bca" class="sr-only peer">
                                <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-sky-500 peer-checked:bg-sky-500/10 transition-all hover:border-white/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-8 rounded bg-white flex items-center justify-center flex-shrink-0">
                                            <span class="text-[#003d79] font-bold text-xs">BCA</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">Bank BCA</p>
                                            <p class="text-xs text-slate-400">1234567890</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-white/20 peer-checked:border-sky-500 peer-checked:bg-sky-500 flex items-center justify-center transition-all">
                                    <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                </div>
                            </label>

                            <!-- BRI / BRImo -->
                            <label class="payment-method-card group relative cursor-pointer">
                                <input type="radio" name="payment_method" value="transfer_bri" class="sr-only peer">
                                <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-sky-500 peer-checked:bg-sky-500/10 transition-all hover:border-white/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-8 rounded bg-gradient-to-r from-blue-700 to-blue-500 flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold text-xs">BRI</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">BRI / BRImo</p>
                                            <p class="text-xs text-slate-400">5544332211</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-white/20 peer-checked:border-sky-500 peer-checked:bg-sky-500 flex items-center justify-center transition-all">
                                    <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                </div>
                            </label>

                            <!-- BNI -->
                            <label class="payment-method-card group relative cursor-pointer">
                                <input type="radio" name="payment_method" value="transfer_bni" class="sr-only peer">
                                <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-sky-500 peer-checked:bg-sky-500/10 transition-all hover:border-white/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-8 rounded bg-orange-500 flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold text-xs">BNI</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">Bank BNI</p>
                                            <p class="text-xs text-slate-400">987654321</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-white/20 peer-checked:border-sky-500 peer-checked:bg-sky-500 flex items-center justify-center transition-all">
                                    <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                </div>
                            </label>

                            <!-- Mandiri -->
                            <label class="payment-method-card group relative cursor-pointer">
                                <input type="radio" name="payment_method" value="transfer_mandiri" class="sr-only peer">
                                <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-sky-500 peer-checked:bg-sky-500/10 transition-all hover:border-white/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-8 rounded bg-gradient-to-r from-blue-800 to-yellow-500 flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold text-[10px]">MANDIRI</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">Mandiri / Livin</p>
                                            <p class="text-xs text-slate-400">1122334455</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-white/20 peer-checked:border-sky-500 peer-checked:bg-sky-500 flex items-center justify-center transition-all">
                                    <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- 3. E-Wallet -->
                    <div class="space-y-4">
                        <p class="text-sm font-medium text-slate-400">E-Wallet:</p>
                        <div class="grid sm:grid-cols-3 gap-3">
                            <!-- DANA -->
                            <label class="payment-method-card group relative cursor-pointer">
                                <input type="radio" name="payment_method" value="ewallet_dana" class="sr-only peer">
                                <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-sky-500 peer-checked:bg-sky-500/10 transition-all hover:border-white/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-blue-500 flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold text-[10px]">DANA</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">DANA</p>
                                            <p class="text-xs text-slate-400">0812xxx</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-white/20 peer-checked:border-sky-500 peer-checked:bg-sky-500 flex items-center justify-center transition-all">
                                    <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                </div>
                            </label>

                            <!-- GoPay -->
                            <label class="payment-method-card group relative cursor-pointer">
                                <input type="radio" name="payment_method" value="ewallet_gopay" class="sr-only peer">
                                <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-sky-500 peer-checked:bg-sky-500/10 transition-all hover:border-white/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-green-500 flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold text-[10px]">Go</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">GoPay</p>
                                            <p class="text-xs text-slate-400">0812xxx</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-white/20 peer-checked:border-sky-500 peer-checked:bg-sky-500 flex items-center justify-center transition-all">
                                    <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                </div>
                            </label>

                            <!-- OVO -->
                            <label class="payment-method-card group relative cursor-pointer">
                                <input type="radio" name="payment_method" value="ewallet_ovo" class="sr-only peer">
                                <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-sky-500 peer-checked:bg-sky-500/10 transition-all hover:border-white/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-purple-600 flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold text-[10px]">OVO</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">OVO</p>
                                            <p class="text-xs text-slate-400">0812xxx</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-white/20 peer-checked:border-sky-500 peer-checked:bg-sky-500 flex items-center justify-center transition-all">
                                    <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Upload Proof -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Upload Bukti Pembayaran
                    </h3>

                    <div id="dropZone" class="relative border-2 border-dashed border-white/20 hover:border-sky-500/50 rounded-2xl p-8 text-center transition-all cursor-pointer group">
                        <input type="file" name="payment_proof" id="paymentProof" accept="image/jpeg,image/png,image/jpg" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        
                        <div id="uploadPlaceholder">
                            <div class="w-16 h-16 rounded-2xl bg-sky-500/20 border border-sky-500/30 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <p class="font-medium mb-1">Klik atau seret file ke sini</p>
                            <p class="text-sm text-slate-400">Format: JPG, JPEG, PNG (Max. 2MB)</p>
                        </div>

                        <div id="uploadPreview" class="hidden">
                            <img id="previewImage" src="" alt="Preview" class="max-h-48 rounded-xl mx-auto mb-4 border border-white/10 shadow-lg">
                            <p id="fileName" class="text-sm text-slate-400"></p>
                            <p class="text-xs text-emerald-400 mt-2">File siap diupload</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitBtn" class="w-full py-4 px-6 rounded-2xl font-bold text-lg text-white bg-gradient-to-r from-sky-500 via-indigo-500 to-purple-500 hover:from-sky-400 hover:via-indigo-400 hover:to-purple-400 shadow-lg shadow-sky-500/25 btn-glow transition-all flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Konfirmasi Pembayaran
                </button>
            </form>
        </div>

        <!-- Right: Order Summary -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <!-- Price Summary -->
                <div class="bg-gradient-to-br from-sky-500/10 via-indigo-500/10 to-purple-500/10 border border-white/10 rounded-2xl p-6">
                    <h3 class="text-lg font-bold mb-4">Ringkasan Pembayaran</h3>
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Harga tiket</span>
                            <span>{{ $booking->schedule->formatted_price }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Jumlah kursi</span>
                            <span>× {{ $booking->total_seats }}</span>
                        </div>
                    </div>
                    <div class="border-t border-white/10 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Total Bayar</span>
                            <span class="text-3xl font-bold gradient-text">{{ $booking->formatted_price }}</span>
                        </div>
                    </div>
                </div>

                <!-- Help -->
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
                    <p class="text-sm text-emerald-300">
                        Butuh bantuan? CS: <strong>0812-3456-7890</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // QRIS Toggle Logic
    const qrisRadio = document.getElementById('method_qris');
    const qrisDisplay = document.getElementById('qris_display');
    const otherRadios = document.querySelectorAll('input[name="payment_method"]:not(#method_qris)');

    function handlePaymentChange() {
        if (qrisRadio.checked) {
            qrisDisplay.classList.remove('hidden');
        } else {
            qrisDisplay.classList.add('hidden');
        }
    }

    if(qrisRadio && qrisDisplay) {
        qrisRadio.addEventListener('change', handlePaymentChange);
        otherRadios.forEach(radio => radio.addEventListener('change', handlePaymentChange));
    }

    // Countdown Timer
    const countdownEl = document.getElementById('countdown');
    if (countdownEl) {
        const expiredAt = new Date(countdownEl.dataset.expired);
        
        function updateCountdown() {
            const now = new Date();
            const diff = expiredAt - now;
            
            if (diff <= 0) {
                countdownEl.textContent = 'EXPIRED';
                countdownEl.classList.add('text-red-400');
                document.getElementById('submitBtn').disabled = true;
                return;
            }
            
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            countdownEl.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // File Upload Preview
    const paymentProof = document.getElementById('paymentProof');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const uploadPreview = document.getElementById('uploadPreview');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');

    paymentProof.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                fileName.textContent = file.name;
                uploadPlaceholder.classList.add('hidden');
                uploadPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush