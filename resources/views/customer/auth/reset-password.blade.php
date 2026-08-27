@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div class="max-w-sm mx-auto px-4 py-10 sm:py-16">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-br from-[#0F2C5C] to-[#1D4ED8] px-6 py-8 text-center text-white">
            <div class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h1 class="text-lg font-bold">Buat Password Baru</h1>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('customer.password.update') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="text-sm font-medium text-slate-600">Email</label>
                    <input type="email" name="email" required value="{{ old('email', $email) }}" class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">Password Baru</label>
                    <input type="password" name="password" required class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">Ulangi Password Baru</label>
                    <input type="password" name="password_confirmation" required class="w-full rounded-xl border-slate-200 text-sm mt-1 focus:ring-2 focus:ring-[#2563EB] focus:border-transparent">
                </div>

                @if ($errors->any())
                    <div class="text-red-500 text-xs bg-red-50 rounded-lg p-2">{{ $errors->first() }}</div>
                @endif

                <button class="w-full bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl py-3 text-sm font-semibold transition">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection