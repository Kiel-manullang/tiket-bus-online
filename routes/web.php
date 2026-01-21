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
use Illuminate\Support\Facades\Artisan; // Tambahan untuk hosting

// ===================== HALAMAN UTAMA =====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// ===================== GUEST (LOGIN, REGISTER, OTP) =====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/verify-otp', [AuthController::class, 'showOtpVerify'])->name('otp.verify');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.process');
});

// ===================== AUTH (USER & ADMIN) =====================
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

// =========================================================================
// ROUTE KHUSUS HOSTING (PENTING! HANYA JALANKAN SEKALI SAAT DEPLOY PERTAMA)
// =========================================================================
Route::get('/run-migration-hosting', function() {
    try {
        // 1. Reset Database & Isi Data Dummy
        Artisan::call('migrate:fresh --seed --force');
        
        // 2. Link Storage (Agar gambar bisa muncul)
        Artisan::call('storage:link');
        
        // 3. Bersihkan Cache
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return 'BERHASIL! Database sudah diinstall dan Storage sudah di-link. Silakan login.';
    } catch (\Exception $e) {
        return 'ERROR: ' . $e->getMessage();
    }
});