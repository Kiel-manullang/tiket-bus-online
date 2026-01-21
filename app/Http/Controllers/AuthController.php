<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpRegisterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // === LOGIN ===
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withInput()->withErrors(['email' => 'Email atau password salah.']);
        }

        // Cek apakah user punya kode OTP (artinya belum verifikasi)
        if (Auth::user()->role === 'user' && Auth::user()->otp_code !== null) {
            $email = Auth::user()->email;
            Auth::logout(); // Logout paksa
            return redirect()->route('otp.verify')->with('email', $email)->with('warning', 'Akun belum diverifikasi!');
        }

        $request->session()->regenerate();

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }

    // === REGISTER ===
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // 1. Generate OTP 6 Angka
        $otp = rand(100000, 999999);

        // 2. Simpan User (Tapi masih ada kode OTP-nya)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        // 3. Kirim Email (Coba kirim, kalau gagal hapus user)
        try {
            Mail::to($user->email)->send(new OtpRegisterMail($otp));
        } catch (\Exception $e) {
            $user->delete(); 
            return back()->withInput()->with('error', 'Gagal kirim email. Cek koneksi internet Anda atau password aplikasi email.');
        }

        // 4. Redirect ke halaman verifikasi
        return redirect()->route('otp.verify')->with('email', $user->email);
    }

    // === VERIFIKASI OTP ===
    public function showOtpVerify()
    {
        if (!session('email')) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) return back()->with('error', 'User tidak ditemukan.');
        if ($user->otp_code != $request->otp) return back()->with('error', 'Kode OTP Salah!');
        if (now()->greaterThan($user->otp_expires_at)) return back()->with('error', 'Kode Kadaluwarsa.');

        // Sukses: Hapus kode OTP (Tanda sudah aktif)
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        // Login Otomatis
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard');
    }

    // === LOGOUT ===
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}