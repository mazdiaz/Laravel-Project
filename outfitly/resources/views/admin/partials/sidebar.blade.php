<div class="card-like p-0 overflow-hidden d-print-none">
    <div class="p-3 border-bottom bg-light">
        <h6 class="m-0 fw-bold text-secondary d-print-none">Menu Admin</h6>
    </div>
    <div class="list-group list-group-flush d-print-none">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }} py-3">
            <i class="fa-solid fa-chart-line me-2"></i> Dashboard
        </a>

        {{-- Manajemen User --}}
        <a href="{{ route('admin.users.index') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.index') ? 'active-menu' : '' }} py-3">
            <i class="fa-solid fa-users me-2"></i> Manajemen User
        </a>

        {{-- Manajemen Produk --}}
        <a href="{{ route('admin.products.index') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('admin.products.index') ? 'active-menu' : '' }} py-3">
            <i class="fa-solid fa-box me-2"></i> Manajemen Produk
        </a>

        {{-- Manajemen Transaksi --}}
        <a href="{{ route('admin.orders.index') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('admin.orders.index') ? 'active-menu' : '' }} py-3">
            <i class="fa-solid fa-file-invoice-dollar me-2"></i> Manajemen Transaksi
        </a>

        {{-- Laporan Bulanan --}}
        <a href="{{ route('admin.reports.monthly') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('admin.reports.monthly') ? 'active-menu' : '' }} py-3">
            <i class="fa-solid fa-chart-column me-2"></i> Laporan Bulanan
        </a>
    </div>
</div>