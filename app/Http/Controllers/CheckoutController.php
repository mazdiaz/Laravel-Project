<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = session('cart', []);

        // FIX: your cart uses 'qty', not 'quantity'
        $total = collect($cart)->sum(fn($i) => ($i['price'] ?? 0) * ($i['qty'] ?? 1));

        $u = $request->user();
        $p = $u?->profile; // if you have profile relation

        $defaults = [
            'recipient_name' => $u?->name ?? '',
            'phone' => $u?->phone
                ?? $u?->no_hp
                ?? $u?->contact_number
                ?? $p?->phone
                ?? $p?->no_hp
                ?? $p?->contact_number
                ?? '',
            'address' => $u?->address
                ?? $u?->alamat
                ?? $p?->address
                ?? $p?->alamat
                ?? '',
        ];

        return view('checkout.index', compact('cart', 'total', 'defaults'));
    }

    public function process(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index');

        $data = $request->validate([
            'recipient_name' => ['required','string','max:100'],
            'phone'          => ['required','string','max:30'],
            'address'        => ['required','string','max:500'],
        ]);

        $buyerId = auth()->id();

        DB::transaction(function () use ($cart, $buyerId, $data) {

            // group by seller, so each seller gets their own order
            $bySeller = collect($cart)->groupBy('seller_id');

            foreach ($bySeller as $sellerId => $items) {

                // lock products & validate stock
                $lockedProducts = Product::whereIn('id', $items->pluck('product_id'))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $orderTotal = 0;

                foreach ($items as $it) {
                    $p = $lockedProducts[$it['product_id']] ?? null;
                    if (! $p || $p->status !== 'active') {
                        throw new \RuntimeException("Produk tidak tersedia.");
                    }
                    if ($p->stock < $it['qty']) {
                        throw new \RuntimeException("Stok tidak cukup untuk {$p->name}.");
                    }
                    $orderTotal += $it['price'] * $it['qty'];
                }

                $order = Order::create([
                    'buyer_id' => $buyerId,
                    'seller_id' => (int)$sellerId,
                    'status' => 'pending',
                    'total_amount' => $orderTotal,
                    'shipping_name'    => $data['recipient_name'],
                    'shipping_phone'   => $data['phone'],
                    'shipping_address' => $data['address'],
                ]);

                foreach ($items as $it) {
                    $p = $lockedProducts[$it['product_id']];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $p->id,
                        'price' => (int)$it['price'],
                        'quantity' => (int)$it['qty'],
                        'subtotal' => (int)$it['price'] * (int)$it['qty'],
                    ]);

                    // reduce stock
                    $p->decrement('stock', (int)$it['qty']);
                }
            }
        });

        session()->forget('cart');

        return redirect()->route('customer.orders.index')
            ->with('success', 'Checkout berhasil! Pesanan dibuat.');
    }
}

