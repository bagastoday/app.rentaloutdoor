@extends('layouts.app')
@section('title', 'Simulasi Pembayaran')

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
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 8v2m9-4a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-xs text-blue-200 uppercase tracking-wide">Total Pembayaran</p>
            <p class="text-3xl font-extrabold mt-1">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
        </div>

        <div class="p-6">
            <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 text-xs text-amber-700 mb-6 flex items-start gap-2">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span><strong>Mode Simulasi</strong> — bukan pembayaran asli, buat testing alur tanpa akun Midtrans. Matikan sebelum production.</span>
            </div>

            <p class="text-xs text-slate-400 text-center mb-4">Nomor invoice akan dibuat otomatis setelah pembayaran dikonfirmasi.</p>

            <div class="space-y-3">
                <form method="POST" action="{{ route('payment.simulation.paid', $rental) }}">
                    @csrf
                    <button class="w-full bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl py-3 text-sm font-semibold transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Tandai Sudah Bayar
                    </button>
                </form>

                <form method="POST" action="{{ route('payment.simulation.failed', $rental) }}">
                    @csrf
                    <button class="w-full bg-red-50 hover:bg-red-100 text-red-600 rounded-xl py-3 text-sm font-medium transition">
                        Tandai Gagal Bayar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection