@php
  $cart = session('cart', []);
  $cartCount = 0;
  foreach ($cart as $it) { $cartCount += (int)($it['qty'] ?? 0); }

  $u = auth()->user();

  $avatarUrl = ($u && $u->avatar_path)
    ? \Illuminate\Support\Facades\Storage::url($u->avatar_path)
    : null;

  $isCustomer = $u && $u->role === 'customer';
  $isSeller   = $u && $u->role === 'seller';

  // profile destination: customer -> profile.show, seller -> seller.settings (if exists)
  $profileHref = route('profile.show');
  if ($isSeller && \Illuminate\Support\Facades\Route::has('seller.settings')) {
    $profileHref = route('seller.settings');
  }
@endphp

<div class="topbar py-2">
  <div class="container-xl d-flex align-items-center gap-3">
    <a class="brand text-decoration-none fs-4" href="{{ route('landing') }}">
      Outfit<span class="text-danger">ly</span>
    </a>

    <form class="search-pill d-none d-md-flex align-items-center flex-grow-1"
          method="GET" action="{{ route('products.index') }}" style="max-width:760px;">
      <i class="bi bi-search me-2 text-muted"></i>
      <input class="w-100" name="q" placeholder="Cari produk..." value="{{ request('q') }}">
    </form>

    <div class="d-flex align-items-center gap-2 ms-auto">
    @auth
        {{-- Dashboard shortcut (optional) --}}
        @if (auth()->user()->role === 'customer' && \Illuminate\Support\Facades\Route::has('customer.dashboard'))
        <a class="nav-icon" href="{{ route('customer.dashboard') }}" title="Dashboard">
            <i class="bi bi-speedometer2"></i>
        </a>
        @endif

        <a class="nav-icon position-relative" href="{{ route('cart.index') }}" title="Keranjang">
            <i class="bi bi-bag"></i>
            @if ($cartCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $cartCount }}
                </span>
            @endif
        </a>

        <a class="nav-icon" href="{{ route('customer.orders.index') }}" title="Pesanan">
            <i class="bi bi-receipt"></i>
        </a>

        <a class="nav-icon p-0 overflow-hidden" href="{{ $profileHref }}" title="Profil">
          @if($avatarUrl)
            <img
              src="{{ $avatarUrl }}?v={{ optional($u->updated_at)->timestamp }}"
              alt="Profil"
              style="width:100%;height:100%;object-fit:cover;display:block;"
            >
          @else
            <span class="w-100 h-100 d-flex align-items-center justify-content-center">
              <i class="bi bi-person"></i>
            </span>
          @endif
        </a>

        <form method="POST" action="{{ route('logout') }}" class="ms-1">
        @csrf
        <button class="btn btn-sm btn-danger">Logout</button>
        </form>
    @else
        <a class="btn btn-sm btn-outline-primary" href="{{ route('login') }}">Login</a>

        @if (\Illuminate\Support\Facades\Route::has('register'))
        <a class="btn btn-sm btn-primary" href="{{ route('register') }}">Register</a>
        @endif
    @endauth
    </div>
  </div>
</div>
