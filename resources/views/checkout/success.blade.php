@extends('layouts.app')
@section('title', 'Hasil Pembayaran')

@section('content')
<div class="max-w-md mx-auto px-4 py-10 sm:py-16">

    @if ($rental->payment_status === 'paid' && $rental->status === 'booked')
        {{-- ================= SUKSES ================= --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden text-center">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 px-6 py-10 text-white">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h1 class="text-xl font-bold">Pembayaran Berhasil!</h1>
                <p class="text-emerald-100 text-sm mt-1">Invoice kamu sudah dibuat</p>
            </div>

            <div class="p-6">
                <div class="bg-[#F7FAFF] border border-blue-100 rounded-xl p-4 text-left text-sm space-y-2">
                    <div class="flex justify-between"><span class="text-slate-400">No. Invoice</span><span class="font-semibold text-[#0F2C5C]">{{ $rental->invoice_number }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Total Bayar</span><span class="font-semibold text-[#0F2C5C]">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Tanggal Ambil</span><span>{{ $rental->start_date->translatedFormat('d M Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Tanggal Kembali</span><span>{{ $rental->end_date->translatedFormat('d M Y') }}</span></div>
                </div>

                <div class="mt-4 text-xs text-amber-700 bg-amber-50 border border-amber-100 rounded-xl p-3 flex items-start gap-2 text-left">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Datang ke toko pada tanggal pengambilan dengan membawa KTP/SIM/STNK asli sebagai jaminan fisik.
                </div>

                <p class="text-xs text-slate-400 mt-6">
                    Otomatis kembali ke beranda dalam <span id="countdown" class="font-semibold text-[#2563EB]">6</span> detik...
                </p>
                <a href="{{ route('catalog.index') }}" class="inline-block mt-2 text-sm text-[#2563EB] underline">Kembali sekarang</a>
            </div>
        </div>

        <script>
            let sisa = 6;
            const el = document.getElementById('countdown');
            const timer = setInterval(() => {
                sisa--;
                if (el) el.textContent = sisa;
                if (sisa <= 0) {
                    clearInterval(timer);
                    window.location.href = "{{ route('catalog.index') }}";
                }
            }, 1000);
        </script>

    @elseif (in_array($rental->status, ['batal']) && $rental->payment_status === 'expired')
        {{-- ================= KADALUWARSA ================= --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden text-center">
            <div class="bg-gradient-to-br from-amber-500 to-orange-600 px-6 py-10 text-white">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h1 class="text-xl font-bold">Waktu Pembayaran Habis</h1>
                <p class="text-orange-100 text-sm mt-1">Transaksi dibatalkan otomatis</p>
            </div>
            <div class="p-6">
                <p class="text-sm text-slate-500 mb-4">Melewati batas 10 menit. Silakan pesan ulang alat yang kamu inginkan.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl px-6 py-3 text-sm font-semibold transition">Kembali ke Katalog</a>
            </div>
        </div>

    @elseif ($rental->status === 'batal')
        {{-- ================= GAGAL / DIBATALKAN ================= --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden text-center">
            <div class="bg-gradient-to-br from-red-500 to-rose-600 px-6 py-10 text-white">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <h1 class="text-xl font-bold">Pembayaran Gagal</h1>
                <p class="text-red-100 text-sm mt-1">Transaksi dibatalkan</p>
            </div>
            <div class="p-6">
                <p class="text-sm text-slate-500 mb-4">Silakan coba pesan ulang alat yang kamu inginkan.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl px-6 py-3 text-sm font-semibold transition">Kembali ke Katalog</a>
            </div>
        </div>

    @else
        {{-- ================= MASIH DIPROSES ================= --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden text-center">
            <div class="bg-gradient-to-br from-slate-400 to-slate-500 px-6 py-10 text-white">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3 animate-pulse">
                    <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h1 class="text-xl font-bold">Menunggu Konfirmasi</h1>
                <p class="text-slate-200 text-sm mt-1">Halaman ini otomatis memperbarui</p>
            </div>
        </div>
        <meta http-equiv="refresh" content="3">
    @endif

</div>
@endsection