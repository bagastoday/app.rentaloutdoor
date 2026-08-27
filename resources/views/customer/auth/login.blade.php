@extends('layouts.app')
@section('title', 'Masuk Akun')

@section('content')
<div class="max-w-sm mx-auto px-4 py-10 sm:py-16">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-br from-[#0F2C5C] to-[#1D4ED8] px-6 py-8 text-center text-white">
            <div class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h1 class="text-lg font-bold">Selamat Datang Kembali</h1>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('customer.login.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-medium text-slate-600">Nomor HP / WhatsApp</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" autofocus class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">Password</label>
                    <input type="password" name="password" required class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>

                <p class="text-xs text-right">
                    <a href="{{ route('customer.password.request') }}" class="text-[#2563EB] underline">Lupa password?</a>
                </p>

                @if ($errors->any())
                    <div class="text-red-500 text-xs bg-red-50 rounded-lg p-2">{{ $errors->first() }}</div>
                @endif

                <button class="w-full bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl py-3 text-sm font-semibold transition">Masuk</button>
            </form>

            <p class="text-xs text-center text-slate-400 mt-5">
                Belum punya akun? <a href="{{ route('customer.register') }}" class="text-[#2563EB] underline font-medium">Daftar di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection