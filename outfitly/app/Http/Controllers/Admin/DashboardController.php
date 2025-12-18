<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        $usersCount     = User::count();
        $productsCount  = Product::count();
        $activeProducts = Product::where('status', 'active')->count();

        $ordersThisMonth = Order::whereBetween('created_at', [$start, $end])->count();

        $revenueThisMonth = Order::whereBetween('created_at', [$start, $end])
            ->where('status', 'completed') 
            ->sum('total_amount');

        $latestOrders = Order::with('buyer') 
            ->latest()
            ->limit(5)
            ->get();

        return view('admin-dashboard', compact(
            'usersCount',
            'productsCount',
            'activeProducts',
            'ordersThisMonth',
            'revenueThisMonth',
            'latestOrders'
        ));
    }
}