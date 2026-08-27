@extends('layouts.app')
@section('title', 'Pengembalian Barang')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-sm">
    <h1 class="text-xl font-bold mb-1">Pengembalian Barang</h1>
    <p class="text-sm text-gray-500 mb-4">{{ $rental->invoice_number }} — {{ $rental->customer_name }}</p>
    <p class="text-xs text-gray-400 mb-4">Batas kembali: {{ $rental->end_date->translatedFormat('d M Y') }}</p>

    <form method="POST" action="{{ route('admin.transactions.return.store', $rental) }}" class="space-y-5">
        @csrf

        <div>
            <label class="text-sm font-medium">Tanggal Kembali Aktual</label>
            <input type="date" name="tanggal_kembali_aktual" value="{{ now()->toDateString() }}" required class="w-full rounded border-gray-300 text-sm">
        </div>

        <div class="space-y-3">
            @foreach ($rental->details as $i => $detail)
                <div class="border rounded p-3">
                    <p class="text-sm font-medium mb-2">{{ $detail->item->name }} (x{{ $detail->qty }})</p>
                    <input type="hidden" name="details[{{ $i }}][id]" value="{{ $detail->id }}">

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs">Kondisi Saat Kembali</label>
                            <select name="details[{{ $i }}][kondisi_saat_kembali]" required class="w-full rounded border-gray-300 text-sm">
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                                <option value="hilang">Hilang</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs">Klaim Kerusakan (Rp)</label>
                            <input type="number" name="details[{{ $i }}][klaim_kerusakan]" value="0" min="0" class="w-full rounded border-gray-300 text-sm">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            <label class="text-sm font-medium">Catatan Umum</label>
            <textarea name="catatan_kondisi_kembali" class="w-full rounded border-gray-300 text-sm"></textarea>
        </div>

        <div class="bg-gray-50 rounded p-3 text-xs text-gray-500">
            Denda keterlambatan dihitung otomatis oleh sistem (10% harga sewa per hari keterlambatan)
            berdasarkan tanggal kembali aktual di atas. Jaminan fisik (KTP/SIM/STNK) baru dikembalikan
            ke customer setelah seluruh biaya tambahan dilunasi secara offline.
        </div>

        <button class="w-full bg-blue-700 text-white rounded py-2 text-sm font-medium">Simpan Pengembalian</button>
    </form>
</div>
</div>
@endsection