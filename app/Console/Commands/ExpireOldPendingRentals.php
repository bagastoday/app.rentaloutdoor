<?php

namespace App\Console\Commands;

use App\Models\Rental;
use Illuminate\Console\Command;

class ExpireOldPendingRentals extends Command
{
    protected $signature = 'rentals:expire-pending';

    protected $description = 'Batalkan otomatis transaksi pending yang lebih dari 10 menit belum dibayar';

    public function handle(): void
    {
        $expired = Rental::where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(10))
            ->update(['status' => 'batal', 'payment_status' => 'expired']);

        $this->info("{$expired} transaksi pending kedaluwarsa dibatalkan.");
    }
}