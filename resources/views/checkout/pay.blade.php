@extends('layouts.app')
@section('title', 'Pembayaran')

@section('content')
<div class="max-w-md mx-auto px-4 py-10 sm:py-16">

    <div class="flex items-center justify-center gap-2 mb-8 text-xs font-medium">
        <span class="text-slate-400">✓ Data Penyewa</span>
        <span class="w-8 h-px bg-slate-200"></span>
        <span class="flex items-center gap-2 text-[#2563EB]">
            <span class="w-6 h-6 rounded-full bg-[#2563EB] text-white flex items-center justify-center">2</span> Pembayaran
        </span>
        <span class="w-8 h-px bg-slate-200"></span>
        <span class="text-slate-400">Selesai</span>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-br from-[#0F2C5C] to-[#1D4ED8] px-6 py-8 text-center text-white">
            <div class="w-14 h-14 rounded-full bg-white/15 flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-xs text-blue-200 uppercase tracking-wide">Total Pembayaran</p>
            <p class="text-3xl font-extrabold mt-1">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
        </div>

        <div class="p-6 text-center">
            <div class="flex items-center justify-center gap-2 text-amber-600 text-xs mb-6 bg-amber-50 rounded-xl p-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Selesaikan dalam 10 menit sebelum pesanan otomatis dibatalkan
            </div>

            <button id="pay-button" class="w-full bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl py-3 text-sm font-semibold transition">
                Bayar Sekarang
            </button>

            <p class="text-xs text-slate-400 mt-4">Didukung QRIS, Transfer Bank, GoPay, dan ShopeePay</p>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
document.getElementById('pay-button').addEventListener('click', function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function () { window.location.href = "{{ route('checkout.success', $rental->id) }}"; },
        onPending: function () { window.location.href = "{{ route('checkout.success', $rental->id) }}"; },
        onError: function () { alert('Pembayaran gagal, silakan coba lagi.'); },
    });
});
</script>
@endsection