<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil produk dengan data seller untuk mencegah N+1 Query
        $q = Product::query()->with('seller')->latest();

        // Filter Search (Nama Produk / Slug)
        if ($request->filled('search')) {
            $s = $request->string('search');
            $q->where(function ($x) use ($s) {
                $x->where('name', 'like', "%{$s}%")
                  ->orWhere('slug', 'like', "%{$s}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }

        // Pagination 12 item per halaman
        $products = $q->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', 'Status produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }
}