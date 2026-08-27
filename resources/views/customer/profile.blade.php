@extends('layouts.app')
@section('title', 'Profil Saya — Outdoora')

@section('content')
<div class="max-w-xl mx-auto px-4 py-12 sm:py-16 space-y-6">
    <div class="text-center mb-4">
        <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center mx-auto mb-3 shadow-xs">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Profil Saya</h1>
        <p class="text-xs text-slate-500 font-medium mt-1">Kelola data kontak & kata sandi akun Anda</p>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 text-emerald-800 text-xs font-bold p-4 rounded-2xl border border-emerald-200 shadow-xs">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- ================= FORM DATA KONTAK ================= --}}
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 space-y-4">
        <h2 class="font-extrabold text-sm text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Data Kontak Profil
        </h2>
        <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-xs font-bold text-slate-700 block mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" required value="{{ old('name', $customer->name) }}"
                       class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 block mb-1.5">No. HP / WhatsApp</label>
                <input type="text" name="phone" required value="{{ old('phone', $customer->phone) }}"
                       class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                <p class="text-[11px] text-slate-400 mt-1">Digunakan sebagai ID login Anda.</p>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 block mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                       class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                <p class="text-[11px] text-slate-400 mt-1">Diperlukan untuk reset password.</p>
            </div>

            @if ($errors->has('name') || $errors->has('phone') || $errors->has('email'))
                <div class="text-red-600 text-xs bg-red-50 rounded-xl p-3 border border-red-200">
                    @foreach ($errors->only(['name', 'phone', 'email']) as $e)
                        <p>{{ is_array($e) ? $e[0] : $e }}</p>
                    @endforeach
                </div>
            @endif

            <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-full py-3.5 text-xs font-bold transition shadow-md shadow-emerald-600/20">
                Simpan Perubahan Data
            </button>
        </form>
    </div>

    {{-- ================= FORM GANTI PASSWORD ================= --}}
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 space-y-4">
        <h2 class="font-extrabold text-sm text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Ganti Password
        </h2>
        <form method="POST" action="{{ route('customer.profile.password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-xs font-bold text-slate-700 block mb-1.5">Password Lama</label>
                <input type="password" name="current_password" required
                       class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 block mb-1.5">Password Baru</label>
                <input type="password" name="password" required
                       class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 block mb-1.5">Ulangi Password Baru</label>
                <input type="password" name="password_confirmation" required
                       class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
            </div>

            @if ($errors->has('current_password') || $errors->has('password'))
                <div class="text-red-600 text-xs bg-red-50 rounded-xl p-3 border border-red-200">
                    @foreach ($errors->only(['current_password', 'password']) as $e)
                        <p>{{ is_array($e) ? $e[0] : $e }}</p>
                    @endforeach
                </div>
            @endif

            <button class="w-full bg-slate-900 hover:bg-slate-800 text-white rounded-full py-3.5 text-xs font-bold transition shadow-sm">
                Perbarui Password
            </button>
        </form>
    </div>
</div>
@endsection