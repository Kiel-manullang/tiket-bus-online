@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12">
    <div class="w-full max-w-5xl grid lg:grid-cols-2 gap-8 items-center">
        <div class="order-2 lg:order-1">
            <div class="bg-white/5 border border-white/10 rounded-3xl p-8 card-hover">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-sky-500/25">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold">Buat Akun Baru</h1>
                    <p class="text-slate-400 mt-2">Daftar untuk mulai memesan tiket bus</p>
                </div>

                <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                               class="input-style w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50"
                               placeholder="Masukkan nama lengkap">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="input-style w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50"
                               placeholder="nama@email.com">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-300 mb-2">No. Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                               class="input-style w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50"
                               placeholder="08xxxxxxxxxx">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                   class="input-style w-full px-4 py-3 pr-12 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50"
                                   placeholder="Minimal 8 karakter">
                            <button type="button" data-toggle-password="password" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="input-style w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50"
                               placeholder="Ketik ulang password">
                    </div>

                    <button type="submit" class="w-full py-3 px-4 rounded-xl font-semibold text-white bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 shadow-lg shadow-sky-500/25 btn-glow transition-all">
                        Daftar Sekarang
                    </button>

                    <p class="text-center text-slate-400">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-sky-400 hover:text-sky-300 font-medium hover:underline">Login di sini</a>
                    </p>
                </form>
            </div>
        </div>

        <div class="order-1 lg:order-2">
            <div class="text-center lg:text-left">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                    Pesan Tiket Bus<br>
                    <span class="gradient-text">Lebih Mudah & Cepat</span>
                </h2>
                <p class="text-slate-400 mb-8">
                    Nikmati kemudahan memesan tiket bus secara online. Pilih jadwal, kursi favorit, dan bayar dengan aman.
                </p>

                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/10">
                        <div class="w-12 h-12 rounded-xl bg-sky-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold">Booking Cepat</h3>
                            <p class="text-sm text-slate-400">Pesan tiket hanya dalam hitungan menit</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/10">
                        <div class="w-12 h-12 rounded-xl bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold">Aman & Terpercaya</h3>
                            <p class="text-sm text-slate-400">Data Anda terlindungi dengan enkripsi</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/10">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold">Pilih Kursi Sendiri</h3>
                            <p class="text-sm text-slate-400">Bebas pilih kursi favorit Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection