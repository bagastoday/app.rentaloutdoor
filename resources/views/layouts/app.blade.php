<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Outdoora — Sewa Peralatan Outdoor')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F7FAFF] text-slate-700 antialiased" style="background-image: radial-gradient(circle at 10% 0%, #EFF6FF 0%, transparent 40%), radial-gradient(circle at 90% 10%, #EEF2FF 0%, transparent 35%);">
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('catalog.index') }}" class="flex items-center gap-2 font-extrabold text-lg text-[#0F2C5C]">
                <svg class="w-6 h-6 text-[#2563EB]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 20L9 8L13 15L16 10L21 20H3Z" fill="currentColor"/>
                </svg>
                Outdoora
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="{{ route('catalog.index') }}" class="hover:text-[#2563EB]">Home</a>
                <a href="{{ route('catalog.index') }}" class="hover:text-[#2563EB]">Katalog</a>
                <a href="#cara-sewa" class="hover:text-[#2563EB]">Cara Sewa</a>
                <a href="#kontak" class="hover:text-[#2563EB]">Kontak</a>
            </div>

            <div class="flex items-center gap-4 text-sm font-medium">
                @auth('web')
                    <a href="{{ route('admin.dashboard') }}" class="text-[#0F2C5C] hover:underline">Dashboard Admin</a>
                @else
                    @auth('customer')
                        <a href="{{ route('customer.dashboard') }}" class="text-slate-600 hover:text-[#2563EB]">Riwayat Sewa</a>
                        <a href="{{ route('customer.profile.edit') }}" class="text-slate-600 hover:text-[#2563EB]">Profil</a>
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button class="text-slate-600 hover:text-[#2563EB]">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('customer.login') }}" class="text-slate-600 hover:text-[#2563EB]">Masuk</a>
                        <a href="{{ route('customer.register') }}" class="bg-[#2563EB] text-white px-4 py-2 rounded-full hover:bg-[#1D4ED8] transition">Daftar</a>
                    @endauth
                @endauth
            </div>
        </div>
    </nav>

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-6 pt-4">
            <div class="p-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm border border-emerald-100">{{ session('success') }}</div>
        </div>
    @endif

    @yield('content')

    <footer class="bg-[#0F2C5C] text-blue-100 text-sm py-8 mt-16">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between gap-4">
            <p>&copy; {{ date('Y') }} Outdoora. Sewa peralatan outdoor tepercaya.</p>
            <p id="kontak">Butuh bantuan? Hubungi kami di WhatsApp toko.</p>
        </div>
    </footer>
</body>
</html>