<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * KHUSUS UNTUK TESTING LOKAL — mensimulasikan callback pembayaran Midtrans
 * tanpa perlu akun Midtrans asli. Otomatis nonaktif kalau
 * MIDTRANS_SIMULATION_MODE=false (dicek ulang di setiap method sebagai pengaman
 * tambahan, supaya endpoint ini TIDAK BISA dipakai kalau tidak sengaja
 * ke-deploy ke production dengan mode simulasi masih aktif).
 */
class PaymentSimulationController extends Controller
{
    public function markPaid(Request $request, Rental $rental)
    {
        abort_unless(config('services.midtrans.simulation_mode'), 404);

        DB::transaction(function () use ($rental) {
            $rental = Rental::where('id', $rental->id)->lockForUpdate()->firstOrFail();

            if ($rental->payment_status === 'paid') {
                return;
            }

            $stokCukup = true;
            foreach ($rental->details as $detail) {
                $item = $detail->item()->lockForUpdate()->first();
                $stok = $item->availableStock($rental->start_date, $rental->end_date, excludeRentalId: $rental->id);

                if ($detail->qty > $stok) {
                    $stokCukup = false;
                    break;
                }
            }

            // Batas waktu bayar 10 menit sejak transaksi dibuat.
            $kadaluwarsa = $rental->created_at->lt(now()->subMinutes(10));

            if ($stokCukup && !$kadaluwarsa) {
                $rental->update([
                    'status' => 'booked',
                    'payment_status' => 'paid',
                    'payment_method' => 'simulasi',
                    'midtrans_order_id' => $rental->midtrans_order_id ?? ('SIM-' . $rental->id),
                    'midtrans_transaction_id' => 'SIMULASI-' . uniqid(),
                    'paid_at' => now(),
                    // Invoice baru dibuat DI SINI — hanya setelah pembayaran valid.
                    'invoice_number' => $rental->invoice_number ?? Rental::generateInvoiceNumber(),
                ]);
            } elseif ($kadaluwarsa) {
                $rental->update([
                    'status' => 'batal',
                    'payment_status' => 'expired',
                ]);
            } else {
                $rental->update([
                    'status' => 'batal',
                    'payment_status' => 'paid',
                    'payment_method' => 'simulasi',
                    'paid_at' => now(),
                    'catatan_kondisi_kembali' => 'STOK HABIS SAAT KONFIRMASI BAYAR (SIMULASI) — WAJIB REFUND MANUAL OLEH ADMIN.',
                ]);

                Log::warning('[SIMULASI] Stok habis saat konfirmasi bayar', ['rental_id' => $rental->id]);
            }
        });

        return redirect()->route('checkout.success', $rental->id);
    }

    public function markFailed(Request $request, Rental $rental)
    {
        abort_unless(config('services.midtrans.simulation_mode'), 404);

        $rental->update([
            'status' => 'batal',
            'payment_status' => 'failed',
        ]);

        return redirect()->route('checkout.success', $rental->id);
    }
}