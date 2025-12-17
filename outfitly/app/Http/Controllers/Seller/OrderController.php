<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = $request->user()->id;

        $q      = trim((string) $request->get('q', ''));       // search by id/buyer
        $status = $request->get('status');                     // pending/paid/processing/shipped/completed/cancelled
        $sort   = $request->get('sort', 'latest');             // latest/oldest/total_desc/total_asc

        $query = Order::query()
            ->with(['buyer', 'items.product'])
            ->whereHas('items.product', function ($p) use ($sellerId) {
                $p->where('seller_id', $sellerId);
            });

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                // allow searching by numeric order id
                if (ctype_digit($q)) {
                    $qq->orWhere('id', (int) $q);
                }

                // buyer search
                $qq->orWhereHas('buyer', function ($b) use ($q) {
                    $b->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
                });
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        match ($sort) {
            'oldest'     => $query->orderBy('created_at', 'asc'),
            'total_asc'  => $query->orderBy('total_amount', 'asc'),
            'total_desc' => $query->orderBy('total_amount', 'desc'),
            default      => $query->orderBy('created_at', 'desc'),
        };

        $orders = $query->paginate(10)->withQueryString();

        return view('seller.orders.index', compact('orders', 'q', 'status', 'sort'));
    }

    public function show(Order $order)
    {
        abort_unless($order->seller_id === auth()->id(), 404);

        $order->load(['buyer', 'items.product']);

        return view('seller.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        abort_unless($order->seller_id === auth()->id(), 404);

        $data = $request->validate([
            'status' => ['required', 'in:pending,paid,shipped,completed,cancelled'],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Status pesanan berhasil diupdate.');
    }
}
