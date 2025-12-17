<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        $sellerId = $request->user()->id;

        $month = $request->get('month', now()->format('Y-m'));
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        // Base query: orders that contain items whose product belongs to this seller
        $base = Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->whereHas('items.product', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            });

        $totalOrders = (clone $base)->count();

        // Gross: sum of ALL order totals (note: if orders can include multiple sellers, this overcounts)
        // Better: compute seller-only revenue from order_items (below).
        $grossRevenue = (clone $base)->sum('total_amount');

        // Seller-only revenue based on order items belonging to this seller:
        $netRevenue = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('products.seller_id', $sellerId)
            ->whereBetween('orders.created_at', [$start, $end])
            ->where('orders.status', '!=', 'cancelled')
            ->sum(DB::raw('order_items.price * order_items.quantity'));

        // Breakdown by order status (seller-only revenue)
        $byStatus = DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('orders.status as status, COUNT(DISTINCT orders.id) as orders, SUM(order_items.price * order_items.quantity) as revenue')
            ->where('products.seller_id', $sellerId)
            ->whereBetween('orders.created_at', [$start, $end])
            ->groupBy('orders.status')
            ->orderBy('orders', 'desc')
            ->get();

        // Daily revenue (seller-only)
        $daily = DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('DATE(orders.created_at) as day, COUNT(DISTINCT orders.id) as orders, SUM(order_items.price * order_items.quantity) as revenue')
            ->where('products.seller_id', $sellerId)
            ->whereBetween('orders.created_at', [$start, $end])
            ->where('orders.status', '!=', 'cancelled')
            ->groupBy(DB::raw('DATE(orders.created_at)'))
            ->orderBy('day')
            ->get();

        $topProducts = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('products.seller_id', $sellerId)
            ->whereBetween('orders.created_at', [$start, $end])
            ->where('orders.status', '!=', 'cancelled')
            ->selectRaw('order_items.product_id, products.name as product_name, SUM(order_items.quantity) as qty, SUM(order_items.price * order_items.quantity) as revenue')
            ->groupBy('order_items.product_id', 'products.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        $productNames = \App\Models\Product::where('seller_id', $sellerId)
            ->pluck('name', 'id');

        $topProducts->transform(function ($row) use ($productNames) {
            $row->product_name = $productNames[$row->product_id] ?? ('Product #'.$row->product_id);
            return $row;
        });

        return view('seller.reports.monthly', compact(
            'month', 'start', 'end',
            'totalOrders', 'grossRevenue', 'netRevenue',
            'byStatus', 'daily', 'topProducts'
        ));
    }
}
