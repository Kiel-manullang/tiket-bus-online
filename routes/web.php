<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// ═══════════════════════════════════════
// 1. PUBLIC ROUTES (Bisa Diakses Siapa Saja)
// ═══════════════════════════════════════
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// ═══════════════════════════════════════
// 2. GUEST ROUTES (Hanya untuk yang Belum Login)
// ═══════════════════════════════════════
Route::middleware('guest')->group(function () {
    // Login & Register
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    // Verifikasi OTP
    Route::get('/verify-otp', [AuthController::class, 'showOtpVerify'])->name('otp.verify');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.process');
});

// ═══════════════════════════════════════
// 3. AUTH ROUTES (Wajib Login)
// ═══════════════════════════════════════
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ───────────────────────────────────────
    // USER AREA
    // ───────────────────────────────────────
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        
        // Booking Flow
        Route::get('/bookings', [UserBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create/{schedule}', [UserBookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings/{schedule}', [UserBookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [UserBookingController::class, 'show'])->name('bookings.show');
        Route::get('/bookings/{booking}/payment', [UserBookingController::class, 'payment'])->name('bookings.payment');
        Route::post('/bookings/{booking}/payment', [UserBookingController::class, 'processPayment'])->name('bookings.payment.store');
        Route::post('/bookings/{booking}/cancel', [UserBookingController::class, 'cancel'])->name('bookings.cancel');
        Route::get('/bookings/{booking}/ticket', [UserBookingController::class, 'ticket'])->name('bookings.ticket');
    });

    // ───────────────────────────────────────
    // ADMIN AREA (Wajib Role Admin)
    // ───────────────────────────────────────
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // CRUD Master Data
        Route::resource('buses', BusController::class)->except(['show']);
        Route::resource('routes', RouteController::class)->except(['show']);
        Route::resource('schedules', ScheduleController::class)->except(['show']);
        
        // Kelola Pesanan & Pembayaran
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
        
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');

        // Setting QRIS
        Route::get('/settings/payment', [SettingController::class, 'index'])->name('settings.payment');
        Route::post('/settings/payment', [SettingController::class, 'update'])->name('settings.payment.update');
    });
});

// ═════════════════════════════════════════════════════════════════════════
// 4. ROUTE KHUSUS HOSTING (PENTING! JALANKAN INI DI BROWSER UNTUK SETUP AWAL)
// ═════════════════════════════════════════════════════════════════════════
Route::get('/run-migration-hosting', function() {
    try {
        // 1. Bersihkan database yang macet/error (db:wipe)
        Artisan::call('db:wipe', ['--force' => true]);
        
        // 2. Install ulang tabel dari nol dan isi data dummy (migrate --seed)
        Artisan::call('migrate', [
            '--force' => true,
            '--seed' => true
        ]);
        
        // 3. Link Storage agar gambar muncul
        Artisan::call('storage:link');

        return 'BERHASIL TOTAL! Database sudah bersih dan semua tabel berhasil dibuat. Silakan kembali ke halaman utama dan login.';
    } catch (\Exception $e) {
        return 'Waduh, ada masalah: ' . $e->getMessage();
    }
});