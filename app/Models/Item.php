<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'image',
        'total_stock', 'price_per_day', 'deposit_amount', 'condition', 'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rentalDetails()
    {
        return $this->hasMany(RentalDetail::class);
    }

    /**
     * Hitung sisa stok tersedia untuk rentang tanggal tertentu.
     * Stok dianggap "terpakai" oleh rental yang overlap tanggal
     * dan statusnya masih aktif dalam alur bisnis (belum batal/selesai gagal bayar).
     */
    public function availableStock(string $startDate, string $endDate, ?int $excludeRentalId = null): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $usedQty = RentalDetail::query()
            ->where('item_id', $this->id)
            ->whereHas('rental', function ($q) use ($start, $end, $excludeRentalId) {
                $q->whereIn('status', ['pending', 'booked', 'active', 'terlambat'])
                    // overlap check: rental lain bentrok jika start <= end_kita DAN end >= start_kita
                    ->where('start_date', '<=', $end->toDateString())
                    ->where('end_date', '>=', $start->toDateString());

                if ($excludeRentalId) {
                    $q->where('id', '!=', $excludeRentalId);
                }
            })
            ->sum('qty');

        return max(0, $this->total_stock - $usedQty);
    }
}
