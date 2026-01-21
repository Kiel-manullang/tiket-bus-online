<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tiket Bus Online' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            50: '#e7e9ef',
                            100: '#c2c8d8',
                            200: '#9aa4be',
                            300: '#7280a4',
                            400: '#546591',
                            500: '#364a7e',
                            600: '#304376',
                            700: '#283a6b',
                            800: '#213261',
                            900: '#15224e',
                            950: '#0a1128',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        * { scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) transparent; }
        *::-webkit-scrollbar { width: 6px; height: 6px; }
        *::-webkit-scrollbar-track { background: transparent; }
        *::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
        ::selection { background: rgba(56, 189, 248, 0.3); }
        .glass { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .gradient-text { background: linear-gradient(135deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .btn-glow:hover { box-shadow: 0 0 25px rgba(56, 189, 248, 0.4); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(0,0,0,0.3); }
        .input-style { transition: all 0.2s ease; }
        .input-style:focus { box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2); }
        .seat { transition: all 0.2s ease; cursor: pointer; }
        .seat:hover:not(.booked):not(.selected) { background: rgba(56, 189, 248, 0.3); border-color: rgba(56, 189, 248, 0.5); }
        .seat.selected { background: rgba(34, 197, 94, 0.3); border-color: rgba(34, 197, 94, 0.7); }
        .seat.booked { background: rgba(239, 68, 68, 0.3); border-color: rgba(239, 68, 68, 0.5); cursor: not-allowed; }
    </style>
</head>

<body class="min-h-screen font-sans bg-navy-950 text-white antialiased">
    
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-sky-500/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/4 -right-20 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <header class="sticky top-0 z-50 border-b border-white/10 bg-navy-950/80 glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center shadow-lg shadow-sky-500/25 group-hover:shadow-sky-500/40 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-bold gradient-text">TiketMiniBus</span>
                        <p class="text-xs text-slate-400 -mt-1">Online Booking</p>
                    </div>
                </a>

                <nav class="flex items-center gap-2">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 border border-transparent hover:border-white/10 transition-all {{ request()->routeIs('admin.*') ? 'bg-white/10 border-white/10' : '' }}">
                                Admin Panel
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 border border-transparent hover:border-white/10 transition-all {{ request()->routeIs('home') ? 'bg-white/10 border-white/10' : '' }}">
                                Beranda
                            </a>
                            <a href="{{ route('user.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 border border-transparent hover:border-white/10 transition-all {{ request()->routeIs('user.dashboard') ? 'bg-white/10 border-white/10' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('user.bookings.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 border border-transparent hover:border-white/10 transition-all {{ request()->routeIs('user.bookings.*') ? 'bg-white/10 border-white/10' : '' }}">
                                Booking Saya
                            </a>
                        @endif

                        <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 ml-2">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="text-sm">
                                <p class="font-medium text-white">{{ auth()->user()->name }}</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg text-sm font-medium bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/20 hover:border-red-500/30 transition-all">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 border border-transparent hover:border-white/10 transition-all">
                            Beranda
                        </a>
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 border border-transparent hover:border-white/10 transition-all">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg text-sm font-medium bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 text-white shadow-lg shadow-sky-500/25 btn-glow transition-all">
                            Register
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('components.alert')
        @yield('content')
    </main>

    <footer class="border-t border-white/10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <span class="text-sm text-slate-400">© {{ date('Y') }} TiketBus. All rights reserved.</span>
                </div>
                <p class="text-sm text-slate-500">Sistem Pemesanan Tiket Bus Online</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-toggle-password]');
            if (!btn) return;
            const targetId = btn.getAttribute('data-toggle-password');
            const input = document.getElementById(targetId);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            if (eyeOpen && eyeClosed) {
                eyeOpen.classList.toggle('hidden', !isPassword);
                eyeClosed.classList.toggle('hidden', isPassword);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>