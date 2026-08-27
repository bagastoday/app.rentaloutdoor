@extends('layouts.app')
@section('title', 'Status Transaksi')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-sm">
    <h1 class="text-xl font-bold mb-1">{{ $rental->invoice_number }}</h1>
    <p class="text-sm text-gray-500 mb-4">Status: <span class="font-semibold uppercase">{{ $rental->status }}</span></p>

    <div class="text-sm space-y-1 text-gray-600">
        <p>Penyewa: {{ $rental->customer_name }}</p>
        <p>Tanggal: {{ $rental->start_date->translatedFormat('d M Y') }} — {{ $rental->end_date->translatedFormat('d M Y') }}</p>
        <p>Total: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
        <p>Pembayaran: {{ ucfirst($rental->payment_status) }}</p>
    </div>

    @if ($rental->status === 'booked')
        <div class="mt-4 text-xs bg-amber-50 border border-amber-200 rounded p-3 text-amber-700">
            Silakan datang ke toko pada tanggal pengambilan dengan membawa KTP/SIM/STNK asli sebagai jaminan fisik.
        </div>
    @endif
</div>
</div>
@endsection