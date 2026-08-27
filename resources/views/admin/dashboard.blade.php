@extends('layouts.app')
@section('title', 'Dashboard Admin — Outdoora')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Admin & POS</h1>
        <p class="text-xs text-slate-500 font-medium mt-1">Pilih menu manajemen inventaris atau transaksi persewaan.</p>
    </div>

    <div class="grid sm:grid-cols-2 gap-6">
        <a href="{{ route('admin.inventory.index') }}" class="group bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-emerald-300 transition duration-300 space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xl group-hover:bg-emerald-600 group-hover:text-white transition">
                📦
            </div>
            <h2 class="font-extrabold text-lg text-slate-900 group-hover:text-emerald-600 transition">Manajemen Inventory</h2>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">Kelola master barang outdoor, harga sewa, stok unit, kategori, dan kondisi peralatan.</p>
        </a>

        <a href="{{ route('admin.transactions.index') }}" class="group bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-emerald-300 transition duration-300 space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xl group-hover:bg-emerald-600 group-hover:text-white transition">
                📋
            </div>
            <h2 class="font-extrabold text-lg text-slate-900 group-hover:text-emerald-600 transition">Manajemen Transaksi (POS)</h2>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">Pantau status sewa, proses serah-terima jaminan KTP/SIM fisik, dan checklist pengembalian alat.</p>
        </a>
    </div>
</div>
@endsection