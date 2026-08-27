@extends('layouts.app')
@section('title', isset($item) ? 'Edit Barang' : 'Tambah Barang')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-sm">
    <h1 class="text-xl font-bold mb-4">{{ isset($item) ? 'Edit Barang' : 'Tambah Barang Baru' }}</h1>

    <form method="POST"
          action="{{ isset($item) ? route('admin.inventory.update', $item) : route('admin.inventory.store') }}"
          enctype="multipart/form-data" class="space-y-4">
        @csrf
        @if (isset($item)) @method('PUT') @endif

        <div>
            <label class="text-sm font-medium">Kategori</label>
            <select name="category_id" required class="w-full rounded border-gray-300 text-sm">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(isset($item) && $item->category_id === $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm font-medium">Nama Barang</label>
            <input type="text" name="name" required value="{{ old('name', $item->name ?? '') }}" class="w-full rounded border-gray-300 text-sm">
        </div>

        <div>
            <label class="text-sm font-medium">Deskripsi</label>
            <textarea name="description" class="w-full rounded border-gray-300 text-sm">{{ old('description', $item->description ?? '') }}</textarea>
        </div>

        @if (!isset($item))
        <div>
            <label class="text-sm font-medium">Foto Barang</label>
            <input type="file" name="image" accept="image/*" class="w-full text-sm">
        </div>
        @endif

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-sm font-medium">Total Stok</label>
                <input type="number" name="total_stock" min="0" required value="{{ old('total_stock', $item->total_stock ?? 0) }}" class="w-full rounded border-gray-300 text-sm">
            </div>
            <div>
                <label class="text-sm font-medium">Harga / Hari (Rp)</label>
                <input type="number" name="price_per_day" min="0" required value="{{ old('price_per_day', $item->price_per_day ?? 0) }}" class="w-full rounded border-gray-300 text-sm">
            </div>
        </div>

        <div>
            <label class="text-sm font-medium">Kondisi Alat</label>
            <select name="condition" required class="w-full rounded border-gray-300 text-sm">
                <option value="baik" @selected(($item->condition ?? '') === 'baik')>Baik</option>
                <option value="rusak_ringan" @selected(($item->condition ?? '') === 'rusak_ringan')>Rusak Ringan</option>
                <option value="rusak_berat" @selected(($item->condition ?? '') === 'rusak_berat')>Rusak Berat</option>
            </select>
        </div>

        @if (isset($item))
        <label class="flex items-center gap-2 text-sm">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked($item->is_active)>
            Tampilkan di katalog (aktif)
        </label>
        @endif

        @if ($errors->any())
            <div class="text-red-500 text-xs">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <button class="w-full bg-blue-700 text-white rounded py-2 text-sm font-medium">
            {{ isset($item) ? 'Simpan Perubahan' : 'Tambah Barang' }}
        </button>
    </form>
</div>
</div>
@endsection