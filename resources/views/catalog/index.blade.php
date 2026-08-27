@extends('layouts.app')
@section('title', 'Outdoora — Gear Up. Explore More. Own Less.')

@section('content')

{{-- ================= HERO SECTION ================= --}}
<section class="relative pt-12 pb-20 md:pt-20 md:pb-32 overflow-hidden">
    <!-- Subtle Background Glow -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-lime-400/5 blur-[140px] pointer-events-none rounded-full"></div>

    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-12 gap-12 items-center">
        <!-- Left Content -->
        <div class="md:col-span-7 space-y-6 text-left">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-lime-950/60 border border-lime-500/30 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-lime-400 animate-pulse"></span>
                Premium Outdoor Gear Rental
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight leading-[1.1]">
                Gear Up. <br class="hidden sm:inline"/>Explore More. <br/>
                <span class="text-lime-400">Own Less.</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-zinc-400 text-base sm:text-lg max-w-xl leading-relaxed">
                Rent world-class outdoor equipment for any adventure — camping, hiking, kayaking, and beyond. Starting at just <span class="text-white font-semibold">Rp 19.000/day</span>.
            </p>

            <!-- Search & Actions -->
            <div class="pt-2 space-y-4">
                <form method="GET" action="{{ route('catalog.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 max-w-lg bg-zinc-900/90 p-2 rounded-2xl sm:rounded-full border border-zinc-800 focus-within:border-lime-400/50 transition">
                    <div class="flex-1 flex items-center px-4 gap-2">
                        <svg class="w-5 h-5 text-zinc-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" placeholder="Search tents, backpacks, jackets..."
                               value="{{ request('search') }}"
                               class="w-full bg-transparent border-0 text-sm text-white placeholder:text-zinc-500 focus:ring-0 focus:outline-none py-2">
                    </div>
                    <button type="submit" class="bg-lime-400 text-black font-bold px-6 py-3 rounded-full hover:bg-lime-300 transition text-sm flex items-center justify-center gap-2 shadow-lg shadow-lime-400/20">
                        Browse Gear
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>

                <div class="flex items-center gap-6 text-xs text-zinc-400 pt-1">
                    <span class="flex items-center gap-1.5 text-zinc-300">
                        <svg class="w-4 h-4 text-lime-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Free delivery on orders > Rp 150.000
                    </span>
                    <span class="flex items-center gap-1.5 text-zinc-300">
                        <svg class="w-4 h-4 text-lime-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        24/7 Support & Insurance
                    </span>
                </div>
            </div>
        </div>

        <!-- Right Visual Card Showcase -->
        <div class="md:col-span-5 relative">
            <div class="relative rounded-3xl bg-gradient-to-b from-zinc-800/80 to-zinc-950 border border-zinc-800 p-6 shadow-2xl overflow-hidden group">
                <!-- Top Badge -->
                <div class="flex items-center justify-between mb-6">
                    <span class="px-3 py-1 rounded-full bg-lime-400/10 text-lime-400 text-[11px] font-bold uppercase tracking-wider border border-lime-400/20">
                        POPULAR CHOICE
                    </span>
                    <div class="flex items-center gap-1 text-xs text-zinc-300">
                        <span class="text-amber-400">★</span>
                        <span class="font-bold text-white">4.9</span>
                        <span class="text-zinc-500">(320+ reviews)</span>
                    </div>
                </div>

                <!-- Product Preview Card -->
                <div class="h-60 rounded-2xl bg-zinc-900 border border-zinc-800/80 flex items-center justify-center p-6 mb-6 relative overflow-hidden group-hover:border-lime-500/30 transition">
                    <svg class="w-28 h-28 text-lime-400/80 group-hover:scale-110 transition duration-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L2 19H22L12 3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M12 9L7 19H17L12 9Z" fill="currentColor" opacity="0.3"/>
                    </svg>
                    <span class="absolute bottom-3 right-3 text-[10px] font-mono bg-zinc-950/80 border border-zinc-800 px-2.5 py-1 rounded-md text-zinc-400">
                        SHELTER / TENT
                    </span>
                </div>

                <!-- Item Info -->
                <div class="space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-white">Alpine Pro Expedition 4P</h3>
                            <p class="text-xs text-zinc-400">4-Person All-Weather Mountain Tent</p>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-black text-lime-400">Rp 65.000</span>
                            <span class="block text-[10px] text-zinc-500">/ hari</span>
                        </div>
                    </div>

                    <a href="#katalog" class="w-full bg-zinc-900 border border-zinc-700 hover:border-lime-400 text-white hover:text-lime-400 font-semibold py-3 rounded-xl transition text-xs flex items-center justify-center gap-2">
                        Reserve Gear Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= STATS BAR ================= --}}
