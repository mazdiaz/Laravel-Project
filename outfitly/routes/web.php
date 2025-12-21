<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Seller\ReportController as SellerReportController;
use App\Models\Order;
use Carbon\Carbon;
use App\Http\Controllers\Seller\StoreSettingsController;
use Illuminate\Http\Request;



Route::view('/', 'landing')->name('landing');

// --- Debug helpers (safe to remove later) ---
Route::middleware('web')->group(function () {
    Route::get('/_debug/session', function (Request $request) {
        $request->session()->put('debug_key', 'debug_value');
        return response()->json([
            'session_id' => $request->session()->getId(),
            'has_debug_key' => $request->session()->has('debug_key'),
            'cookie_name' => config('session.cookie'),
            'cookie_value' => $request->cookie(config('session.cookie')),
            'driver' => config('session.driver'),
            'domain' => config('session.domain'),
            'secure' => config('session.secure'),
            'same_site' => config('session.same_site'),
        ]);
    })->name('debug.session');

    Route::get('/_debug/csrf', function () {
        return response()->json([
            'csrf_token' => csrf_token(),
        ]);
    })->name('debug.csrf');
});



Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});



Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');



Route::view('/maintenance', 'maintenance')->name('maintenance');


Route::middleware(['auth','role:customer'])->get('/customer-dashboard', [CustomerDashboardController::class,'index'])->name('customer.dashboard');
Route::middleware(['auth', 'role:seller'])
    ->get('/seller-dashboard', [SellerDashboardController::class, 'index'])
    ->name('seller.dashboard');
Route::middleware(['auth','role:admin'])->get('/admin-dashboard', [AdminDashboardController::class,'index'])->name('admin.dashboard');


Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');


Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::resource('products', SellerProductController::class)->except(['show']);
    });


Route::middleware(['auth','role:customer'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Route::get('/customer/orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
});


Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.status');
    });


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    });


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/reports/monthly', [AdminReportController::class, 'monthly'])->name('reports.monthly');
    });


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        // ----------------------------------------

        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');

        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        // --------------------------------
    });


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});


Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
    });


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::post('/products/{product}/toggle', [AdminProductController::class, 'toggleStatus'])->name('products.toggle');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    });


Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::get('/reports/monthly', [SellerReportController::class, 'monthly'])->name('reports.monthly');
    });


Route::get('/reports/monthly', [\App\Http\Controllers\Seller\ReportController::class, 'monthly'])
    ->name('reports.monthly');


Route::middleware(['auth', 'role:customer'])->get('/customer-dashboard', function () {
    $userId = auth()->id();

    $totalOrders = Order::where('buyer_id', $userId)->count();

    $inProgress = Order::where('buyer_id', $userId)
        ->whereIn('status', ['pending','paid','processing','shipped'])
        ->count();

    $start = now()->startOfMonth();
    $end = now()->endOfMonth();

    $spentThisMonth = Order::where('buyer_id', $userId)
        ->whereBetween('created_at', [$start, $end])
        ->where('status', '!=', 'cancelled')
        ->sum('total_amount');

    $recentOrders = Order::where('buyer_id', $userId)
        ->latest()
        ->take(5)
        ->get();

    return view('customer-dashboard', compact(
        'totalOrders', 'inProgress', 'spentThisMonth', 'recentOrders'
    ));
})->name('customer.dashboard');


Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        Route::get('/settings', [StoreSettingsController::class, 'edit'])->name('settings');
        Route::put('/settings', [StoreSettingsController::class, 'update'])->name('settings.update');

    });