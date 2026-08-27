@extends('layouts.app')
@section('title', 'Serah-Terima Barang')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-sm">
    <h1 class="text-xl font-bold mb-1">Serah-Terima Barang</h1>
    <p class="text-sm text-gray-500 mb-4">{{ $rental->invoice_number }} — {{ $rental->customer_name }}</p>

    <div class="bg-amber-50 border border-amber-200 rounded p-3 text-xs text-amber-700 mb-4">
        Pastikan Anda sudah memeriksa dokumen identitas ASLI (KTP/SIM/STNK) customer secara fisik
        dan menyimpannya di toko sebagai jaminan. Aplikasi ini <strong>tidak</strong> menyimpan foto/scan dokumen.
    </div>

    <form method="POST" action="{{ route('admin.transactions.handover.store', $rental) }}" class="space-y-4">
        @csrf
        <div>
            <label class="text-sm font-medium">Jenis Jaminan yang Diterima</label>
            <select name="jenis_jaminan" required class="w-full rounded border-gray-300 text-sm">
                <option value="KTP">KTP</option>
                <option value="SIM">SIM</option>
                <option value="STNK">STNK</option>
            </select>
        </div>

        <div>
            <label class="text-sm font-medium">Catatan (opsional, misal 4 digit terakhir NIK)</label>
            <input type="text" name="jaminan_nomor_catatan" class="w-full rounded border-gray-300 text-sm">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_jaminan_diterima" value="1" required>
            Saya konfirmasi dokumen fisik sudah diperiksa & diterima toko.
        </label>

        <button class="w-full bg-blue-700 text-white rounded py-2 text-sm font-medium">Konfirmasi Barang Diambil</button>
    </form>
</div>
</div>
@endsection