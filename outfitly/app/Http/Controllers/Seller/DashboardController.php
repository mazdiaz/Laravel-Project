<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = auth()->id();

        $month = $request->input('month', now()->format('Y-m'));
        try {
            $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        } catch (\Throwable $e) {
            $start = now()->startOfMonth();
            $month = $start->format('Y-m');
        }
        $end = (clone $start)->endOfMonth();

        $salesMonth = Order::where('seller_id', $sellerId)
            ->whereBetween('created_at', [$start, $end])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $ordersMonth = Order::where('seller_id', $sellerId)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $activeProducts = Product::where('seller_id', $sellerId)
            ->where('status', 'active')
            ->count();

        $lowStockThreshold = 5;
        $lowStockCount = Product::where('seller_id', $sellerId)
            ->where('stock', '<=', $lowStockThreshold)
            ->count();

        $lowStockProducts = Product::where('seller_id', $sellerId)
            ->where('stock', '<=', $lowStockThreshold)
            ->orderBy('stock')
            ->limit(6)
            ->get(['id', 'name', 'stock']);

        $latestOrders = Order::where('seller_id', $sellerId)
            ->latest()
            ->limit(8)
            ->get();

        //  Daily sales: sum(total_amount) grouped by date
        $dailyMap = Order::query()
            ->selectRaw('DATE(created_at) as d, SUM(total_amount) as total')
            ->where('seller_id', $sellerId)
            ->whereBetween('created_at', [$start, $end])
            ->where('status', '!=', 'cancelled')
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('total', 'd'); // ['2025-12-01' => 12345, ...]

        // Fill missing days with 0
        $chartLabels = [];
        $chartValues = [];

        foreach (CarbonPeriod::create($start, $end) as $date) {
            $key = $date->toDateString();
            $chartLabels[] = $date->format('d'); // "01", "02", ...
            $chartValues[] = (float) ($dailyMap[$key] ?? 0);
        }

        return view('seller-dashboard', compact(
            'month', 'start', 'end',
            'salesMonth', 'ordersMonth', 'activeProducts',
            'lowStockCount', 'lowStockProducts', 'latestOrders',
            'chartLabels', 'chartValues'
        ));
    }
}
