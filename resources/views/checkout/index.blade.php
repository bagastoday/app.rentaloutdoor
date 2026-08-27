@extends('layouts.app')
@section('title', 'Konfirmasi Pemesanan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10 sm:py-14">

    {{-- Step indicator --}}
    <div class="flex items-center justify-center gap-2 mb-10 text-xs font-medium">
        <span class="flex items-center gap-2 text-[#2563EB]">
            <span class="w-6 h-6 rounded-full bg-[#2563EB] text-white flex items-center justify-center">1</span> Data Penyewa
        </span>
        <span class="w-8 h-px bg-slate-200"></span>
        <span class="flex items-center gap-2 text-slate-400">
            <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center">2</span> Pembayaran
        </span>
        <span class="w-8 h-px bg-slate-200"></span>
        <span class="flex items-center gap-2 text-slate-400">
            <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center">3</span> Selesai
        </span>
    </div>

    <div class="grid md:grid-cols-5 gap-6">
        {{-- Ringkasan pesanan --}}
        <div class="md:col-span-2">
            <div class="bg-gradient-to-br from-[#0F2C5C] to-[#1D4ED8] rounded-2xl p-6 text-white shadow-lg shadow-blue-900/10 sticky top-24">
                <p class="text-xs text-blue-200 uppercase tracking-wide mb-1">Ringkasan Pesanan</p>
                <h2 class="font-bold text-lg">{{ $item->name }}</h2>
                <p class="text-blue-200 text-sm mt-1">{{ $qty }} unit</p>

                <div class="border-t border-white/20 my-4"></div>

                <div class="flex items-center gap-2 text-sm text-blue-100">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d M Y') }} — {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d M Y') }}
                </div>

                <div class="mt-6 bg-white/10 rounded-xl p-3 text-xs text-blue-100 flex items-start gap-2">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Jaminan cukup KTP/SIM/STNK fisik saat ambil barang — tanpa upload dokumen apapun.
                </div>
            </div>
        </div>

        {{-- Form data penyewa --}}
        <div class="md:col-span-3">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h1 class="text-lg font-bold text-[#0F2C5C] mb-4">Data Penyewa</h1>

                <form method="POST" action="{{ route('checkout.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <input type="hidden" name="qty" value="{{ $qty }}">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">

                    @auth('customer')
                        <div class="text-xs bg-blue-50 border border-blue-100 rounded-xl p-3 text-blue-700 flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Masuk sebagai <strong>{{ auth('customer')->user()->name }}</strong>. Data di bawah otomatis terisi.
                        </div>
                    @endauth

                    <div>
                        <label class="text-sm font-medium text-slate-600">Nama Lengkap</label>
                        <input type="text" name="customer_name" required value="{{ old('customer_name', auth('customer')->user()->name ?? '') }}" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600">No. WhatsApp</label>
                        <input type="text" name="customer_phone" required value="{{ old('customer_phone', auth('customer')->user()->phone ?? '') }}" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600">Email (opsional)</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', auth('customer')->user()->email ?? '') }}" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                    </div>

                    @guest('customer')
                        <p class="text-xs text-slate-400">
                            Sudah punya akun? <a href="{{ route('customer.login') }}" class="text-[#2563EB] underline">Masuk dulu</a> biar riwayat sewa ini tersimpan otomatis.
                        </p>
                    @endguest

                    @if ($errors->any())
                        <div class="text-red-500 text-xs bg-red-50 rounded-lg p-2">{{ $errors->first() }}</div>
                    @endif

                    <button class="w-full bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl py-3 text-sm font-semibold transition">
                        Lanjut ke Pembayaran →
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection