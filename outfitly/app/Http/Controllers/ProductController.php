<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderItem;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
            ->latest()
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->status === 'active', 404);

        $product->load(['reviews.user']);

        $canReview = false;

        if (auth()->check() && auth()->user()->role === 'customer') {
            $canReview = OrderItem::where('product_id', $product->id)
                ->whereHas('order', function ($q) {
                    $q->where('buyer_id', auth()->id()) // ✅ change here
                    ->whereIn('status', ['paid', 'shipped', 'completed']);
                })
                ->exists();
        }

        return view('products.show', compact('product', 'canReview'));
    }
}
