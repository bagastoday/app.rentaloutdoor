@extends('layouts.app')
@section('title', 'Manajemen Transaksi')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
<h1 class="text-xl font-bold mb-4">Transaksi</h1>

<form method="GET" class="mb-4">
    <select name="status" onchange="this.form.submit()" class="rounded border-gray-300 text-sm">
        <option value="">Semua Status</option>
        @foreach (['pending','booked','active','terlambat','selesai','batal'] as $s)
            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
</form>

<div class="bg-white rounded-lg shadow-sm overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-50 text-left text-xs text-gray-500">
        <tr>
            <th class="p-3">Invoice</th>
            <th class="p-3">Penyewa</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Status</th>
            <th class="p-3">Bayar</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rentals as $rental)
            <tr class="border-t">
                <td class="p-3">{{ $rental->invoice_number }}</td>
                <td class="p-3">{{ $rental->customer_name }}</td>
                <td class="p-3">{{ $rental->start_date->format('d/m/y') }} - {{ $rental->end_date->format('d/m/y') }}</td>
                <td class="p-3">
                    <span class="px-2 py-0.5 rounded text-xs
                        @class([
                            'bg-yellow-100 text-yellow-700' => $rental->status === 'pending',
                            'bg-blue-100 text-blue-700' => $rental->status === 'booked',
                            'bg-teal-100 text-teal-700' => $rental->status === 'active',
                            'bg-red-100 text-red-700' => $rental->status === 'terlambat',
                            'bg-gray-200 text-gray-700' => in_array($rental->status, ['selesai','batal']),
                        ])">
                        {{ ucfirst($rental->status) }}
                    </span>
                </td>
                <td class="p-3">{{ ucfirst($rental->payment_status) }}</td>
                <td class="p-3 space-x-2">
                    <a href="{{ route('admin.transactions.show', $rental) }}" class="text-blue-700 underline text-xs">Detail</a>
                    @if ($rental->status === 'booked')
                        <a href="{{ route('admin.transactions.handover.form', $rental) }}" class="text-blue-700 underline text-xs">Serah-Terima</a>
                    @endif
                    @if (in_array($rental->status, ['active','terlambat']))
                        <a href="{{ route('admin.transactions.return.form', $rental) }}" class="text-orange-700 underline text-xs">Pengembalian</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

<div class="mt-4">{{ $rentals->links() }}</div>
</div>
@endsection