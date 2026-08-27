<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();

            // Data penyewa (tidak perlu akun login, cukup data kontak)
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();

            $table->date('start_date'); // tanggal ambil barang
            $table->date('end_date');   // tanggal wajib kembali

            $table->integer('total_price')->default(0);
            $table->integer('late_fee')->default(0);
            $table->integer('damage_fee')->default(0);

            // Status alur bisnis: Pending -> Booked -> Active -> Selesai / Terlambat
            $table->enum('status', [
                'pending',   // baru checkout, menunggu pembayaran
                'booked',    // pembayaran lunas, menunggu tanggal ambil
                'active',    // barang sudah diambil customer
                'terlambat', // sudah lewat end_date tapi belum dikembalikan
                'selesai',   // barang sudah kembali & transaksi ditutup
                'batal',     // dibatalkan / pembayaran gagal
            ])->default('pending');

            // === Midtrans ===
            $table->string('payment_method')->nullable(); // qris / bank_transfer / dll
            $table->string('midtrans_order_id')->nullable()->unique();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('payment_status')->default('unpaid'); // unpaid / paid / expired / failed
            $table->timestamp('paid_at')->nullable();

            // === Jaminan fisik (bukan file upload!) ===
            $table->boolean('is_jaminan_diterima')->default(false);
            $table->enum('jenis_jaminan', ['KTP', 'SIM', 'STNK'])->nullable();
            $table->string('jaminan_nomor_catatan')->nullable(); // catatan manual admin, misal nomor identitas (opsional)
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('serah_terima_at')->nullable();

            // === Pengembalian ===
            $table->timestamp('dikembalikan_at')->nullable();
            $table->text('catatan_kondisi_kembali')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
