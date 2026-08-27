@extends('layouts.app')
@section('title', 'Lupa Password')

@section('content')
<div class="max-w-sm mx-auto px-4 py-10 sm:py-16">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-br from-[#0F2C5C] to-[#1D4ED8] px-6 py-8 text-center text-white">
            <div class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h1 class="text-lg font-bold">Lupa Password</h1>
            <p class="text-blue-200 text-xs mt-1">Kami kirimkan link reset ke emailmu</p>
        </div>

        <div class="p-6">
            <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 text-xs text-amber-700 mb-4 flex items-start gap-2">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Hanya berfungsi kalau kamu mengisi email saat daftar akun. Kalau tidak, hubungi admin toko.
            </div>

            @if (session('success'))
                <div class="bg-blue-50 text-blue-700 text-xs p-3 rounded-xl mb-4">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('customer.password.email') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-medium text-slate-600">Email Terdaftar</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>

                @if ($errors->any())
                    <div class="text-red-500 text-xs bg-red-50 rounded-lg p-2">{{ $errors->first() }}</div>
                @endif

                <button class="w-full bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl py-3 text-sm font-semibold transition">Kirim Link Reset</button>
            </form>

            <p class="text-xs text-center text-slate-400 mt-5">
                <a href="{{ route('customer.login') }}" class="text-[#2563EB] underline">Kembali ke halaman masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection