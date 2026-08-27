@extends('layouts.app')
@section('title', $item->name . ' — Outdoora')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-zinc-500 mb-8">
        <a href="{{ route('catalog.index') }}" class="hover:text-lime-400 transition">Katalog</a>
        <span>/</span>
        <span class="text-zinc-400">{{ $item->category->name }}</span>
        <span>/</span>
        <span class="text-white font-medium">{{ $item->name }}</span>
    </div>

    <div class="grid md:grid-cols-12 gap-10">
        <!-- Product Image Preview -->
        <div class="md:col-span-6">
            <div class="h-80 sm:h-96 bg-[#111319] border border-zinc-800 rounded-3xl overflow-hidden relative flex items-center justify-center p-6">
                @if ($item->image)
                    <img src="{{ Storage::url($item->image) }}" class="w-full h-full object-cover rounded-2xl">
                @else
                    <svg class="w-24 h-24 text-zinc-700" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L2 19H22L12 3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M12 8L6 19H18L12 8Z" fill="currentColor" opacity="0.3"/>
                    </svg>
                @endif

                <span class="absolute top-4 left-4 bg-zinc-950/80 backdrop-blur border border-zinc-800 text-lime-400 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full">
                    {{ $item->category->name }}
                </span>
            </div>
        </div>

        <!-- Product Details & Booking Form -->
        <div class="md:col-span-6 space-y-6">
            <div>
                <div class="flex items-center gap-2 text-xs text-amber-400 font-bold mb-2">
                    ★★★★★ <span class="text-white">4.9</span> <span class="text-zinc-500 font-normal">(180+ ulasan)</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">{{ $item->name }}</h1>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-lime-400">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</span>
                    <span class="text-xs text-zinc-400">/ hari</span>
                </div>
            </div>

            <p class="text-sm text-zinc-400 leading-relaxed border-t border-b border-zinc-800/80 py-4">
                {{ $item->description ?? 'Peralatan outdoor kelas dunia yang terjamin kebersihan, kelengkapan, dan keandalannya untuk setiap kondisi alam.' }}
            </p>

            <!-- Interactive Booking Form -->
            <form method="GET" action="{{ route('checkout.form', $item->slug) }}"
                  class="bg-[#111319] p-6 rounded-2xl border border-zinc-800 space-y-4"
                  x-data="{ startDate: '{{ $stokTersedia !== null ? request('start_date') : '' }}', endDate: '', stock: null, checking: false }">
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-zinc-300 block mb-1.5">Tanggal Ambil</label>
                        <input type="date" name="start_date" x-model="startDate" required
                               class="w-full bg-zinc-900 border border-zinc-800 text-white rounded-xl text-xs px-3 py-2.5 focus:border-lime-400 focus:ring-0">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-zinc-300 block mb-1.5">Tanggal Kembali</label>
                        <input type="date" name="end_date" x-model="endDate" required
                               class="w-full bg-zinc-900 border border-zinc-800 text-white rounded-xl text-xs px-3 py-2.5 focus:border-lime-400 focus:ring-0">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-zinc-300 block mb-1.5">Jumlah Unit</label>
                    <input type="number" name="qty" min="1" value="1" required
                           class="w-full bg-zinc-900 border border-zinc-800 text-white rounded-xl text-xs px-3 py-2.5 focus:border-lime-400 focus:ring-0">
                </div>

                <div class="flex justify-between items-center text-xs">
                    <button type="button" @click="
                        checking = true;
                        fetch(`{{ route('catalog.checkStock', $item->slug) }}?start_date=${startDate}&end_date=${endDate}`)
                            .then(r => r.json()).then(d => { stock = d.stock; checking = false; })
                    " class="text-lime-400 font-bold hover:underline flex items-center gap-1">
                        🔍 Cek Ketersediaan Stok
                    </button>

                    <p x-show="stock !== null" :class="stock > 0 ? 'text-lime-400' : 'text-red-400'" class="font-bold">
                        <span x-text="checking ? 'Mengecek...' : (stock > 0 ? `Tersedia ${stock} unit` : 'Stok habis untuk tanggal ini')"></span>
                    </p>
                </div>

                <button type="submit" class="w-full bg-lime-400 hover:bg-lime-300 text-black font-bold py-3.5 rounded-full text-sm transition shadow-lg shadow-lime-400/20">
                    Lanjut ke Pemesanan
                </button>
            </form>

            <div class="text-xs text-zinc-400 bg-zinc-900/60 border border-zinc-800 rounded-xl p-4 flex gap-3">
                <span class="text-lime-400 text-lg">💡</span>
                <p class="leading-relaxed">
                    <strong class="text-white">Jaminan Fisik:</strong> Identitas fisik (KTP/SIM/STNK asli) diserahkan secara <u>fisik langsung di toko</u> saat pengambilan barang. Kami tidak meminta upload berkas online demi privasi Anda.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection