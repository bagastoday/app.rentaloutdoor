@extends('layouts.app')
@section('title', 'Daftar Akun')

@section('content')
<div class="max-w-sm mx-auto px-4 py-10 sm:py-16">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-br from-[#0F2C5C] to-[#1D4ED8] px-6 py-8 text-center text-white">
            <div class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <h1 class="text-lg font-bold">Buat Akun Baru</h1>
            <p class="text-blue-200 text-xs mt-1">Riwayat sewa tersimpan, checkout lebih cepat</p>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('customer.register.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-medium text-slate-600">Nama Lengkap</label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">Nomor HP / WhatsApp</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">Email (opsional)</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">Password</label>
                    <input type="password" name="password" required class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">Ulangi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>

                @if ($errors->any())
                    <div class="text-red-500 text-xs bg-red-50 rounded-lg p-2">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <button class="w-full bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl py-3 text-sm font-semibold transition">Daftar</button>
            </form>

            <p class="text-xs text-center text-slate-400 mt-5">
                Sudah punya akun? <a href="{{ route('customer.login') }}" class="text-[#2563EB] underline font-medium">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection