<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    /**
     * Endpoint notifikasi webhook Midtrans.
     * Daftarkan URL ini di Midtrans Dashboard > Settings > Configuration:
     * https://domainmu.com/webhook/midtrans
     */
    public function handle(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');

        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        // Validasi signature agar notifikasi benar-benar dari Midtrans, bukan orang iseng.
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if (!hash_equals($expectedSignature, (string) $signatureKey)) {
            Log::warning('Midtrans webhook: signature tidak valid', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $rental = Rental::where('midtrans_order_id', $orderId)->first();
        if (!$rental) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');
        $paymentType = $request->input('payment_type');

        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            if ($fraudStatus === null || $fraudStatus === 'accept') {
                $this->confirmPaymentWithStockRecheck($rental, $paymentType, $request->input('transaction_id'));
            }
        } elseif ($transactionStatus === 'pending') {
            $rental->update(['payment_status' => 'unpaid']);
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'failure'])) {
            $rental->update(['status' => 'batal', 'payment_status' => 'failed']);
        } elseif ($transactionStatus === 'expire') {
            $rental->update(['status' => 'batal', 'payment_status' => 'expired']);
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Konfirmasi pembayaran, TAPI cek ulang stok dulu sebelum mengunci jadi 'booked'.
     * Karena status 'pending' tidak mengunci stok, ada kemungkinan (kecil, tapi nyata)
     * barang sudah 'diambil' transaksi lain yang checkout & bayar lebih dulu.
     * Kalau itu terjadi, transaksi ini otomatis dibatalkan (bukan 'booked') dan
     * ditandai butuh refund manual oleh admin.
     */
    protected function confirmPaymentWithStockRecheck(Rental $rental, ?string $paymentType, ?string $transactionId): void
    {
        DB::transaction(function () use ($rental, $paymentType, $transactionId) {
            $rental = Rental::where('id', $rental->id)->lockForUpdate()->firstOrFail();

            // Kalau sudah diproses sebelumnya (webhook Midtrans bisa terkirim >1x), jangan diproses ulang.
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
                    'payment_method' => $paymentType,
                    'midtrans_transaction_id' => $transactionId,
                    'paid_at' => now(),
                    // Invoice baru dibuat DI SINI — hanya setelah pembayaran valid.
                    'invoice_number' => $rental->invoice_number ?? Rental::generateInvoiceNumber(),
                ]);
            } elseif ($kadaluwarsa) {
                $rental->update([
                    'status' => 'batal',
                    'payment_status' => 'expired',
                    'catatan_kondisi_kembali' => 'Pembayaran melewati batas waktu 10 menit — dibatalkan otomatis. Uang (jika terlanjur masuk) wajib direfund manual.',
                ]);

                Log::warning('Pembayaran diterima tapi sudah lewat batas waktu 10 menit', ['rental_id' => $rental->id]);
            } else {
                // Stok sudah habis duluan oleh transaksi lain yang lebih cepat bayar.
                // Uang customer TETAP MASUK ke Midtrans — wajib direfund manual oleh admin.
                $rental->update([
                    'status' => 'batal',
                    'payment_status' => 'paid',
                    'payment_method' => $paymentType,
                    'midtrans_transaction_id' => $transactionId,
                    'paid_at' => now(),
                    'catatan_kondisi_kembali' => 'STOK HABIS SAAT KONFIRMASI BAYAR — WAJIB REFUND MANUAL OLEH ADMIN.',
                ]);

                Log::warning('Stok habis saat konfirmasi pembayaran, wajib refund manual', [
                    'rental_id' => $rental->id,
                    'invoice' => $rental->invoice_number,
                ]);
            }
        });
    }
}