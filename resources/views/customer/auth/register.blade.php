@extends('layouts.app')
@section('title', 'Daftar Akun Baru — Outdoora')

@section('content')
<div class="max-w-md mx-auto px-4 py-12 sm:py-20">
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden">
        <div class="bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 px-8 py-10 text-center text-white relative">
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center mx-auto mb-3 text-emerald-400">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <h1 class="text-xl font-extrabold tracking-tight">Buat Akun Baru</h1>
            <p class="text-emerald-300 text-xs mt-1 font-medium">Riwayat sewa tersimpan & proses sewa lebih cepat</p>
        </div>

        <div class="p-8">
            <form method="POST" action="{{ route('customer.register.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-bold text-slate-700 block mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-700 block mb-1.5">Nomor HP / WhatsApp</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-700 block mb-1.5">Email (opsional)</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-700 block mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-700 block mb-1.5">Ulangi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-medium">
                </div>

                @if ($errors->any())
                    <div class="text-red-600 text-xs bg-red-50 border border-red-200 rounded-xl p-3 font-medium">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-full py-3.5 text-xs font-bold transition shadow-md shadow-emerald-600/20 uppercase tracking-wider">
                    Daftar Akun Sekarang
                </button>
            </form>

            <p class="text-xs text-center text-slate-500 mt-6 font-medium">
                Sudah punya akun? <a href="{{ route('customer.login') }}" class="text-emerald-600 font-bold hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection