<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('landing') }}">
      Outfit<span class="text-danger">ly</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('products.*') ? 'active fw-semibold' : '' }}"
             href="{{ route('products.index') }}">Produk</a>
        </li>

        @auth
          @php $role = auth()->user()->role; @endphp

          @if ($role === 'customer')
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active fw-semibold' : '' }}"
                 href="{{ route('customer.orders.index') }}">Pesanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('cart.*') ? 'active fw-semibold' : '' }}"
                 href="{{ route('cart.index') }}">Keranjang</a>
            </li>
          @endif

          @if ($role === 'seller')
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('seller.products.*') ? 'active fw-semibold' : '' }}"
                 href="{{ route('seller.products.index') }}">Produk Saya</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('seller.orders.*') ? 'active fw-semibold' : '' }}"
                 href="{{ route('seller.orders.index') }}">Pesanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('seller.reports.*') ? 'active fw-semibold' : '' }}"
                 href="{{ route('seller.reports.monthly') }}">Laporan</a>
            </li>
          @endif

          @if ($role === 'admin')
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active fw-semibold' : '' }}"
                 href="{{ route('admin.users.index') }}">Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active fw-semibold' : '' }}"
                 href="{{ route('admin.products.index') }}">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active fw-semibold' : '' }}"
                 href="{{ route('admin.orders.index') }}">Transactions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active fw-semibold' : '' }}"
                 href="{{ route('admin.reports.monthly') }}">Reports</a>
            </li>
          @endif
        @endauth
      </ul>

      <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
        @guest
          <li class="nav-item"><a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="btn btn-primary" href="{{ route('register') }}">Register</a></li>
        @else
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active fw-semibold' : '' }}"
               href="{{ route('profile.show') }}">
              {{ auth()->user()->name }}
            </a>
          </li>

          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-outline-danger" type="submit">Logout</button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
