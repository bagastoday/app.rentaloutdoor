@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
<h1 class="text-xl font-bold mb-4">Dashboard Admin</h1>
<div class="grid sm:grid-cols-2 gap-4">
    <a href="{{ route('admin.inventory.index') }}" class="bg-white p-5 rounded-lg shadow-sm hover:shadow-md">
        <h2 class="font-semibold">Manajemen Inventory</h2>
        <p class="text-sm text-gray-500">Kelola master barang, kategori, dan kondisi alat.</p>
    </a>
    <a href="{{ route('admin.transactions.index') }}" class="bg-white p-5 rounded-lg shadow-sm hover:shadow-md">
        <h2 class="font-semibold">Manajemen Transaksi / POS</h2>
        <p class="text-sm text-gray-500">Pantau status sewa, serah-terima, dan pengembalian.</p>
    </a>
</div>
</div>
@endsection