<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $buyerId = auth()->id();

        $ordersCount = Order::where('buyer_id', $buyerId)->count();
        $latestOrders = Order::where('buyer_id', $buyerId)->latest()->limit(5)->get();

        $newProducts = Product::where('status', 'active')->latest()->limit(6)->get();

        return view('customer-dashboard', compact('ordersCount','latestOrders','newProducts'));
    }
}
