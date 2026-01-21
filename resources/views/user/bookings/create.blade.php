@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <!-- Header with Back Button -->
    <div class="flex items-center gap-4">
        <a href="{{ url()->previous() }}" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold">Pilih Kursi & Pesan</h1>
            <p class="text-slate-400">Pilih kursi favorit Anda untuk perjalanan ini</p>
        </div>
    </div>

    <form method="POST" action="{{ route('user.bookings.store', $schedule) }}" id="bookingForm">
        @csrf
        
        <div class="grid lg:grid-cols-3 gap-6">
            
            <!-- Left: Seat Selection -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Schedule Info Card -->
                <div class="relative overflow-hidden bg-gradient-to-r from-sky-500/10 via-indigo-500/10 to-purple-500/10 border border-white/10 rounded-2xl p-6">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-sky-500/20 rounded-full blur-3xl"></div>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">{{ $schedule->bus->name }}</p>
                                <p class="text-sm text-slate-400">{{ $schedule->bus->plate_number }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-6">
                            <div class="text-center">
                                <p class="text-3xl font-bold">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</p>
                                <p class="text-slate-400">{{ $schedule->route->origin }}</p>
                            </div>
                            
                            <div class="flex-1">
                                <div class="relative flex items-center">
                                    <div class="w-4 h-4 rounded-full bg-sky-500 border-4 border-sky-500/30"></div>
                                    <div class="flex-1 h-1 bg-gradient-to-r from-sky-500 to-indigo-500 rounded-full"></div>
                                    <div class="px-3 py-1 rounded-full bg-navy-900/50 border border-white/10 text-xs text-slate-300">
                                        {{ $schedule->route->duration ?? '~' }}
                                    </div>
                                    <div class="flex-1 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></div>
                                    <div class="w-4 h-4 rounded-full bg-purple-500 border-4 border-purple-500/30"></div>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <p class="text-3xl font-bold">{{ \Carbon\Carbon::parse($schedule->arrival_time)->format('H:i') }}</p>
                                <p class="text-slate-400">{{ $schedule->route->destination }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 mt-4 text-sm">
                            <span class="flex items-center gap-2 text-slate-300">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $schedule->departure_date->format('l, d M Y') }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                {{ $schedule->available_seats }} kursi tersedia
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Seat Selection Premium -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-sky-500 to-indigo-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/>
                            </svg>
                        </span>
                        Pilih Kursi
                    </h2>

                    <!-- Legend -->
                    <div class="flex flex-wrap items-center gap-6 mb-6 p-4 rounded-xl bg-navy-900/50 border border-white/10">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-white/10 border border-white/20"></div>
                            <span class="text-sm text-slate-300">Tersedia</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/30 border border-emerald-500/50"></div>
                            <span class="text-sm text-slate-300">Dipilih</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-red-500/30 border border-red-500/50"></div>
                            <span class="text-sm text-slate-300">Terisi</span>
                        </div>
                    </div>

                    <!-- Bus Layout -->
                    <div class="relative p-6 rounded-2xl bg-gradient-to-b from-navy-900/80 to-navy-950/80 border border-white/10">
                        <!-- Driver Area -->
                        <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-slate-700/50 border border-white/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-slate-400">DRIVER</span>
                            </div>
                            <div class="px-4 py-2 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-sm text-slate-300">Pintu Masuk →</span>
                            </div>
                        </div>

                        <!-- Seats Grid -->
                        <div class="grid gap-3" id="seatsContainer">
                            @php
                                $capacity = $schedule->bus->capacity;
                                $seatsPerRow = 4;
                                $rows = ceil($capacity / $seatsPerRow);
                            @endphp
                            
                            @for($row = 0; $row < $rows; $row++)
                                <div class="flex items-center justify-center gap-3">
                                    <!-- Left Side (2 seats) -->
                                    <div class="flex gap-2">
                                        @for($col = 0; $col < 2; $col++)
                                            @php
                                                $seatNumber = ($row * $seatsPerRow) + $col + 1;
                                                $isBooked = in_array($seatNumber, $bookedSeats);
                                            @endphp
                                            @if($seatNumber <= $capacity)
                                                <label class="seat relative w-14 h-14 rounded-xl flex items-center justify-center font-bold transition-all
                                                    {{ $isBooked ? 'booked bg-red-500/20 border-2 border-red-500/40 text-red-400' : 'bg-white/10 border-2 border-white/20 hover:border-sky-500/50 text-white' }}"
                                                    data-seat="{{ $seatNumber }}">
                                                    @if(!$isBooked)
                                                        <input type="checkbox" name="seats[]" value="{{ $seatNumber }}" class="sr-only seat-checkbox">
                                                    @endif
                                                    <span class="text-lg">{{ $seatNumber }}</span>
                                                    @if($isBooked)
                                                        <svg class="absolute top-1 right-1 w-3 h-3 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    @endif
                                                </label>
                                            @endif
                                        @endfor
                                    </div>

                                    <!-- Aisle -->
                                    <div class="w-12 flex items-center justify-center">
                                        <div class="w-full h-[2px] bg-white/10 rounded"></div>
                                    </div>

                                    <!-- Right Side (2 seats) -->
                                    <div class="flex gap-2">
                                        @for($col = 2; $col < 4; $col++)
                                            @php
                                                $seatNumber = ($row * $seatsPerRow) + $col + 1;
                                                $isBooked = in_array($seatNumber, $bookedSeats);
                                            @endphp
                                            @if($seatNumber <= $capacity)
                                                <label class="seat relative w-14 h-14 rounded-xl flex items-center justify-center font-bold transition-all
                                                    {{ $isBooked ? 'booked bg-red-500/20 border-2 border-red-500/40 text-red-400' : 'bg-white/10 border-2 border-white/20 hover:border-sky-500/50 text-white' }}"
                                                    data-seat="{{ $seatNumber }}">
                                                    @if(!$isBooked)
                                                        <input type="checkbox" name="seats[]" value="{{ $seatNumber }}" class="sr-only seat-checkbox">
                                                    @endif
                                                    <span class="text-lg">{{ $seatNumber }}</span>
                                                    @if($isBooked)
                                                        <svg class="absolute top-1 right-1 w-3 h-3 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    @endif
                                                </label>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- Back of Bus -->
                        <div class="mt-6 pt-4 border-t border-white/10 text-center">
                            <span class="text-sm text-slate-400">← Belakang Bus →</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Booking Form & Summary -->
            <div class="space-y-6">
                
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

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap *</label>
                            <input type="text" name="passenger_name" value="{{ old('passenger_name', auth()->user()->name) }}" required
                                   class="input-style w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50"
                                   placeholder="Nama sesuai identitas">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">No. Telepon *</label>
                            <input type="text" name="passenger_phone" value="{{ old('passenger_phone', auth()->user()->phone) }}" required
                                   class="input-style w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                            <input type="email" name="passenger_email" value="{{ old('passenger_email', auth()->user()->email) }}"
                                   class="input-style w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50"
                                   placeholder="email@example.com">
                        </div>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="bg-gradient-to-br from-sky-500/10 via-indigo-500/10 to-purple-500/10 border border-white/10 rounded-2xl p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </span>
                        Ringkasan Booking
                    </h2>

                    <div class="space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Rute</span>
                            <span class="font-medium">{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Tanggal</span>
                            <span class="font-medium">{{ $schedule->departure_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Waktu</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Harga per kursi</span>
                            <span class="font-medium">{{ $schedule->formatted_price }}</span>
                        </div>

                        <div class="border-t border-white/10 pt-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-slate-400">Kursi dipilih</span>
                                <span class="font-medium" id="selectedSeatsDisplay">-</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Jumlah kursi</span>
                                <span class="font-medium"><span id="seatCount">0</span> kursi</span>
                            </div>
                        </div>

                        <div class="border-t border-white/10 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-300 font-medium">Total Bayar</span>
                                <span class="text-2xl font-bold gradient-text" id="totalPrice">Rp 0</span>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn" disabled
                                class="w-full py-4 px-6 rounded-xl font-bold text-white bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 shadow-lg shadow-sky-500/25 btn-glow transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:shadow-none">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                                Lanjutkan Pembayaran
                            </span>
                        </button>

                        <p class="text-xs text-slate-400 text-center">
                            Dengan melanjutkan, Anda menyetujui syarat dan ketentuan yang berlaku
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const pricePerSeat = {{ $schedule->price }};
    const seats = document.querySelectorAll('.seat:not(.booked)');
    const seatCountEl = document.getElementById('seatCount');
    const selectedSeatsEl = document.getElementById('selectedSeatsDisplay');
    const totalPriceEl = document.getElementById('totalPrice');
    const submitBtn = document.getElementById('submitBtn');

    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    function updateSummary() {
        const checkedSeats = document.querySelectorAll('.seat-checkbox:checked');
        const selectedSeats = Array.from(checkedSeats).map(cb => cb.value);
        const count = selectedSeats.length;
        const total = count * pricePerSeat;

        seatCountEl.textContent = count;
        selectedSeatsEl.textContent = count > 0 ? selectedSeats.join(', ') : '-';
        totalPriceEl.textContent = formatRupiah(total);
        submitBtn.disabled = count === 0;
    }

    seats.forEach(seat => {
        seat.addEventListener('click', function() {
            if (this.classList.contains('booked')) return;
            
            const checkbox = this.querySelector('.seat-checkbox');
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                this.classList.add('selected');
                this.classList.add('bg-emerald-500/30', 'border-emerald-500/70');
                this.classList.remove('bg-white/10', 'border-white/20');
            } else {
                this.classList.remove('selected');
                this.classList.remove('bg-emerald-500/30', 'border-emerald-500/70');
                this.classList.add('bg-white/10', 'border-white/20');
            }
            
            updateSummary();
        });
    });

    updateSummary();
</script>
@endpush
@endsection