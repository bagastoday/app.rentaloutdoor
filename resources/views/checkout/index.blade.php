@extends('layouts.app')
@section('title', 'Konfirmasi Pemesanan — Outdoora')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12 sm:py-16">

    {{-- Step indicator --}}
    <div class="flex items-center justify-center gap-3 mb-10 text-xs font-bold">
        <span class="flex items-center gap-2 text-emerald-600">
            <span class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-sm">1</span> Data Penyewa
        </span>
        <span class="w-10 h-0.5 bg-slate-200"></span>
        <span class="flex items-center gap-2 text-slate-400">
            <span class="w-7 h-7 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center">2</span> Pembayaran
        </span>
        <span class="w-10 h-0.5 bg-slate-200"></span>
        <span class="flex items-center gap-2 text-slate-400">
            <span class="w-7 h-7 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center">3</span> Selesai
        </span>
    </div>

    <div class="grid md:grid-cols-5 gap-8">
        {{-- Ringkasan pesanan --}}
        <div class="md:col-span-2">
            <div class="bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 rounded-3xl p-6 text-white shadow-xl sticky top-24 space-y-4">
                <p class="text-xs text-emerald-400 uppercase tracking-widest font-bold">Ringkasan Pesanan</p>
                <div>
                    <h2 class="font-extrabold text-xl">{{ $item->name }}</h2>
                    <p class="text-emerald-300 text-xs mt-1 font-semibold">{{ $qty }} unit alat</p>
                </div>

                <div class="border-t border-slate-800 my-4"></div>

                <div class="flex items-center gap-2 text-xs text-slate-300 font-medium">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ \Carbon\Carbon::parse($start_date)->translatedFormat('d M Y') }} — {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d M Y') }}</span>
                </div>

                <div class="bg-emerald-950/60 border border-emerald-500/30 rounded-2xl p-4 text-xs text-emerald-300 flex items-start gap-2.5">
                    <span class="text-emerald-400 text-base shrink-0">💡</span>
                    <p class="leading-relaxed">Jaminan KTP/SIM/STNK asli diserahkan fisik langsung saat pengambilan alat di toko.</p>
                </div>
            </div>
        </div>

        {{-- Form data penyewa --}}
        <div class="md:col-span-3">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 space-y-6">
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Lengkapi Data Penyewa</h1>

                <form method="POST" action="{{ route('checkout.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <input type="hidden" name="qty" value="{{ $qty }}">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">

                    @auth('customer')
                        <div class="text-xs bg-emerald-50 border border-emerald-200 rounded-xl p-3.5 text-emerald-800 flex items-center gap-2 font-medium">
                            <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-[10px]">✓</span>
                            Masuk sebagai <strong>{{ auth('customer')->user()->name }}</strong>. Data di bawah terisi otomatis.
                        </div>
                    @endauth

                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Nama Lengkap</label>
                        <input type="text" name="customer_name" required value="{{ old('customer_name', auth('customer')->user()->name ?? '') }}"
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">No. WhatsApp</label>
                        <input type="text" name="customer_phone" required value="{{ old('customer_phone', auth('customer')->user()->phone ?? '') }}"
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Email (opsional)</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', auth('customer')->user()->email ?? '') }}"
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                    </div>

                    @guest('customer')
                        <p class="text-xs text-slate-500 font-medium">
                            Sudah punya akun? <a href="{{ route('customer.login') }}" class="text-emerald-600 font-bold hover:underline">Masuk dulu</a> agar riwayat sewa ini otomatis tersimpan.
                        </p>
                    @endguest

                    @if ($errors->any())
                        <div class="text-red-600 text-xs bg-red-50 border border-red-200 rounded-xl p-3 font-medium">{{ $errors->first() }}</div>
                    @endif

                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-full py-4 text-xs font-bold transition shadow-md shadow-emerald-600/20 uppercase tracking-wider">
                        Lanjut ke Pembayaran →
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection