<nav class="navbar navbar-expand-lg bg-white border-bottom">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('landing') }}">Outfitly</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto gap-2">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
             href="{{ route('products.index') }}">Produk</a>
        </li>

        @auth
          @if(auth()->user()->role === 'seller')
            <li class="nav-item"><a class="nav-link" href="{{ route('seller.products.index') }}">Produk Saya</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('seller.orders.index') }}">Pesanan</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('seller.reports.monthly') }}">Laporan</a></li>
          @elseif(auth()->user()->role === 'admin')
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
          @elseif(auth()->user()->role === 'customer')
            <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">Keranjang</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('customer.orders.index') }}">Pesanan</a></li>
          @endif
        @endauth
      </ul>

      <div class="d-flex align-items-center gap-2">
        @auth
          <span class="small text-muted">{{ auth()->user()->name }}</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-danger btn-sm">Logout</button>
          </form>
        @else
          <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Login</a>
          <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Register</a>
        @endauth
      </div>
    </div>
  </div>
</nav>