<section class="max-w-7xl mx-auto px-6 mb-24">
    <div class="bg-[#111319]/90 border border-zinc-800/80 rounded-2xl p-6 sm:p-8 grid grid-cols-2 md:grid-cols-4 gap-6 divide-y md:divide-y-0 md:divide-x divide-zinc-800/80">
        @foreach ([
            ['50K+', 'Happy Adventurers', 'Verified reviews & renters'],
            ['2,400+', 'Gear Items', 'Cleaned & tested equipment'],
            ['40+', 'Pickup Locations', 'Fast & convenient access'],
            ['4.9 ★', 'Avg. Rating', 'From 12,000+ bookings'],
        ] as [$num, $label, $sub])
            <div class="pt-4 md:pt-0 first:pt-0 md:px-6 text-left">
                <p class="text-3xl sm:text-4xl font-black text-lime-400 tracking-tight">{{ $num }}</p>
                <p class="text-sm font-bold text-white mt-1">{{ $label }}</p>
                <p class="text-xs text-zinc-500 mt-0.5">{{ $sub }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ================= CATALOG / CURATED COLLECTION ================= --}}
<section id="katalog" class="max-w-7xl mx-auto px-6 pt-12 pb-24 border-t border-zinc-900">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="space-y-2">
            <span class="text-lime-400 text-xs font-bold uppercase tracking-widest">CURATED COLLECTION</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">Premium Gear, Fraction of the Price</h2>
            <p class="text-zinc-400 text-sm max-w-xl">Hand-selected, professionally maintained equipment for every type of adventure.</p>
        </div>

        <!-- Filter Category Tabs -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('catalog.index') }}"
               class="px-4 py-2 rounded-full text-xs font-bold transition {{ !request('category') ? 'bg-lime-400 text-black shadow-lg shadow-lime-400/20' : 'bg-zinc-900 border border-zinc-800 text-zinc-300 hover:border-zinc-700' }}">
                All Items
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}"
                   class="px-4 py-2 rounded-full text-xs font-bold transition {{ request('category') === $cat->slug ? 'bg-lime-400 text-black shadow-lg shadow-lime-400/20' : 'bg-zinc-900 border border-zinc-800 text-zinc-300 hover:border-zinc-700' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($items as $item)
            <div class="group bg-[#111319] border border-zinc-800/80 rounded-2xl overflow-hidden hover:border-lime-500/40 transition flex flex-col justify-between p-5">
                <div>
                    <!-- Image / Icon Container -->
                    <div class="h-52 bg-zinc-900/90 rounded-xl overflow-hidden relative flex items-center justify-center border border-zinc-800/60 mb-5">
                        @if ($item->image)
                            <img src="{{ Storage::url($item->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <svg class="w-16 h-16 text-zinc-700 group-hover:text-lime-400/70 transition duration-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3L2 19H22L12 3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M12 8L6 19H18L12 8Z" fill="currentColor" opacity="0.3"/>
                            </svg>
                        @endif

                        <span class="absolute top-3 left-3 bg-zinc-950/80 backdrop-blur border border-zinc-800 text-lime-400 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md">
                            {{ $item->category->name }}
                        </span>

                        <span class="absolute top-3 right-3 bg-zinc-950/80 backdrop-blur border border-zinc-800 text-zinc-300 text-[11px] font-bold px-2 py-1 rounded-md flex items-center gap-1">
                            <span class="text-amber-400">★</span> 4.9
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="space-y-2">
                        <h3 class="font-bold text-lg text-white group-hover:text-lime-400 transition">{{ $item->name }}</h3>
                        <p class="text-xs text-zinc-400 line-clamp-2 leading-relaxed">
                            {{ $item->description ?? 'Peralatan outdoor kualitas premium, teruji dan bersih siap digunakan untuk petualangan Anda.' }}
                        </p>
                    </div>
                </div>

                <!-- Price & Action -->
                <div class="pt-5 mt-5 border-t border-zinc-800/80 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-zinc-500 block">Sewa mulai</span>
                        <span class="text-lg font-black text-lime-400">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</span>
                        <span class="text-xs text-zinc-500">/hari</span>
                    </div>

                    <a href="{{ route('catalog.show', $item->slug) }}"
                       class="bg-lime-400 hover:bg-lime-300 text-black font-bold text-xs px-4 py-2.5 rounded-full transition flex items-center gap-1.5 shadow-md shadow-lime-400/10">
                        Reserve
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center border border-zinc-800 rounded-2xl bg-[#111319]/50 space-y-3">
                <p class="text-zinc-400 text-base">Belum ada barang yang cocok dengan filter atau pencarian Anda.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block text-xs font-bold text-lime-400 hover:underline">
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

{{-- ================= PROCESS SECTION (4 EASY STEPS) ================= --}}
<section id="cara-sewa" class="max-w-7xl mx-auto px-6 py-20 border-t border-zinc-900">
    <div class="text-center max-w-2xl mx-auto space-y-3 mb-16">
        <span class="text-lime-400 text-xs font-bold uppercase tracking-widest">SIMPLE PROCESS</span>
        <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">Adventure in 4 Easy Steps</h2>
        <p class="text-zinc-400 text-sm">Proses sewa serba praktis tanpa ribet upload identitas digital.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
        @foreach ([
            ['01', 'Browse & Book', 'Explore our catalog. Filter by activity and duration. Reserve in under 2 minutes.'],
            ['02', 'We Deliver / Pick Up', 'Gear arrives cleaned and tested at your door, or pick up at partner spots.'],
            ['03', 'Go Adventuring', 'Head out with confidence. Every rental includes 24/7 support and gear insurance.'],
            ['04', 'Easy Return', 'Drop off or schedule pickup. We handle the rest — you plan the next trip.'],
        ] as [$step, $title, $desc])
            <div class="bg-[#111319] border border-zinc-800/80 rounded-2xl p-6 relative hover:border-lime-500/30 transition group">
                <span class="text-4xl font-black text-zinc-700 group-hover:text-lime-400/50 transition duration-300 block mb-4">
                    {{ $step }}
                </span>
                <h3 class="text-lg font-bold text-white mb-2">{{ $title }}</h3>
                <p class="text-xs text-zinc-400 leading-relaxed">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ================= WHY OUTDOORA CTA BANNER ================= --}}
