@extends('layouts.app')
@section('title', 'Riwayat Sewa Saya — Outdoora')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Sewa Saya</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Daftar transaksi dan status pemesanan alat outdoor Anda.</p>
        </div>

        <a href="{{ route('catalog.index') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-2.5 rounded-full transition shadow-md shadow-emerald-600/20">
            + Sewa Alat Baru
        </a>
    </div>

    <div class="space-y-4">
        @forelse ($rentals as $rental)
            @if ($rental->invoice_number)
                <a href="{{ route('rental.show', $rental->invoice_number) }}" class="block bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 transition duration-300">
            @else
                <div class="block bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm opacity-60">
            @endif
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-sm text-slate-900">{{ $rental->invoice_number ?? 'Belum dibayar' }}</span>
                            <span class="text-xs text-slate-400 font-medium">• {{ $rental->created_at->translatedFormat('d M Y, H:i') }}</span>
                        </div>
                        <p class="text-xs text-slate-600 font-semibold">
                            {{ $rental->details->pluck('item.name')->implode(', ') }}
                        </p>
                        <p class="text-xs text-slate-400 font-medium">
                            🗓️ Periode Sewa: {{ $rental->start_date->translatedFormat('d M Y') }} — {{ $rental->end_date->translatedFormat('d M Y') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold shrink-0 border
                            @class([
                                'bg-amber-50 text-amber-700 border-amber-200' => $rental->status === 'pending',
                                'bg-blue-50 text-blue-700 border-blue-200' => $rental->status === 'booked',
                                'bg-emerald-50 text-emerald-700 border-emerald-200' => $rental->status === 'active',
                                'bg-red-50 text-red-700 border-red-200' => $rental->status === 'terlambat',
                                'bg-slate-100 text-slate-700 border-slate-200' => in_array($rental->status, ['selesai','batal']),
                            ])">
                            {{ ucfirst($rental->status) }}
                        </span>

                        @if ($rental->invoice_number)
                            <span class="text-xs font-bold text-emerald-600 hover:underline flex items-center gap-1">
                                Detail →
                            </span>
                        @endif
                    </div>
                </div>
            @if ($rental->invoice_number)
                </a>
            @else
                </div>
            @endif
        @empty
            <div class="bg-white p-12 rounded-2xl border border-slate-200 text-center space-y-3 shadow-xs">
                <p class="text-slate-500 text-sm font-medium">Anda belum memiliki riwayat penyewaan alat.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block text-xs font-bold text-emerald-600 hover:underline">
                    Jelajahi Katalog Peralatan
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-8 flex justify-center">{{ $rentals->links() }}</div>
</div>
@endsection