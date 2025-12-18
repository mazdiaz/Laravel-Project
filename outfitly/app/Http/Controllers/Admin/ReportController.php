<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        // month format: YYYY-MM
        $month = $request->input('month', now()->format('Y-m'));

        try {
            $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        } catch (\Throwable $e) {
            $start = now()->startOfMonth();
            $month = $start->format('Y-m');
        }

        $end = (clone $start)->endOfMonth();

        $base = Order::query()->whereBetween('created_at', [$start, $end]);

        // 1. Summary Cards
        $totalOrders  = (clone $base)->count();
        $grossRevenue = (clone $base)->sum('total_amount');
        $netRevenue   = (clone $base)->where('status', '!=', 'cancelled')->sum('total_amount');

        // 2. Breakdown Status
        $byStatus = (clone $base)
            ->select('status', DB::raw('COUNT(*) as orders'), DB::raw('SUM(total_amount) as revenue'))
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        // 3. Top Sellers
        $topSellers = (clone $base)
            ->select('seller_id', DB::raw('COUNT(*) as orders'), DB::raw('SUM(total_amount) as revenue'))
            ->with('seller:id,name,email') 
            ->groupBy('seller_id')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        // 4. Daily Stats
        $daily = (clone $base)
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as orders'), DB::raw('SUM(total_amount) as revenue'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('day', 'desc') 
            ->get();

        return view('admin.reports.monthly', compact(
            'month', 'start', 'end',
            'totalOrders', 'grossRevenue', 'netRevenue',
            'byStatus', 'topSellers', 'daily'
        ));
    }
}