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
use Illuminate\Support\Facades\DB;

// ═══════════════════════════════════════
// 1. HALAMAN UTAMA & PENCARIAN
// ═══════════════════════════════════════
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// ═══════════════════════════════════════
// 2. GUEST (LOGIN, REGISTER, OTP)
// ═══════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/verify-otp', [AuthController::class, 'showOtpVerify'])->name('otp.verify');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.process');
});

// ═══════════════════════════════════════
// 3. AUTH (USER & ADMIN)
// ═══════════════════════════════════════
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- AREA USER ---
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/bookings', [UserBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create/{schedule}', [UserBookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings/{schedule}', [UserBookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [UserBookingController::class, 'show'])->name('bookings.show');
        
        Route::get('/bookings/{booking}/payment', [UserBookingController::class, 'payment'])->name('bookings.payment');
        Route::post('/bookings/{booking}/payment', [UserBookingController::class, 'processPayment'])->name('bookings.payment.store');
        
        Route::post('/bookings/{booking}/cancel', [UserBookingController::class, 'cancel'])->name('bookings.cancel');
        Route::get('/bookings/{booking}/ticket', [UserBookingController::class, 'ticket'])->name('bookings.ticket');
    });

    // --- AREA ADMIN ---
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('buses', BusController::class)->except(['show']);
        Route::resource('routes', RouteController::class)->except(['show']);
        Route::resource('schedules', ScheduleController::class)->except(['show']);
        
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
        
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');

        Route::get('/settings/payment', [SettingController::class, 'index'])->name('settings.payment');
        Route::post('/settings/payment', [SettingController::class, 'update'])->name('settings.payment.update');
    });
});

// ═════════════════════════════════════════════════════════════════════════
// 4. ROUTE SAKTI (HANYA UNTUK SETUP HOSTING PERTAMA KALI)
// ═════════════════════════════════════════════════════════════════════════
Route::get('/final-setup', function() {
    try {
        // Matikan koneksi database sementara agar bisa di-reset bersih
        DB::disconnect('pgsql');

        // PERINTAH UTAMA: Bersihkan database, buat tabel baru, dan isi data dummy (Sampri dkk)
        Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);
        
        // Buat folder storage online agar gambar bisa muncul
        Artisan::call('storage:link');

        return "🎉 BERHASIL TOTAL SAHABATKUH! Website sudah online & data rute Sumut sudah masuk. Silakan balik ke halaman utama dan login.";
    } catch (\Exception $e) {
        return "Gagal karena: " . $e->getMessage();
    }
});