<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Outdoora — Premium Outdoor Gear Rental')</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#090A0F] text-zinc-300 antialiased selection:bg-lime-400 selection:text-black">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-[#090A0F]/90 backdrop-blur-md border-b border-zinc-800/80">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('catalog.index') }}" class="flex items-center gap-2 font-extrabold text-xl text-white tracking-tight">
                <span class="w-8 h-8 rounded-lg bg-lime-400 flex items-center justify-center text-black">
                    <svg class="w-5 h-5 text-black" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3L4 19H20L12 3Z"/>
                    </svg>
                </span>
                Outdoora
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-zinc-400">
                <a href="{{ route('catalog.index') }}" class="hover:text-lime-400 transition">Katalog</a>
                <a href="#cara-sewa" class="hover:text-lime-400 transition">Cara Sewa</a>
                <a href="#mengapa-kami" class="hover:text-lime-400 transition">Keunggulan</a>
                <a href="#ulasan" class="hover:text-lime-400 transition">Ulasan</a>
            </div>

            <div class="flex items-center gap-4 text-sm font-medium">
                @auth('web')
                    <a href="{{ route('admin.dashboard') }}" class="text-lime-400 hover:underline">Dashboard Admin</a>
                @else
                    @auth('customer')
                        <a href="{{ route('customer.dashboard') }}" class="text-zinc-300 hover:text-lime-400">Riwayat Sewa</a>
                        <a href="{{ route('customer.profile.edit') }}" class="text-zinc-300 hover:text-lime-400">Profil</a>
                        <form method="POST" action="{{ route('customer.logout') }}" class="inline">
                            @csrf
                            <button class="text-zinc-400 hover:text-white">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('customer.login') }}" class="text-zinc-300 hover:text-white transition px-3 py-2">Masuk</a>
                        <a href="{{ route('customer.register') }}" class="bg-lime-400 text-black font-bold px-5 py-2.5 rounded-full hover:bg-lime-300 transition shadow-lg shadow-lime-400/20 text-xs uppercase tracking-wider">
                            Get Started
                        </a>
                    @endauth
                @endauth
            </div>
        </div>
    </nav>

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-6 pt-4">
            <div class="p-4 rounded-xl bg-lime-950/80 border border-lime-500/40 text-lime-300 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-lime-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#090A0F] border-t border-zinc-800 text-zinc-400 text-sm py-12 mt-24">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-zinc-800/60">
            <div class="space-y-4">
                <a href="{{ route('catalog.index') }}" class="flex items-center gap-2 font-extrabold text-xl text-white tracking-tight">
                    <span class="w-8 h-8 rounded-lg bg-lime-400 flex items-center justify-center text-black">
                        <svg class="w-5 h-5 text-black" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L4 19H20L12 3Z"/>
                        </svg>
                    </span>
                    Outdoora
                </a>
                <p class="text-zinc-500 text-xs leading-relaxed">
                    Sewa alat outdoor kelas dunia. Nikmati petualangan tanpa batas tanpa beban memiliki alat mahal.
                </p>
            </div>

            <div>
                <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Produk</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-lime-400 transition">Tenda & Shelter</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-lime-400 transition">Carrier & Tas</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-lime-400 transition">Sleeping Bag</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-lime-400 transition">Alat Masak Camping</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Layanan</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#cara-sewa" class="hover:text-lime-400 transition">Cara Sewa</a></li>
                    <li><a href="#mengapa-kami" class="hover:text-lime-400 transition">Jaminan Alat Bersih</a></li>
                    <li><a href="#ulasan" class="hover:text-lime-400 transition">Ulasan Pelanggan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Bantuan & Kontak</h4>
                <p class="text-xs text-zinc-500 mb-3">Butuh bantuan cepat? Hubungi CS kami di WhatsApp.</p>
                <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 bg-zinc-900 border border-zinc-800 text-lime-400 text-xs px-4 py-2 rounded-full hover:border-lime-400/50 transition">
                    💬 WhatsApp Admin
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-zinc-600 gap-4">
            <p>&copy; {{ date('Y') }} Outdoora Inc. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-zinc-400 transition">Privasi</a>
                <a href="#" class="hover:text-zinc-400 transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>
</body>
</html>