<?php

namespace App\Http\Controllers\Admin;

use App\Models\SpendingItem;
use Illuminate\Http\Request;

class AdminSpendingItemController extends AdminController
{
    public function index()
    {
        $items = SpendingItem::orderBy('order_num')->get();
        return view('admin.spending-items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.spending-items.form', [
            'item' => new SpendingItem([
                'is_correct' => false,
                'is_active' => true,
                'order_num' => SpendingItem::count() + 1,
            ]),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:100'],
            'is_correct' => ['required', 'boolean'],
            'order_num' => ['required', 'integer', 'min:1'],
            'is_active' => ['required', 'boolean'],
        ]);

        SpendingItem::create($data);

        return redirect()->route('admin.spending-items.index')
            ->with('status', 'Barang belanja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = SpendingItem::findOrFail($id);
        return view('admin.spending-items.form', [
            'item' => $item,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = SpendingItem::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:100'],
            'is_correct' => ['required', 'boolean'],
            'order_num' => ['required', 'integer', 'min:1'],
            'is_active' => ['required', 'boolean'],
        ]);

        $item->update($data);

        return redirect()->route('admin.spending-items.index')
            ->with('status', 'Barang belanja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = SpendingItem::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.spending-items.index')
            ->with('status', 'Barang belanja berhasil dihapus.');
    }
}
