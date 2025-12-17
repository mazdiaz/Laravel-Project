<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Order::query()->with(['buyer', 'seller']);

        // Filters
        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }

        if ($request->filled('order_id')) {
            $q->where('id', (int) $request->input('order_id'));
        }

        if ($request->filled('buyer')) {
            $buyer = $request->string('buyer');
            $q->whereHas('buyer', fn($x) =>
                $x->where('name', 'like', "%{$buyer}%")
                  ->orWhere('email', 'like', "%{$buyer}%")
            );
        }

        if ($request->filled('seller')) {
            $seller = $request->string('seller');
            $q->whereHas('seller', fn($x) =>
                $x->where('name', 'like', "%{$seller}%")
                  ->orWhere('email', 'like', "%{$seller}%")
            );
        }

        if ($request->filled('from')) {
            $q->whereDate('created_at', '>=', $request->date('from'));
        }

        if ($request->filled('to')) {
            $q->whereDate('created_at', '<=', $request->date('to'));
        }

        $orders = $q->latest()->paginate(12)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['buyer', 'seller', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,paid,shipped,completed,cancelled'],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Status transaksi berhasil diupdate.');
    }
}
