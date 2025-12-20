<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // only customers
        abort_unless(auth()->user()->role === 'customer', 403);

        // must have bought this product (any completed/paid/shipped order)
        $hasBought = OrderItem::where('product_id', $product->id)
            ->whereHas('order', function ($q) {
                $q->where('buyer_id', auth()->id())
                  ->whereIn('status', ['paid', 'shipped', 'completed']);
            })
            ->exists();

        abort_unless($hasBought, 403);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        Review::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => auth()->id()],
            ['rating' => $data['rating'], 'comment' => $data['comment']]
        );

        return back()->with('success', 'Ulasan berhasil disimpan.');
    }
}
