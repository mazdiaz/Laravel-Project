<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::query()->with('seller')->latest();

        if ($request->filled('search')) {
            $s = $request->string('search');
            $q->where(function ($x) use ($s) {
                $x->where('name', 'like', "%{$s}%")
                  ->orWhere('slug', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }

        if ($request->filled('seller')) {
            $seller = $request->string('seller');
            $q->whereHas('seller', fn($x) =>
                $x->where('name', 'like', "%{$seller}%")
                  ->orWhere('email', 'like', "%{$seller}%")
            );
        }

        $products = $q->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', 'Status produk berhasil diubah.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
