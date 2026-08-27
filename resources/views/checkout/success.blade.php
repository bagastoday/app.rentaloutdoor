@extends('layouts.app')
@section('title', 'Status Pembayaran — Outdoora')

@section('content')
<div class="max-w-md mx-auto px-6 py-12 sm:py-16">

    @if ($rental->payment_status === 'paid' && $rental->status === 'booked')
        {{-- ================= SUKSES ================= --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden text-center">
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 px-8 py-10 text-white">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight">Pembayaran Berhasil!</h1>
                <p class="text-emerald-100 text-xs mt-1 font-medium">Invoice persewaan Anda sudah terbit</p>
            </div>

            <div class="p-8 space-y-4">
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 text-left text-xs space-y-2.5 font-medium">
                    <div class="flex justify-between"><span class="text-slate-400">No. Invoice</span><span class="font-bold text-slate-900">{{ $rental->invoice_number }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Total Bayar</span><span class="font-bold text-emerald-600">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Tanggal Ambil</span><span class="text-slate-800">{{ $rental->start_date->translatedFormat('d M Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Tanggal Kembali</span><span class="text-slate-800">{{ $rental->end_date->translatedFormat('d M Y') }}</span></div>
                </div>

                <div class="text-xs text-amber-800 bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-2.5 text-left font-medium">
                    <span class="text-amber-600 text-base shrink-0">💡</span>
                    <span>Tunjukkan fisik KTP/SIM/STNK asli Anda di toko pada tanggal pengambilan barang.</span>
                </div>

                <p class="text-xs text-slate-400 mt-6 font-medium">
                    Kembali ke katalog dalam <span id="countdown" class="font-bold text-emerald-600">6</span> detik...
                </p>
                <a href="{{ route('catalog.index') }}" class="inline-block text-xs text-emerald-600 font-bold hover:underline">Kembali ke Beranda Sekarang</a>
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
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden text-center">
            <div class="bg-gradient-to-br from-amber-500 to-orange-600 px-8 py-10 text-white">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight">Waktu Pembayaran Habis</h1>
                <p class="text-orange-100 text-xs mt-1 font-medium">Transaksi dibatalkan otomatis</p>
            </div>
            <div class="p-8 space-y-4">
                <p class="text-xs text-slate-500 font-medium">Melewati batas waktu. Silakan melakukan pemesanan ulang alat yang Anda inginkan.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white rounded-full px-6 py-3.5 text-xs font-bold transition shadow-md shadow-emerald-600/20">Kembali ke Katalog</a>
            </div>
        </div>

    @elseif ($rental->status === 'batal')
        {{-- ================= GAGAL / DIBATALKAN ================= --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden text-center">
            <div class="bg-gradient-to-br from-red-500 to-rose-600 px-8 py-10 text-white">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight">Pembayaran Gagal</h1>
                <p class="text-red-100 text-xs mt-1 font-medium">Transaksi dibatalkan</p>
            </div>
            <div class="p-8 space-y-4">
                <p class="text-xs text-slate-500 font-medium">Silakan coba melakukan pemesanan ulang alat yang Anda inginkan.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white rounded-full px-6 py-3.5 text-xs font-bold transition shadow-md shadow-emerald-600/20">Kembali ke Katalog</a>
            </div>
        </div>

    @else
        {{-- ================= MASIH DIPROSES ================= --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden text-center">
            <div class="bg-gradient-to-br from-slate-700 to-slate-800 px-8 py-10 text-white">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3 animate-pulse">
                    <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight">Menunggu Konfirmasi</h1>
                <p class="text-slate-300 text-xs mt-1 font-medium">Memperbarui status transaksi...</p>
            </div>
        </div>
        <meta http-equiv="refresh" content="3">
    @endif

</div>
@endsection