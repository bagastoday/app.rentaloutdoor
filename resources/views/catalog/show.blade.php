@extends('layouts.app')
@section('title', $item->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
<div class="grid md:grid-cols-2 gap-8">
    <div class="h-72 bg-gray-100 rounded-lg overflow-hidden">
        @if ($item->image)
            <img src="{{ Storage::url($item->image) }}" class="w-full h-full object-cover">
        @endif
    </div>

    <div>
        <p class="text-sm text-gray-400">{{ $item->category->name }}</p>
        <h1 class="text-2xl font-bold">{{ $item->name }}</h1>
        <p class="text-blue-700 font-bold text-xl mt-1">Rp {{ number_format($item->price_per_day, 0, ',', '.') }} / hari</p>
        <p class="text-gray-600 mt-4 text-sm leading-relaxed">{{ $item->description }}</p>

        <form method="GET" action="{{ route('checkout.form', $item->slug) }}" class="mt-6 bg-white p-4 rounded-lg shadow-sm space-y-3"
              x-data="{ startDate: '{{ $stokTersedia !== null ? request('start_date') : '' }}', endDate: '', stock: null, checking: false }">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-medium">Tanggal Ambil</label>
                    <input type="date" name="start_date" x-model="startDate" required class="w-full rounded border-gray-300 text-sm">
                </div>
                <div>
                    <label class="text-xs font-medium">Tanggal Kembali</label>
                    <input type="date" name="end_date" x-model="endDate" required class="w-full rounded border-gray-300 text-sm">
                </div>
            </div>

            <div>
                <label class="text-xs font-medium">Jumlah Unit</label>
                <input type="number" name="qty" min="1" value="1" required class="w-full rounded border-gray-300 text-sm">
            </div>

            <button type="button" @click="
                checking = true;
                fetch(`{{ route('catalog.checkStock', $item->slug) }}?start_date=${startDate}&end_date=${endDate}`)
                    .then(r => r.json()).then(d => { stock = d.stock; checking = false; })
            " class="text-xs text-blue-700 underline">Cek ketersediaan stok</button>

            <p x-show="stock !== null" class="text-xs" :class="stock > 0 ? 'text-blue-600' : 'text-red-500'">
                <span x-text="checking ? 'Mengecek...' : (stock > 0 ? `Tersedia ${stock} unit` : 'Stok habis untuk tanggal ini')"></span>
            </p>

            <button class="w-full bg-blue-700 text-white rounded py-2 text-sm font-medium">Lanjut ke Pemesanan</button>
        </form>

        <div class="mt-4 text-xs text-gray-400 bg-amber-50 border border-amber-200 rounded p-3">
            <strong>Catatan:</strong> Jaminan KTP/SIM/STNK diserahkan secara <u>fisik langsung di toko</u> saat pengambilan barang.
            Kami tidak meminta foto/scan identitas melalui aplikasi ini demi keamanan data pribadi Anda.
        </div>
    </div>
</div>
</div>
@endsection