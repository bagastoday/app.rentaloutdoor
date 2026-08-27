@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="max-w-lg mx-auto px-4 py-10 sm:py-14 space-y-5">
    <div class="text-center mb-2">
        <div class="w-14 h-14 rounded-full bg-[#EFF6FF] flex items-center justify-center mx-auto mb-2">
            <svg class="w-7 h-7 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <h1 class="text-xl font-bold text-[#0F2C5C]">Profil Saya</h1>
    </div>

    @if (session('success'))
        <div class="bg-blue-50 text-blue-700 text-sm p-3 rounded-xl border border-blue-100">{{ session('success') }}</div>
    @endif

    {{-- ================= FORM DATA KONTAK ================= --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h2 class="font-semibold text-sm text-[#0F2C5C] mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Data Kontak
        </h2>
        <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-sm font-medium text-slate-600">Nama Lengkap</label>
                <input type="text" name="name" required value="{{ old('name', $customer->name) }}" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
            </div>
            <div>
                <label class="text-sm font-medium text-slate-600">No. HP / WhatsApp</label>
                <input type="text" name="phone" required value="{{ old('phone', $customer->phone) }}" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                <p class="text-xs text-slate-400 mt-1">Ini juga dipakai untuk login.</p>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-600">Email</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                <p class="text-xs text-slate-400 mt-1">Diperlukan kalau nanti lupa password.</p>
            </div>

            @if ($errors->has('name') || $errors->has('phone') || $errors->has('email'))
                <div class="text-red-500 text-xs bg-red-50 rounded-lg p-2">
                    @foreach ($errors->only(['name', 'phone', 'email']) as $e)
                        <p>{{ is_array($e) ? $e[0] : $e }}</p>
                    @endforeach
                </div>
            @endif

            <button class="w-full bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl py-3 text-sm font-semibold transition">Simpan Perubahan</button>
        </form>
    </div>

    {{-- ================= FORM GANTI PASSWORD ================= --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h2 class="font-semibold text-sm text-[#0F2C5C] mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Ganti Password
        </h2>
        <form method="POST" action="{{ route('customer.profile.password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-sm font-medium text-slate-600">Password Lama</label>
                <input type="password" name="current_password" required class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
            </div>
            <div>
                <label class="text-sm font-medium text-slate-600">Password Baru</label>
                <input type="password" name="password" required class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
            </div>
            <div>
                <label class="text-sm font-medium text-slate-600">Ulangi Password Baru</label>
                <input type="password" name="password_confirmation" required class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
            </div>

            @if ($errors->has('current_password') || $errors->has('password'))
                <div class="text-red-500 text-xs bg-red-50 rounded-lg p-2">
                    @foreach ($errors->only(['current_password', 'password']) as $e)
                        <p>{{ is_array($e) ? $e[0] : $e }}</p>
                    @endforeach
                </div>
            @endif

            <button class="w-full bg-slate-700 hover:bg-slate-800 text-white rounded-xl py-3 text-sm font-semibold transition">Ganti Password</button>
        </form>
    </div>
</div>
@endsection