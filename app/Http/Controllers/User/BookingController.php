<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar booking user
     */
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with(['schedule.bus', 'schedule.route', 'payment'])
            ->latest()
            ->paginate(10);

        return view('user.bookings.index', compact('bookings'));
    }

    /**
     * Menampilkan halaman pilih kursi
     */
    public function create(Schedule $schedule)
    {
        // Cek apakah jadwal valid
        if ($schedule->status !== 'active' || $schedule->departure_date < now()->toDateString()) {
            return redirect()->route('home')->with('error', 'Jadwal tidak tersedia atau sudah lewat.');
        }

        // Ambil kursi yang sudah dibooking
        $bookedSeats = $schedule->booked_seats;
        
        // Buat array kursi total (misal 1 sampai 12)
        $allSeats = range(1, $schedule->bus->capacity);

        return view('user.bookings.create', compact('schedule', 'bookedSeats', 'allSeats'));
    }

    /**
     * Menyimpan data booking baru
     */
    public function store(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'passenger_name' => ['required', 'string', 'max:100'],
            'passenger_phone' => ['required', 'string', 'max:20'],
            'passenger_email' => ['nullable', 'email', 'max:255'],
            'seats' => ['required', 'array', 'min:1'],
            'seats.*' => ['required', 'integer', 'min:1', 'max:' . $schedule->bus->capacity],
        ]);

        // 1. Cek apakah kursi sudah dipesan orang lain (Race condition check)
        $bookedSeats = $schedule->booked_seats;
        $selectedSeats = $validated['seats'];
        
        foreach ($selectedSeats as $seat) {
            if (in_array($seat, $bookedSeats)) {
                return back()->withErrors(['seats' => 'Maaf, Kursi nomor ' . $seat . ' baru saja dipesan orang lain. Silakan pilih kursi lain.']);
            }
        }

        // 2. Cek ketersediaan jumlah kursi
        if (count($selectedSeats) > $schedule->available_seats) {
            return back()->withErrors(['seats' => 'Jumlah kursi yang dipilih melebihi ketersediaan.']);
        }

        // 3. Hitung total harga
        $totalPrice = $schedule->price * count($selectedSeats);

        // 4. Buat Booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'schedule_id' => $schedule->id,
            'booking_code' => Booking::generateBookingCode(),
            'passenger_name' => $validated['passenger_name'],
            'passenger_phone' => $validated['passenger_phone'],
            'passenger_email' => $validated['passenger_email'],
            'seat_numbers' => $selectedSeats, // Disimpan otomatis jadi JSON oleh Model Casts
            'total_seats' => count($selectedSeats),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'expired_at' => now()->addHours(2), // Batas bayar 2 jam
        ]);

        // 5. Kurangi stok kursi di jadwal
        $schedule->decrement('available_seats', count($selectedSeats));

        // Redirect ke halaman pembayaran
        return redirect()->route('user.bookings.payment', $booking);
    }

    /**
     * Menampilkan detail booking
     */
    public function show(Booking $booking)
    {
        // Pastikan yang akses adalah pemilik booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['schedule.bus', 'schedule.route', 'payment']);

        return view('user.bookings.show', compact('booking'));
    }

    /**
     * Menampilkan halaman pembayaran
     */
    public function payment(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Jika status bukan pending, redirect ke show
        if ($booking->status !== 'pending') {
            return redirect()->route('user.bookings.show', $booking);
        }

        $booking->load(['schedule.bus', 'schedule.route']);

        return view('user.bookings.payment', compact('booking'));
    }

    /**
     * Memproses upload bukti pembayaran
     */
    public function processPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return redirect()->route('user.bookings.show', $booking);
        }

        // Validasi input, termasuk 'qris'
        $validated = $request->validate([
            'payment_method' => [
                'required', 
                'in:transfer_bca,transfer_bni,transfer_bri,transfer_mandiri,ewallet_dana,ewallet_gopay,ewallet_ovo,qris'
            ],
            'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Upload file
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        } else {
            return back()->with('error', 'Gagal mengupload gambar.');
        }

        // Simpan ke tabel payments
        $booking->payment()->create([
            'payment_method' => $validated['payment_method'],
            'payment_proof' => $proofPath,
            'amount' => $booking->total_price,
            'status' => 'pending',
            'paid_at' => now(),
        ]);

        return redirect()->route('user.bookings.show', $booking)
            ->with('success', 'Bukti pembayaran berhasil diupload. Mohon tunggu verifikasi admin.');
    }

    /**
     * Membatalkan booking
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Hanya bisa batal jika status masih pending
        if (!in_array($booking->status, ['pending'])) {
            return back()->with('error', 'Booking tidak dapat dibatalkan.');
        }

        // Kembalikan kursi ke jadwal
        $booking->schedule->increment('available_seats', $booking->total_seats);

        // Update status
        $booking->update(['status' => 'cancelled']);

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }

    /**
     * Menampilkan E-Ticket
     */
    public function ticket(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Tiket hanya bisa dilihat jika sudah confirmed
        if ($booking->status !== 'confirmed') {
            return redirect()->route('user.bookings.show', $booking)
                ->with('error', 'Tiket hanya tersedia untuk booking yang sudah dikonfirmasi.');
        }

        $booking->load(['schedule.bus', 'schedule.route']);

        return view('user.bookings.ticket', compact('booking'));
    }
}