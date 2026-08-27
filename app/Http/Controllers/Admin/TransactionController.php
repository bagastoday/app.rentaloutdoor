<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * List transaksi + filter status, untuk dashboard/POS admin.
     */
    public function index(Request $request)
    {
        $query = Rental::with('details.item')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Auto-tandai transaksi yang lewat tanggal kembali tapi belum dikembalikan
        Rental::where('status', 'active')
            ->where('end_date', '<', now()->toDateString())
            ->update(['status' => 'terlambat']);

        $rentals = $query->paginate(15)->withQueryString();

        return view('admin.transactions.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load('details.item');
        return view('admin.transactions.show', compact('rental'));
    }

    /**
     * MODUL SERAH-TERIMA BARANG.
     * Dilakukan di toko saat customer datang mengambil barang.
     * Admin mencentang bahwa jaminan KTP/SIM/STNK fisik SUDAH diperiksa & dipegang toko.
     * Tidak ada upload foto — hanya pencatatan boolean + jenis dokumen.
     */
    public function handoverForm(Rental $rental)
    {
        abort_if($rental->status !== 'booked', 403, 'Transaksi belum lunas / tidak dalam status booked.');
        return view('admin.transactions.handover', compact('rental'));
    }

    public function handoverStore(Request $request, Rental $rental)
    {
        abort_if($rental->status !== 'booked', 403, 'Transaksi belum lunas / tidak dalam status booked.');

        $validated = $request->validate([
            'is_jaminan_diterima' => 'required|boolean|accepted',
            'jenis_jaminan' => 'required|in:KTP,SIM,STNK',
            'jaminan_nomor_catatan' => 'nullable|string|max:100',
        ]);

        $rental->update([
            'is_jaminan_diterima' => true,
            'jenis_jaminan' => $validated['jenis_jaminan'],
            'jaminan_nomor_catatan' => $validated['jaminan_nomor_catatan'] ?? null,
            'diverifikasi_oleh' => Auth::id(),
            'serah_terima_at' => now(),
            'status' => 'active',
        ]);

        return redirect()->route('admin.transactions.show', $rental)
            ->with('success', 'Serah-terima barang berhasil dicatat. Barang resmi diambil customer.');
    }

    /**
     * MODUL PENGEMBALIAN BARANG.
     * Admin cek kondisi tiap item, sistem otomatis hitung:
     * - Denda keterlambatan (jika dikembalikan setelah end_date)
     * - Klaim kerusakan per item (jika kondisi tidak baik)
     * Jaminan fisik (KTP/SIM/STNK) dikembalikan ke customer secara offline setelah semua lunas.
     */
    public function returnForm(Rental $rental)
    {
        abort_unless(in_array($rental->status, ['active', 'terlambat']), 403, 'Barang belum diambil / transaksi sudah selesai.');
        $rental->load('details.item');
        return view('admin.transactions.return', compact('rental'));
    }

    public function returnStore(Request $request, Rental $rental)
    {
        abort_unless(in_array($rental->status, ['active', 'terlambat']), 403, 'Barang belum diambil / transaksi sudah selesai.');

        $validated = $request->validate([
            'details' => 'required|array',
            'details.*.id' => 'required|exists:rental_details,id',
            'details.*.kondisi_saat_kembali' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'details.*.klaim_kerusakan' => 'nullable|integer|min:0',
            'catatan_kondisi_kembali' => 'nullable|string',
            'tanggal_kembali_aktual' => 'required|date',
        ]);

        DB::transaction(function () use ($validated, $rental) {
            $totalKlaimKerusakan = 0;

            foreach ($validated['details'] as $detailInput) {
                $detail = $rental->details()->findOrFail($detailInput['id']);
                $klaim = (int) ($detailInput['klaim_kerusakan'] ?? 0);

                $detail->update([
                    'kondisi_saat_kembali' => $detailInput['kondisi_saat_kembali'],
                    'klaim_kerusakan' => $klaim,
                ]);

                $totalKlaimKerusakan += $klaim;
            }

            $dendaKeterlambatan = $rental->hitungDendaKeterlambatan($validated['tanggal_kembali_aktual']);

            $rental->update([
                'late_fee' => $dendaKeterlambatan,
                'damage_fee' => $totalKlaimKerusakan,
                'catatan_kondisi_kembali' => $validated['catatan_kondisi_kembali'] ?? null,
                'dikembalikan_at' => $validated['tanggal_kembali_aktual'],
                'status' => 'selesai',
            ]);
        });

        return redirect()->route('admin.transactions.show', $rental)
            ->with('success', 'Pengembalian barang berhasil dicatat. Jaminan fisik dapat dikembalikan ke customer setelah biaya tambahan (jika ada) dilunasi.');
    }
}
