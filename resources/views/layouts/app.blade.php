<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Outdoora — Sewa Peralatan Outdoor Premium')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-700 antialiased selection:bg-emerald-600 selection:text-white">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/70 shadow-xs">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('catalog.index') }}" class="flex items-center gap-2.5 font-extrabold text-xl text-slate-900 tracking-tight group">
                <span class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-700 to-teal-500 flex items-center justify-center text-white shadow-md shadow-emerald-600/20 group-hover:scale-105 transition">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3L4 19H20L12 3Z"/>
                    </svg>
                </span>
                <span>Outdoora</span>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="{{ route('catalog.index') }}" class="hover:text-emerald-600 transition">Katalog</a>
                <a href="#cara-sewa" class="hover:text-emerald-600 transition">Cara Sewa</a>
                <a href="#keunggulan" class="hover:text-emerald-600 transition">Keunggulan</a>
                <a href="#ulasan" class="hover:text-emerald-600 transition">Ulasan</a>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 text-sm font-semibold">
                @auth('web')
                    <a href="{{ route('admin.dashboard') }}" class="text-emerald-700 hover:underline">Dashboard Admin</a>
                @else
                    @auth('customer')
                        <a href="{{ route('customer.dashboard') }}" class="text-slate-600 hover:text-emerald-600">Riwayat Sewa</a>
                        <a href="{{ route('customer.profile.edit') }}" class="text-slate-600 hover:text-emerald-600">Profil</a>
                        <form method="POST" action="{{ route('customer.logout') }}" class="inline">
                            @csrf
                            <button class="text-slate-500 hover:text-slate-900">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('customer.login') }}" class="text-slate-600 hover:text-slate-900 transition px-3 py-2">Masuk</a>
                        <a href="{{ route('customer.register') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2.5 rounded-full transition shadow-md shadow-emerald-600/20 text-xs tracking-wide">
                            Daftar Sekarang
                        </a>
                    @endauth
                @endauth
            </div>
        </div>
    </nav>

    <!-- Notification Toast -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-6 pt-4">
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-3 shadow-xs">
                <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 text-sm py-16 mt-28 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 pb-12 border-b border-slate-800">
            <div class="space-y-4">
                <a href="{{ route('catalog.index') }}" class="flex items-center gap-2.5 font-extrabold text-xl text-white tracking-tight">
                    <span class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L4 19H20L12 3Z"/>
                        </svg>
                    </span>
                    <span>Outdoora</span>
                </a>
                <p class="text-slate-400 text-xs leading-relaxed">
                    Penyedia persewaan alat outdoor premium tepercaya. Nikmati petualangan alam bebas tanpa beban membeli peralatan mahal.
                </p>
            </div>

            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-4">Katalog Alat</h4>
                <ul class="space-y-2.5 text-xs font-medium">
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-emerald-400 transition">Tenda & Shelter Camping</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-emerald-400 transition">Carrier & Tas Gunungs</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-emerald-400 transition">Sleeping Bag & Matras</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-emerald-400 transition">Alat Masak & Kompor</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-4">Layanan & Informasi</h4>
                <ul class="space-y-2.5 text-xs font-medium">
                    <li><a href="#cara-sewa" class="hover:text-emerald-400 transition">Proses Cara Sewa</a></li>
                    <li><a href="#keunggulan" class="hover:text-emerald-400 transition">Jaminan Alat Steril & Bersih</a></li>
                    <li><a href="#ulasan" class="hover:text-emerald-400 transition">Ulasan Pelanggan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-4">Hubungi Kami</h4>
                <p class="text-xs text-slate-400 mb-4 leading-relaxed">Ada pertanyaan atau butuh rekomendasi alat? Tim CS kami siap membantu.</p>
                <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs px-4 py-2.5 rounded-full transition shadow-md shadow-emerald-600/20">
                    <span>💬</span> WhatsApp Customer Care
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4 font-medium">
            <p>&copy; {{ date('Y') }} Outdoora Inc. Hak Cipta Dilindungi.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-slate-300 transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-slate-300 transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>
</body>
</html>