<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->latest()->paginate(15);
        return view('admin.inventory.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.inventory.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'total_stock' => 'required|integer|min:0',
            'price_per_day' => 'required|integer|min:0',
            'deposit_amount' => 'nullable|integer|min:0',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        Item::create($data);

        return redirect()->route('admin.inventory.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.inventory.form', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_stock' => 'required|integer|min:0',
            'price_per_day' => 'required|integer|min:0',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'is_active' => 'boolean',
        ]);

        $item->update($data);

        return redirect()->route('admin.inventory.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return back()->with('success', 'Barang dihapus.');
    }
}