<section id="mengapa-kami" class="max-w-7xl mx-auto px-6 py-12">
    <div class="relative rounded-3xl bg-gradient-to-r from-zinc-900 via-[#111319] to-zinc-900 border border-zinc-800 p-8 sm:p-14 overflow-hidden text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-8">
        <!-- Accent Glow -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-lime-400/10 blur-[100px] pointer-events-none rounded-full"></div>

        <div class="space-y-3 max-w-2xl relative z-10">
            <span class="text-lime-400 text-xs font-bold uppercase tracking-widest">WHY OUTDOORA</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                The Smart Way to <span class="text-lime-400">Explore the Wild</span>
            </h2>
            <p class="text-zinc-400 text-sm leading-relaxed">
                Hentikan kebiasaan membeli alat mahal yang hanya dipakai 2 kali sebulan. Sewa peralatan outdoor kelas dunia, hemat jutaan rupiah, dan bawa pulang pengalaman berharga.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 relative z-10 shrink-0">
            <a href="#katalog" class="bg-lime-400 text-black font-bold px-7 py-3.5 rounded-full hover:bg-lime-300 transition text-sm shadow-lg shadow-lime-400/20 text-center">
                Start Your Adventure
            </a>
        </div>
    </div>
</section>

{{-- ================= VERIFIED REVIEWS / TESTIMONIALS ================= --}}
<section id="ulasan" class="max-w-7xl mx-auto px-6 py-20 border-t border-zinc-900">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
        <div>
            <span class="text-lime-400 text-xs font-bold uppercase tracking-widest">VERIFIED REVIEWS</span>
            <h2 class="text-3xl font-black text-white tracking-tight mt-1">Trusted by 50,000+ Adventurers</h2>
        </div>
        <div class="flex items-center gap-2 text-sm text-zinc-300 bg-zinc-900 border border-zinc-800 px-4 py-2 rounded-full w-fit">
            <div class="flex text-amber-400">★★★★★</div>
            <span class="font-bold text-white">4.9</span>
            <span class="text-zinc-500 text-xs">Average Rating</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ([
            ['Sarah M.', 'Pendaki Gunung Gede', 'Alatnya super bersih, tenda Alpine Pro kokoh banget pas kena angin kencang di surken. Proses ambil di toko tinggal tunjukin KTP fisik, cepet banget!'],
            ['Reza Pratama', 'Camper Ranca Upas', 'Awalnya ragu sewa online, tapi pas barang diterima wangi dan lengkap semua pegangannya. Jauh lebih hemat daripada beli sendiri.'],
            ['Dimas K.', 'Trip Camping Pangrango', 'Layanan CS WhatsApp fast respon 24 jam. Pas malam ada kendala masang kompor langsung dibantu via video call. Recommended!'],
        ] as [$name, $trip, $comment])
            <div class="bg-[#111319] border border-zinc-800/80 rounded-2xl p-6 space-y-4">
                <div class="flex text-amber-400 text-sm">★★★★★</div>
                <p class="text-xs text-zinc-300 leading-relaxed">"{{ $comment }}"</p>
                <div class="pt-4 border-t border-zinc-800/60 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-lime-400/20 text-lime-400 font-bold flex items-center justify-center text-xs border border-lime-400/30">
                        {{ substr($name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">{{ $name }}</p>
                        <p class="text-[11px] text-zinc-500">{{ $trip }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection