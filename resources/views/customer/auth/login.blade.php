@extends('layouts.app')
@section('title', 'Masuk Akun — Outdoora')

@section('content')
<div class="max-w-md mx-auto px-4 py-12 sm:py-20">
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden">
        <div class="bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 px-8 py-10 text-center text-white relative">
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center mx-auto mb-3 text-emerald-400">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h1 class="text-xl font-extrabold tracking-tight">Selamat Datang Kembali</h1>
            <p class="text-emerald-300 text-xs mt-1 font-medium">Masuk untuk melihat riwayat sewa & transaksi Anda</p>
        </div>

        <div class="p-8">
            <form method="POST" action="{{ route('customer.login.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-bold text-slate-700 block mb-1.5">Nomor HP / WhatsApp</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" autofocus
                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-700 block mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                </div>

                <div class="text-right">
                    <a href="{{ route('customer.password.request') }}" class="text-xs text-emerald-600 font-semibold hover:underline">Lupa password?</a>
                </div>

                @if ($errors->any())
                    <div class="text-red-600 text-xs bg-red-50 border border-red-200 rounded-xl p-3 font-medium">{{ $errors->first() }}</div>
                @endif

                <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-full py-3.5 text-xs font-bold transition shadow-md shadow-emerald-600/20 uppercase tracking-wider">
                    Masuk Akun
                </button>
            </form>

            <p class="text-xs text-center text-slate-500 mt-6 font-medium">
                Belum punya akun? <a href="{{ route('customer.register') }}" class="text-emerald-600 font-bold hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection