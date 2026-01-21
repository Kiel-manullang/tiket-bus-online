@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="w-full max-w-md bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold">Masukkan Kode OTP</h1>
            <p class="text-slate-400 mt-2 text-sm">
                Kode 6 digit telah dikirim ke email:<br>
                <span class="text-sky-400 font-semibold">{{ session('email') }}</span>
            </p>
        </div>

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-500/20 text-red-400 text-sm text-center rounded-xl border border-red-500/30">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.process') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">

            <div>
                <input type="text" 
                       name="otp" 
                       required 
                       autofocus 
                       maxlength="6"
                       class="w-full px-4 py-4 rounded-2xl bg-navy-900/50 border-2 border-white/10 text-white text-center text-3xl tracking-[0.5em] font-mono focus:outline-none focus:border-sky-500 transition-all placeholder-slate-700"
                       placeholder="000000">
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl font-bold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 shadow-lg shadow-sky-500/25 transition-all">
                Verifikasi
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-xs text-slate-500">Tidak menerima email? Cek folder SPAM.</p>
            <a href="{{ route('register') }}" class="text-sm text-sky-400 hover:underline mt-2 inline-block">
                Salah email? Daftar ulang
            </a>
        </div>
    </div>
</div>
@endsection