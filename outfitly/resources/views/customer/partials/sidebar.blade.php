<div class="card-like p-3 side">
  <div class="fw-bold mb-2">Akun Saya</div>

  <a class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"
     href="{{ route('customer.dashboard') }}">
    <i class="bi bi-speedometer2 me-2"></i> Dashboard
  </a>

  <a class="{{ request()->routeIs('products.*') ? 'active' : '' }}"
     href="{{ route('products.index') }}">
    <i class="bi bi-shop me-2"></i> Belanja
  </a>

  <a class="{{ request()->routeIs('customer.orders.*') ? 'active' : '' }}"
     href="{{ route('customer.orders.index') }}">
    <i class="bi bi-receipt me-2"></i> Riwayat Pesanan
  </a>

  <a class="{{ request()->routeIs('cart.*') ? 'active' : '' }}"
     href="{{ route('cart.index') }}">
    <i class="bi bi-bag me-2"></i> Keranjang
  </a>

  <a class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"
     href="{{ route('profile.show') }}">
    <i class="bi bi-gear me-2"></i> Profil
  </a>
</div>
