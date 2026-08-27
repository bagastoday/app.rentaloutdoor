@extends('layouts.app')
@section('title', 'Outdoora — Sewa Peralatan Outdoor')

@section('content')

{{-- ================= HERO ================= --}}
<section class="relative bg-[#0F2C5C] overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 py-16 md:py-24 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">
                Rent The Gear.<br>Live The Adventure.
            </h1>
            <p class="text-blue-200 mt-4 max-w-md">
                Sewa peralatan camping dan mendaki berkualitas tanpa perlu beli.
                Proses cepat, jaminan cukup identitas fisik, tanpa ribet upload dokumen.
            </p>

            <form method="GET" action="{{ route('catalog.index') }}" class="mt-8 flex items-center gap-2 max-w-md">
                <input type="text" name="search" placeholder="Cari tenda, carrier, sleeping bag..."
                       value="{{ request('search') }}"
                       class="flex-1 rounded-full border-0 px-5 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:ring-2 focus:ring-[#2563EB]">
                <button class="bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-full px-6 py-3 text-sm font-semibold transition">
                    Cari
                </button>
            </form>

            <div class="flex gap-6 mt-8 text-xs text-blue-200">
                <span>✓ Barang dicek kondisi</span>
                <span>✓ Serah-terima di toko</span>
            </div>
        </div>

        <div class="relative h-64 md:h-96">
            <div class="absolute inset-0 flex items-center justify-center">
                <svg viewBox="0 0 200 200" class="w-56 h-56 md:w-72 md:h-72 text-[#2563EB]" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="50" y="60" width="90" height="110" rx="12" fill="currentColor" opacity="0.9"/>
                    <rect x="60" y="40" width="70" height="40" rx="10" fill="currentColor" opacity="0.6"/>
                    <circle cx="95" cy="120" r="18" fill="#0F2C5C"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 h-16 bg-white" style="clip-path: ellipse(60% 100% at 50% 100%);"></div>
</section>

{{-- ================= STATS BAR ================= --}}
<section class="max-w-7xl mx-auto px-6 -mt-6 relative z-10">
    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 grid grid-cols-2 md:grid-cols-4 divide-x divide-slate-100">
        @foreach ([
            ['1.000+', 'Alat Tersedia'],
            ['850+', 'Kali Disewa'],
            ['98%', 'Puas'],
            ['24/7', 'Layanan'],
        ] as [$num, $label])
            <div class="p-6 text-center">
                <p class="text-2xl font-extrabold text-[#0F2C5C]">{{ $num }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $label }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ================= FILTER (disembunyikan di balik toggle simpel) ================= --}}
<section class="max-w-7xl mx-auto px-6 mt-16">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-extrabold text-[#0F2C5C]">Katalog Peralatan</h2>
            <p class="text-slate-400 text-sm mt-1">Temukan perlengkapan yang kamu butuhkan untuk petualangan berikutnya.</p>
        </div>

        <form method="GET" class="flex items-center gap-2">
            <select name="category" onchange="this.form.submit()" class="rounded-full border-slate-200 text-sm text-slate-600">
                <option value="">Semua kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->slug }}" @selected(request('category') === $cat->slug)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        @forelse ($items as $item)
            <a href="{{ route('catalog.show', $item->slug) }}" class="group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-lg transition">
                <div class="h-36 bg-[#EFF6FF] flex items-center justify-center overflow-hidden">
                    @if ($item->image)
                        <img src="{{ Storage::url($item->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                    @else
                        <svg class="w-12 h-12 text-[#2563EB]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 20L9 8L13 15L16 10L21 20H3Z" fill="currentColor" opacity="0.6"/>
                        </svg>
                    @endif
                </div>
                <div class="p-4">
                    <p class="text-xs text-slate-400">{{ $item->category->name }}</p>
                    <h3 class="font-semibold text-sm text-[#0F2C5C] mt-0.5">{{ $item->name }}</h3>
                    <p class="text-[#2563EB] font-bold text-sm mt-2">Rp {{ number_format($item->price_per_day, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">/hari</span></p>
                    <span class="inline-block mt-3 w-full text-center bg-[#0F2C5C] group-hover:bg-[#2563EB] text-white text-xs font-semibold py-2 rounded-full transition">
                        Sewa
                    </span>
                </div>
            </a>
        @empty
            <p class="col-span-full text-center text-slate-400 py-16">Belum ada alat yang cocok dengan pencarianmu.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $items->links() }}</div>
</section>

{{-- ================= CARA SEWA ================= --}}
<section id="cara-sewa" class="max-w-7xl mx-auto px-6 mt-24">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-extrabold text-[#0F2C5C]">Cara Sewa di Outdoora</h2>
        <p class="text-slate-400 text-sm mt-1">Tiga langkah sederhana, alat siap kamu bawa berpetualang.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        @foreach ([
            ['01', 'Pilih & Booking', 'Cari alat, pilih tanggal sewa, dan bayar online lewat QRIS atau transfer.'],
            ['02', 'Ambil di Toko', 'Datang bawa KTP/SIM/STNK asli sebagai jaminan fisik, alat langsung kamu bawa pulang.'],
            ['03', 'Kembalikan Tepat Waktu', 'Balikin alat sesuai jadwal, jaminan kamu kami kembalikan setelah dicek kondisinya.'],
        ] as [$num, $title, $desc])
            <div class="bg-[#EFF6FF] rounded-2xl p-6">
                <span class="text-3xl font-extrabold text-[#2563EB]/30">{{ $num }}</span>
                <h3 class="font-semibold text-[#0F2C5C] mt-2">{{ $title }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ================= CTA PENUTUP ================= --}}
<section class="mt-24 bg-[#0F2C5C]">
    <div class="max-w-7xl mx-auto px-6 py-14 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Siap untuk Menjelajahi Petualanganmu?</h2>
            <p class="text-blue-200 text-sm mt-1">Cek katalog lengkap dan mulai booking sekarang.</p>
        </div>
        <a href="#" onclick="window.scrollTo({top:0, behavior:'smooth'}); return false;" class="bg-white text-[#0F2C5C] font-semibold px-6 py-3 rounded-full text-sm whitespace-nowrap hover:bg-blue-50 transition">
            Lihat Katalog
        </a>
    </div>
</section>

@endsection