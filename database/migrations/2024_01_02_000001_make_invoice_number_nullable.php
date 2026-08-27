<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Invoice number sekarang HANYA dibuat setelah pembayaran dikonfirmasi (status 'paid'),
     * jadi kolomnya perlu bisa kosong (nullable) selama transaksi masih 'pending'.
     *
     * Dipecah jadi 3 langkah terpisah supaya tidak bentrok dengan unique index
     * yang sudah ada dari migration awal (rentals_invoice_number_unique).
     */
    public function up(): void
    {
        // 1. Hapus dulu unique index yang lama
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropUnique('rentals_invoice_number_unique');
        });

        // 2. Baru ubah kolomnya jadi nullable
        Schema::table('rentals', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->change();
        });

        // 3. Pasang lagi unique index-nya (MySQL & Postgres tetap izinkan banyak NULL di kolom unique)
        Schema::table('rentals', function (Blueprint $table) {
            $table->unique('invoice_number');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropUnique('rentals_invoice_number_unique');
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->string('invoice_number')->nullable(false)->change();
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->unique('invoice_number');
        });
    }
};