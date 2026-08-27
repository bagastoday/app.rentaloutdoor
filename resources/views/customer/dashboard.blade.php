@extends('layouts.app')
@section('title', 'Riwayat Sewa Saya')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
<h1 class="text-xl font-bold mb-4">Riwayat Sewa Saya</h1>

<div class="space-y-3">
    @forelse ($rentals as $rental)
        @if ($rental->invoice_number)
            <a href="{{ route('rental.show', $rental->invoice_number) }}" class="block bg-white p-4 rounded-lg shadow-sm hover:shadow-md">
        @else
            <div class="block bg-white p-4 rounded-lg shadow-sm opacity-60">
        @endif
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold text-sm">{{ $rental->invoice_number ?? 'Belum dibayar' }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $rental->details->pluck('item.name')->implode(', ') }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $rental->start_date->translatedFormat('d M Y') }} — {{ $rental->end_date->translatedFormat('d M Y') }}
                    </p>
                </div>
                <span class="px-2 py-0.5 rounded text-xs shrink-0
                    @class([
                        'bg-yellow-100 text-yellow-700' => $rental->status === 'pending',
                        'bg-blue-100 text-blue-700' => $rental->status === 'booked',
                        'bg-teal-100 text-teal-700' => $rental->status === 'active',
                        'bg-red-100 text-red-700' => $rental->status === 'terlambat',
                        'bg-gray-200 text-gray-700' => in_array($rental->status, ['selesai','batal']),
                    ])">
                    {{ ucfirst($rental->status) }}
                </span>
            </div>
        @if ($rental->invoice_number)
            </a>
        @else
            </div>
        @endif
    @empty
        <div class="bg-white p-6 rounded-lg shadow-sm text-center text-gray-400 text-sm">
            Kamu belum pernah menyewa alat. <a href="{{ route('catalog.index') }}" class="text-blue-700 underline">Lihat katalog</a>
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $rentals->links() }}</div>
</div>
@endsection