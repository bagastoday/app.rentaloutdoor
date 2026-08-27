@extends('layouts.app')
@section('title', 'Manajemen Inventory')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-bold">Inventory Barang</h1>
    <a href="{{ route('admin.inventory.create') }}" class="bg-blue-700 text-white text-sm px-4 py-2 rounded">+ Tambah Barang</a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-50 text-left text-xs text-gray-500">
        <tr>
            <th class="p-3">Nama</th>
            <th class="p-3">Kategori</th>
            <th class="p-3">Stok</th>
            <th class="p-3">Harga/Hari</th>
            <th class="p-3">Kondisi</th>
            <th class="p-3">Status</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $item)
            <tr class="border-t">
                <td class="p-3">{{ $item->name }}</td>
                <td class="p-3">{{ $item->category->name }}</td>
                <td class="p-3">{{ $item->total_stock }}</td>
                <td class="p-3">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</td>
                <td class="p-3">{{ ucfirst(str_replace('_', ' ', $item->condition)) }}</td>
                <td class="p-3">
                    <span class="px-2 py-0.5 rounded text-xs {{ $item->is_active ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-500' }}">
                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="p-3">
                    <a href="{{ route('admin.inventory.edit', $item) }}" class="text-blue-700 underline text-xs">Edit</a>
                    <form action="{{ route('admin.inventory.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus barang ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 underline text-xs ml-2">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="p-6 text-center text-gray-400">Belum ada barang. Klik "Tambah Barang" untuk mulai.</td></tr>
        @endforelse
    </tbody>
</table>
</div>

<div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection