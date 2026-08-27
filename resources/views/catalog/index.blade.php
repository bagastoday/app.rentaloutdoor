@extends('layouts.app')
@section('title', 'Outdoora — Sewa Peralatan Outdoor Premium')

@section('content')

{{-- ================= HERO SECTION ================= --}}
<section class="relative pt-12 pb-20 md:pt-20 md:pb-28 overflow-hidden bg-gradient-to-b from-slate-100/70 via-emerald-50/20 to-[#F8FAFC]">
    <!-- Soft Ambient Lighting Circles -->
    <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[650px] h-[350px] bg-emerald-200/30 blur-[130px] pointer-events-none rounded-full"></div>

    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-12 gap-12 items-center relative z-10">
        <!-- Left Content -->
        <div class="md:col-span-7 space-y-6 text-left">
            <!-- Luxury Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-100/80 border border-emerald-200 text-emerald-800 text-xs font-bold uppercase tracking-wider shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                Sewa Peralatan Outdoor Premium
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                Jelajahi Alam Bebas. <br/>
                <span class="text-emerald-600">Tanpa Beban Membeli Alat.</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-slate-600 text-base sm:text-lg max-w-xl leading-relaxed font-normal">
                Sewa peralatan mendaki dan camping kelas dunia — teruji higienis, bersih, dan siap menemani petualangan Anda. Mulai dari <span class="text-slate-900 font-bold">Rp 19.000/hari</span>.
            </p>

            <!-- Search & Actions -->
            <div class="pt-2 space-y-4">
                <form method="GET" action="{{ route('catalog.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 max-w-xl bg-white p-2 rounded-2xl sm:rounded-full border border-slate-200 shadow-lg shadow-slate-200/50 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/20 transition">
                    <div class="flex-1 flex items-center px-4 gap-3">
                        <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" placeholder="Cari tenda, carrier, sleeping bag..."
                               value="{{ request('search') }}"
                               class="w-full bg-transparent border-0 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-0 focus:outline-none py-2.5 font-medium">
                    </div>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-7 py-3.5 rounded-full transition text-sm flex items-center justify-center gap-2 shadow-md shadow-emerald-600/30">
                        <span>Cari Alat</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>

                <div class="flex flex-wrap items-center gap-6 text-xs text-slate-500 font-medium pt-1">
                    <span class="flex items-center gap-1.5 text-slate-700">
                        <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px]">✓</span>
                        Jaminan Steril & Dicuci Bersih
                    </span>
                    <span class="flex items-center gap-1.5 text-slate-700">
                        <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px]">✓</span>
                        Jaminan Fisik Cukup KTP/SIM
                    </span>
                </div>
            </div>
        </div>

        <!-- Right Visual Showcase Card -->
        <div class="md:col-span-5 relative">
            <div class="relative rounded-3xl bg-white border border-slate-200 p-6 shadow-xl shadow-slate-200/60 overflow-hidden group">
                <!-- Top Badge -->
                <div class="flex items-center justify-between mb-5">
                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-bold uppercase tracking-wider border border-emerald-200/60">
                        PILIHAN TERFAVORIT
                    </span>
                    <div class="flex items-center gap-1 text-xs text-slate-600 font-semibold">
                        <span class="text-amber-500">★</span>
                        <span class="font-bold text-slate-900">4.9</span>
                        <span class="text-slate-400 font-normal">(320+ ulasan)</span>
                    </div>
                </div>

                <!-- Product Preview Visual -->
                <div class="h-64 rounded-2xl bg-gradient-to-br from-emerald-50 to-slate-100 border border-slate-200/80 flex items-center justify-center p-6 mb-6 relative overflow-hidden group-hover:border-emerald-300 transition duration-300">
                    <svg class="w-28 h-28 text-emerald-600 group-hover:scale-105 transition duration-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L2 19H22L12 3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M12 9L7 19H17L12 9Z" fill="currentColor" opacity="0.25"/>
                    </svg>
                    <span class="absolute bottom-3 right-3 text-[10px] font-bold bg-white/90 border border-slate-200 px-3 py-1 rounded-lg text-slate-600 shadow-xs">
                        TENDA EXPEDITION 4P
                    </span>
                </div>

                <!-- Item Info -->
                <div class="space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Alpine Pro Expedition 4P</h3>
                            <p class="text-xs text-slate-500 font-medium">Tenda Gunung 4 Orang Waterproof</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xl font-extrabold text-emerald-600">Rp 65.000</span>
                            <span class="block text-[11px] text-slate-400 font-medium">/ hari</span>
                        </div>
                    </div>

                    <a href="#katalog" class="w-full bg-slate-900 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl transition text-xs flex items-center justify-center gap-2 shadow-sm">
                        Lihat Detail Peralatan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= STATS BAR ================= --}}
