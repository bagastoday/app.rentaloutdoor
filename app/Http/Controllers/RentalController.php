<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Rental;
use App\Models\RentalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RentalController extends Controller
{
    /**
     * Tampilkan form checkout untuk 1 item (bisa dikembangkan ke keranjang multi-item).
     */
    public function checkoutForm(Request $request, Item $item)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'qty' => 'required|integer|min:1',
        ]);

        $stok = $item->availableStock($request->start_date, $request->end_date);

        if ($request->qty > $stok) {
            return back()->withErrors([
                'qty' => "Stok tidak mencukupi. Sisa stok untuk tanggal tersebut: {$stok}.",
            ]);
        }

        return view('checkout.index', [
            'item' => $item,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'qty' => $request->qty,
        ]);
    }

    /**
     * Buat transaksi rental (status pending) lalu generate Snap Token Midtrans.
     * Stok TIDAK dikunci permanen di sini — validasi ulang dilakukan
     * secara atomik memakai transaction + lockForUpdate agar aman dari race condition
     * (dua customer checkout barang sama di waktu bersamaan).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:30',
            'customer_email' => 'nullable|email',
        ]);

        $rental = DB::transaction(function () use ($validated) {
            $item = Item::where('id', $validated['item_id'])->lockForUpdate()->firstOrFail();

            $stok = $item->availableStock($validated['start_date'], $validated['end_date']);
            if ($validated['qty'] > $stok) {
                abort(422, "Stok tidak mencukupi. Sisa stok saat ini: {$stok}.");
            }

            $days = \Carbon\Carbon::parse($validated['start_date'])
                ->diffInDays(\Carbon\Carbon::parse($validated['end_date'])) + 1;
            $subtotal = $item->price_per_day * $validated['qty'] * $days;

            $rental = Rental::create([
                // Kalau customer sedang login, transaksi otomatis nyambung ke akunnya.
                // Kalau tidak login (guest checkout), customer_id tetap null, tidak masalah.
                'customer_id' => auth('customer')->id(),
                // invoice_number SENGAJA tidak diisi di sini — baru dibuat saat pembayaran
                // dikonfirmasi 'paid' (lihat MidtransWebhookController / PaymentSimulationController).
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'] ?? null,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'total_price' => $subtotal,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            RentalDetail::create([
                'rental_id' => $rental->id,
                'item_id' => $item->id,
                'qty' => $validated['qty'],
                'price_per_day' => $item->price_per_day,
                'subtotal' => $subtotal,
            ]);

            return $rental;
        });

        // Mode simulasi: biar bisa test alur checkout tanpa perlu akun Midtrans asli dulu.
        // Aktif otomatis kalau MIDTRANS_SIMULATION_MODE=true di .env
        if (config('services.midtrans.simulation_mode')) {
            return view('checkout.pay-simulation', compact('rental'));
        }

        $snapToken = $this->createMidtransSnapToken($rental);

        return view('checkout.pay', compact('rental', 'snapToken'));
    }

    /**
     * Generate Snap Token via Midtrans Snap API.
     */
    protected function createMidtransSnapToken(Rental $rental): string
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = 'RENTAL-' . $rental->id . '-' . time();
        $rental->update(['midtrans_order_id' => $orderId]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $rental->total_price,
            ],
            // Snap Token kadaluwarsa 10 menit — selaras dengan batas waktu pending di sistem kita.
            'expiry' => [
                'unit' => 'minutes',
                'duration' => 10,
            ],
            'customer_details' => [
                'first_name' => $rental->customer_name,
                'phone' => $rental->customer_phone,
                'email' => $rental->customer_email,
            ],
            'enabled_payments' => ['qris', 'bank_transfer', 'gopay', 'shopeepay'],
            'item_details' => $rental->details->map(function ($d) {
                return [
                    'id' => 'ITEM-' . $d->item_id,
                    'price' => $d->price_per_day,
                    'quantity' => $d->qty,
                    'name' => Str::limit($d->item->name, 45, ''),
                ];
            })->toArray(),
        ];

        return \Midtrans\Snap::getSnapToken($params);
    }

    public function show(Rental $rental)
    {
        return view('checkout.status', compact('rental'));
    }

    /**
     * Halaman hasil setelah proses bayar (baik dari Snap Midtrans asli
     * maupun mode simulasi). Kalau sudah 'paid', invoice sudah pasti ada
     * (dibuat otomatis saat konfirmasi bayar) dan halaman ini auto-redirect
     * ke beranda setelah beberapa detik. Kalau belum 'paid' (masih diproses
     * webhook), halaman ini auto-refresh sampai statusnya update.
     */
    public function success(Rental $rental)
    {
        $rental->refresh();
        return view('checkout.success', compact('rental'));
    }
}