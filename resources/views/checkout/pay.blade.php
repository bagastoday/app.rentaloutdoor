@extends('layouts.app')
@section('title', 'Pembayaran — Outdoora')

@section('content')
<div class="max-w-md mx-auto px-6 py-12 sm:py-16">

    <div class="flex items-center justify-center gap-3 mb-8 text-xs font-bold">
        <span class="text-emerald-600">✓ Data Penyewa</span>
        <span class="w-8 h-0.5 bg-emerald-600"></span>
        <span class="flex items-center gap-2 text-emerald-600">
            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-sm">2</span> Pembayaran
        </span>
        <span class="w-8 h-0.5 bg-slate-200"></span>
        <span class="text-slate-400">Selesai</span>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden">
        <div class="bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 px-8 py-10 text-center text-white">
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center mx-auto mb-3 text-emerald-400">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-xs text-emerald-300 uppercase tracking-widest font-bold">Total Pembayaran</p>
            <p class="text-3xl font-extrabold text-white mt-1">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
        </div>

        <div class="p-8 text-center space-y-4">
            <div class="flex items-center justify-center gap-2 text-amber-800 text-xs font-medium bg-amber-50 border border-amber-200 rounded-xl p-3.5">
                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Selesaikan pembayaran sebelum batas waktu berakhir</span>
            </div>

            <button id="pay-button" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-full py-4 text-xs font-bold transition shadow-md shadow-emerald-600/20 uppercase tracking-wider">
                Bayar Sekarang
            </button>

            <p class="text-[11px] text-slate-400 font-medium">Didukung QRIS, Transfer Bank (BCA, Mandiri, BNI, BRI), GoPay, & ShopeePay</p>
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