<section class="max-w-7xl mx-auto px-6 mb-24">
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-lg shadow-slate-200/50 grid grid-cols-2 md:grid-cols-4 gap-6 divide-y md:divide-y-0 md:divide-x divide-slate-100">
        @foreach ([
            ['50K+', 'Pendaki Puas', 'Tersewa & teruji di berbagai gunung'],
            ['2,400+', 'Peralatan Siap', 'Lengkap, higienis & siap pakai'],
            ['40+', 'Mitra Toko', 'Kemudahan pengambilan barang'],
            ['4.9 ★', 'Rating Pengguna', 'Dari 12.000+ booking sukses'],
        ] as [$num, $label, $sub])
            <div class="pt-4 md:pt-0 first:pt-0 md:px-6 text-left">
                <p class="text-3xl sm:text-4xl font-extrabold text-emerald-600 tracking-tight">{{ $num }}</p>
                <p class="text-sm font-bold text-slate-900 mt-1">{{ $label }}</p>
                <p class="text-xs text-slate-500 mt-0.5 font-medium">{{ $sub }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ================= CATALOG SECTION ================= --}}
<section id="katalog" class="max-w-7xl mx-auto px-6 pt-12 pb-24 border-t border-slate-200/80">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="space-y-2">
            <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest">KOLEKSI KATALOG</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Perlengkapan Outdoor Terbaik</h2>
            <p class="text-slate-600 text-sm max-w-xl font-normal">Pilih perlengkapan berkualitas tinggi yang dirawat secara profesional untuk kenyamanan petualangan Anda.</p>
        </div>

        <!-- Filter Category Pills -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('catalog.index') }}"
               class="px-4 py-2 rounded-full text-xs font-bold transition {{ !request('category') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
                Semua Alat
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}"
                   class="px-4 py-2 rounded-full text-xs font-bold transition {{ request('category') === $cat->slug ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($items as $item)
            <div class="group bg-white border border-slate-200/90 rounded-2xl overflow-hidden hover:shadow-xl hover:border-emerald-300 transition duration-300 flex flex-col justify-between p-5">
                <div>
                    <!-- Image Container -->
                    <div class="h-56 bg-gradient-to-br from-slate-50 to-emerald-50/30 rounded-xl overflow-hidden relative flex items-center justify-center border border-slate-100 mb-5">
                        @if ($item->image)
                            <img src="{{ Storage::url($item->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <svg class="w-16 h-16 text-slate-300 group-hover:text-emerald-500 transition duration-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3L2 19H22L12 3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M12 8L6 19H18L12 8Z" fill="currentColor" opacity="0.3"/>
                            </svg>
                        @endif

                        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur border border-slate-200 text-emerald-700 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-xs">
                            {{ $item->category->name }}
                        </span>

                        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur border border-slate-200 text-slate-700 text-[11px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1 shadow-xs">
                            <span class="text-amber-500">★</span> 4.9
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="space-y-2">
                        <h3 class="font-bold text-lg text-slate-900 group-hover:text-emerald-600 transition">{{ $item->name }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-normal">
                            {{ $item->description ?? 'Peralatan outdoor kualitas premium, bersih dan teruji siap menemani petualangan Anda.' }}
                        </p>
                    </div>
                </div>

                <!-- Price & Action -->
                <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[11px] text-slate-400 block font-medium">Harga sewa</span>
                        <span class="text-lg font-extrabold text-emerald-600">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</span>
                        <span class="text-xs text-slate-400 font-normal">/hari</span>
                    </div>

                    <a href="{{ route('catalog.show', $item->slug) }}"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-2.5 rounded-full transition flex items-center gap-1.5 shadow-md shadow-emerald-600/20">
                        <span>Sewa Alat</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center border border-slate-200 rounded-2xl bg-white space-y-3">
                <p class="text-slate-500 text-base font-medium">Belum ada barang yang cocok dengan filter atau pencarian Anda.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block text-xs font-bold text-emerald-600 hover:underline">
                    Reset Filter Pencarian
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center">
        {{ $items->links() }}
    </div>
</section>

{{-- ================= PROCESS SECTION (4 STEPS) ================= --}}
<section id="cara-sewa" class="max-w-7xl mx-auto px-6 py-20 border-t border-slate-200/80">
    <div class="text-center max-w-2xl mx-auto space-y-3 mb-16">
        <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest">PROSES PRAKTIS</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">4 Langkah Mudah Menyewa</h2>
        <p class="text-slate-600 text-sm font-normal">Proses sewa alat outdoor yang simpel dan aman tanpa ribet.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        @foreach ([
            ['01', 'Pilih & Booking', 'Pilih alat dari katalog online, pilih rentang tanggal sewa, dan booking kurang dari 2 menit.'],
            ['02', 'Pengambilan Alat', 'Datang ke toko atau pilih pengiriman. Cukup tunjukkan fisik KTP/SIM asli sebagai jaminan.'],
            ['03', 'Siap Berpetualang', 'Jelajahi alam bebas dengan tenang. Semua peralatan dalam kondisi bersih, steril & lengkap.'],
            ['04', 'Pengembalian', 'Kembalikan alat sesuai jadwal. Jaminan fisik langsung dikembalikan utuh setelah dicek.'],
        ] as [$step, $title, $desc])
            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-sm hover:border-emerald-300 hover:shadow-md transition duration-300 group">
                <span class="text-3xl font-extrabold text-emerald-600/40 group-hover:text-emerald-600 transition duration-300 block mb-4">
                    {{ $step }}
                </span>
                <h3 class="text-base font-bold text-slate-900 mb-2">{{ $title }}</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-normal">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ================= WHY OUTDOORA CTA BANNER ================= --}}
<section id="keunggulan" class="max-w-7xl mx-auto px-6 py-10">
    <div class="relative rounded-3xl bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white p-8 sm:p-14 overflow-hidden text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-8 shadow-xl">
        <div class="space-y-3 max-w-2xl relative z-10">
            <span class="text-emerald-400 text-xs font-bold uppercase tracking-widest">KEUNGGULAN OUTDOORA</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                Solusi Cerdas untuk <span class="text-emerald-400">Petualangan Anda</span>
            </h2>
            <p class="text-slate-300 text-sm leading-relaxed font-normal">
                Hentikan kebiasaan membeli alat mahal yang hanya dipakai 2 kali setahun. Sewa alat kelas dunia, hemat jutaan rupiah, dan nikmati momen berharga di alam bebas.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 relative z-10 shrink-0">
            <a href="#katalog" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold px-7 py-3.5 rounded-full transition text-sm shadow-lg shadow-emerald-500/20 text-center">
                Mulai Sewa Sekarang
            </a>
        </div>
    </div>
</section>

{{-- ================= VERIFIED REVIEWS ================= --}}
<section id="ulasan" class="max-w-7xl mx-auto px-6 py-20 border-t border-slate-200/80">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
        <div>
            <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest">ULASAN PELANGGAN</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Dipercaya Oleh 50.000+ Pendaki</h2>
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-700 bg-white border border-slate-200 px-4 py-2 rounded-full w-fit shadow-xs font-semibold">
            <div class="flex text-amber-500">★★★★★</div>
            <span class="font-extrabold text-slate-900">4.9</span>
            <span class="text-slate-500 text-xs font-normal">Rata-rata Rating</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ([
            ['Sarah Maharani', 'Pendaki Gunung Gede', 'Alatnya sangat bersih dan harum. Tenda Alpine Pro tahan terhadap angin kencang di Suryakencana. Proses ambil cukup tunjukkan KTP asli.'],
            ['Reza Pratama', 'Camper Ranca Upas', 'Awalnya ragu sewa online, ternyata saat diterima pas di toko sangat rapi. Jauh lebih hemat daripada beli sendiri yang jarang dipakai.'],
            ['Dimas Kuncoro', 'Trip Gunung Pangrango', 'Layanan CS WhatsApp sangat membantu. Saat ada kendala pasang kompor langsung dibimbing ramah. Sangat direkomendasikan!'],
        ] as [$name, $trip, $comment])
            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 space-y-4 shadow-sm hover:shadow-md transition">
                <div class="flex text-amber-500 text-sm">★★★★★</div>
                <p class="text-xs text-slate-600 leading-relaxed font-normal">"{{ $comment }}"</p>
                <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-xs">
                        {{ substr($name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">{{ $name }}</p>
                        <p class="text-[11px] text-slate-400 font-medium">{{ $trip }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection