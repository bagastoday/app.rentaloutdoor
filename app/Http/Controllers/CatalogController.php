<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Halaman katalog publik: filter kategori, pencarian, dan cek ketersediaan
     * stok berdasarkan tanggal (opsional, via query string start_date/end_date).
     */
    public function index(Request $request)
    {
        $query = Item::query()->with('category')->where('is_active', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $query->paginate(12)->withQueryString();

        // Jika user sudah pilih rentang tanggal di halaman katalog,
        // hitung sisa stok real-time untuk masing-masing item.
        if ($request->filled('start_date') && $request->filled('end_date')) {
            foreach ($items as $item) {
                $item->stok_tersedia = $item->availableStock($request->start_date, $request->end_date);
            }
        }

        $categories = Category::orderBy('name')->get();

        return view('catalog.index', compact('items', 'categories'));
    }

    public function show(Request $request, Item $item)
    {
        $stokTersedia = null;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $stokTersedia = $item->availableStock($request->start_date, $request->end_date);
        }

        return view('catalog.show', compact('item', 'stokTersedia'));
    }

    /**
     * Endpoint AJAX ringan: cek stok on-the-fly saat customer ganti tanggal
     * di halaman detail produk, tanpa reload halaman.
     */
    public function checkStock(Request $request, Item $item)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $stok = $item->availableStock($request->start_date, $request->end_date);

        return response()->json([
            'available' => $stok > 0,
            'stock' => $stok,
        ]);
    }
}
