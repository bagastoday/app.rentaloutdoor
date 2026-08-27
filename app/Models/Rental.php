<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice_number', 'customer_name', 'customer_phone', 'customer_email',
        'start_date', 'end_date', 'total_price', 'late_fee', 'damage_fee', 'status',
        'payment_method', 'midtrans_order_id', 'midtrans_transaction_id',
        'payment_status', 'paid_at',
        'is_jaminan_diterima', 'jenis_jaminan', 'jaminan_nomor_catatan',
        'diverifikasi_oleh', 'serah_terima_at',
        'dikembalikan_at', 'catatan_kondisi_kembali',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'paid_at' => 'datetime',
        'serah_terima_at' => 'datetime',
        'dikembalikan_at' => 'datetime',
        'is_jaminan_diterima' => 'boolean',
    ];

    public function details()
    {
        return $this->hasMany(RentalDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Generate nomor invoice — DIPANGGIL HANYA saat pembayaran dikonfirmasi 'paid',
     * bukan saat transaksi pertama kali dibuat. Jadi invoice_number tetap null
     * selama status masih 'pending' (belum bayar).
     */
    public static function generateInvoiceNumber(): string
    {
        return 'INV-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    /**
     * Berapa hari sewa (minimal 1 hari).
     */
    public function totalDays(): int
    {
        return max(1, $this->start_date->diffInDays($this->end_date) + 1);
    }

    /**
     * Hitung denda keterlambatan otomatis.
     * Aturan sederhana: 10% dari total harga sewa / hari keterlambatan.
     */
    public function hitungDendaKeterlambatan(\DateTimeInterface $tanggalKembaliAktual): int
    {
        $end = $this->end_date->copy()->startOfDay();
        $actual = \Carbon\Carbon::parse($tanggalKembaliAktual)->startOfDay();

        if ($actual->lte($end)) {
            return 0;
        }

        $telatHari = $end->diffInDays($actual);
        $dendaPerHari = (int) round($this->total_price * 0.10 / $this->totalDays());

        return $telatHari * $dendaPerHari;
    }
}