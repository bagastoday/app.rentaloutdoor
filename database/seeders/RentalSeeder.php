<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        $tenda = Category::create(['name' => 'Tenda', 'slug' => 'tenda', 'description' => 'Tenda camping berbagai kapasitas']);
        $tas = Category::create(['name' => 'Tas Carrier', 'slug' => 'tas-carrier']);
        $sleeping = Category::create(['name' => 'Sleeping Bag', 'slug' => 'sleeping-bag']);
        $kompor = Category::create(['name' => 'Kompor & Alat Masak', 'slug' => 'kompor-alat-masak']);

        $items = [
            ['category_id' => $tenda->id, 'name' => 'Tenda Dome 4 Orang', 'total_stock' => 5, 'price_per_day' => 35000],
            ['category_id' => $tenda->id, 'name' => 'Tenda Dome 6 Orang', 'total_stock' => 3, 'price_per_day' => 50000],
            ['category_id' => $tas->id, 'name' => 'Carrier 60L Eiger', 'total_stock' => 8, 'price_per_day' => 20000],
            ['category_id' => $sleeping->id, 'name' => 'Sleeping Bag Standar', 'total_stock' => 10, 'price_per_day' => 10000],
            ['category_id' => $kompor->id, 'name' => 'Kompor Portable + Gas', 'total_stock' => 6, 'price_per_day' => 15000],
        ];

        foreach ($items as $data) {
            Item::create([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'slug' => Str::slug($data['name']) . '-' . Str::random(4),
                'description' => 'Peralatan siap pakai, sudah dicek kondisi sebelum disewakan.',
                'total_stock' => $data['total_stock'],
                'price_per_day' => $data['price_per_day'],
                'condition' => 'baik',
                'is_active' => true,
            ]);
        }
    }
}
