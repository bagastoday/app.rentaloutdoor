<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id', 'item_id', 'qty', 'price_per_day', 'subtotal',
        'kondisi_saat_kembali', 'klaim_kerusakan',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
