@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
<div class="flex justify-between items-start mb-4">
    <div>
        <h1 class="text-xl font-bold">{{ $rental->invoice_number }}</h1>
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
    </div>

    <div class="space-x-2">
        @if ($rental->status === 'booked')
            <a href="{{ route('admin.transactions.handover.form', $rental) }}" class="bg-blue-700 text-white text-sm px-3 py-2 rounded">Serah-Terima Barang</a>
        @endif
        @if (in_array($rental->status, ['active', 'terlambat']))
            <a href="{{ route('admin.transactions.return.form', $rental) }}" class="bg-orange-700 text-white text-sm px-3 py-2 rounded">Proses Pengembalian</a>
        @endif
    </div>
</div>

<div class="grid md:grid-cols-3 gap-4">
    {{-- Kolom kiri: info penyewa & tanggal --}}
    <div class="md:col-span-2 space-y-4">
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h2 class="font-semibold text-sm mb-3">Data Penyewa</h2>
            <dl class="text-sm space-y-1 text-gray-600">
                <div class="flex justify-between"><dt>Nama</dt><dd class="font-medium text-gray-800">{{ $rental->customer_name }}</dd></div>
                <div class="flex justify-between"><dt>No. WhatsApp</dt><dd>{{ $rental->customer_phone }}</dd></div>
                <div class="flex justify-between"><dt>Email</dt><dd>{{ $rental->customer_email ?: '-' }}</dd></div>
                <div class="flex justify-between"><dt>Akun Terdaftar</dt><dd>{{ $rental->customer ? 'Ya (' . $rental->customer->phone . ')' : 'Tidak (guest checkout)' }}</dd></div>
            </dl>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h2 class="font-semibold text-sm mb-3">Periode Sewa</h2>
            <dl class="text-sm space-y-1 text-gray-600">
                <div class="flex justify-between"><dt>Tanggal Ambil</dt><dd>{{ $rental->start_date->translatedFormat('d M Y') }}</dd></div>
                <div class="flex justify-between"><dt>Tanggal Kembali (Rencana)</dt><dd>{{ $rental->end_date->translatedFormat('d M Y') }}</dd></div>
                <div class="flex justify-between"><dt>Tanggal Kembali (Aktual)</dt><dd>{{ $rental->dikembalikan_at ? $rental->dikembalikan_at->translatedFormat('d M Y') : '-' }}</dd></div>
                <div class="flex justify-between"><dt>Total Hari</dt><dd>{{ $rental->totalDays() }} hari</dd></div>
            </dl>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h2 class="font-semibold text-sm mb-3">Barang Disewa</h2>
            <table class="w-full text-sm">
                <thead class="text-xs text-gray-400 text-left border-b">
                    <tr><th class="pb-2">Item</th><th class="pb-2">Qty</th><th class="pb-2">Harga/Hari</th><th class="pb-2">Subtotal</th><th class="pb-2">Kondisi Kembali</th></tr>
                </thead>
                <tbody>
                    @foreach ($rental->details as $d)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $d->item->name }}</td>
                            <td class="py-2">{{ $d->qty }}</td>
                            <td class="py-2">Rp {{ number_format($d->price_per_day, 0, ',', '.') }}</td>
                            <td class="py-2">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            <td class="py-2">{{ $d->kondisi_saat_kembali ? ucfirst(str_replace('_',' ',$d->kondisi_saat_kembali)) : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($rental->catatan_kondisi_kembali)
        <div class="bg-amber-50 border border-amber-200 p-4 rounded-lg text-sm text-amber-700">
            <strong>Catatan:</strong> {{ $rental->catatan_kondisi_kembali }}
        </div>
        @endif
    </div>

    {{-- Kolom kanan: pembayaran & jaminan --}}
    <div class="space-y-4">
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h2 class="font-semibold text-sm mb-3">Pembayaran</h2>
            <dl class="text-sm space-y-1 text-gray-600">
                <div class="flex justify-between"><dt>Harga Sewa</dt><dd>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between"><dt>Denda Telat</dt><dd>Rp {{ number_format($rental->late_fee, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between"><dt>Klaim Kerusakan</dt><dd>Rp {{ number_format($rental->damage_fee, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between font-semibold text-gray-800 border-t pt-1 mt-1">
                    <dt>Total</dt><dd>Rp {{ number_format($rental->total_price + $rental->late_fee + $rental->damage_fee, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between pt-2"><dt>Metode</dt><dd>{{ $rental->payment_method ? ucfirst($rental->payment_method) : '-' }}</dd></div>
                <div class="flex justify-between"><dt>Status Bayar</dt><dd>{{ ucfirst($rental->payment_status) }}</dd></div>
                <div class="flex justify-between"><dt>Dibayar Pada</dt><dd>{{ $rental->paid_at ? $rental->paid_at->translatedFormat('d M Y H:i') : '-' }}</dd></div>
            </dl>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h2 class="font-semibold text-sm mb-3">Jaminan Fisik</h2>
            <dl class="text-sm space-y-1 text-gray-600">
                <div class="flex justify-between"><dt>Diterima?</dt><dd>{{ $rental->is_jaminan_diterima ? 'Ya' : 'Belum' }}</dd></div>
                <div class="flex justify-between"><dt>Jenis</dt><dd>{{ $rental->jenis_jaminan ?: '-' }}</dd></div>
                <div class="flex justify-between"><dt>Catatan</dt><dd>{{ $rental->jaminan_nomor_catatan ?: '-' }}</dd></div>
                <div class="flex justify-between"><dt>Diverifikasi Oleh</dt><dd>{{ $rental->verifikator->name ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt>Waktu Serah-Terima</dt><dd>{{ $rental->serah_terima_at ? $rental->serah_terima_at->translatedFormat('d M Y H:i') : '-' }}</dd></div>
            </dl>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.transactions.index') }}" class="text-sm text-blue-700 underline">&larr; Kembali ke daftar transaksi</a>
</div>
</div>
@endsection