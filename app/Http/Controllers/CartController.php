<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'qty' => ['nullable','integer','min:1','max:99']
        ]);

        $qty = (int)($request->input('qty', 1));

        if ($product->status !== 'active') abort(404);

        $cart = session('cart', []);

        $id = (string)$product->id;

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = min(99, $cart[$id]['qty'] + $qty);
        } else {
            $cart[$id] = [
                'product_id' => $product->id,
                'seller_id'  => $product->seller_id,
                'name'       => $product->name,
                'slug'       => $product->slug,
                'price'      => (int)$product->price,
                'qty'        => $qty,
                'image_path' => $product->image_path,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Produk masuk keranjang.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'qty' => ['required','array'],
            'qty.*' => ['integer','min:1','max:99'],
        ]);

        $cart = session('cart', []);
        foreach ($data['qty'] as $productId => $qty) {
            if (isset($cart[$productId])) {
                $cart[$productId]['qty'] = (int)$qty;
            }
        }
        session(['cart' => $cart]);

        return back()->with('success', 'Keranjang diupdate.');
    }

    public function remove(string $productId)
    {
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item dihapus.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
