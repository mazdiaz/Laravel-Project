@php
  $u = auth()->user();
  $avatarUrl = ($u && $u->avatar_path)
    ? \Illuminate\Support\Facades\Storage::url($u->avatar_path)
    : null;

  $sellerDashboardUrl = url('/seller-dashboard');
  $sellerProductsUrl  = url('/seller/products');
  $sellerOrdersUrl    = url('/seller/orders');
@endphp

<div class="topbar py-2">
  <div class="container-xl d-flex align-items-center gap-3">
    <a class="brand text-decoration-none fs-4" href="{{ $sellerDashboardUrl }}">
      Outfit<span class="text-danger">ly</span>
    </a>

    <form class="search-pill d-none d-md-flex align-items-center flex-grow-1"
          method="GET"
          action="{{ $sellerProductsUrl }}"
          style="max-width:760px;">
      <i class="bi bi-search me-2 text-muted"></i>
      <input class="w-100" name="q" placeholder="Cari produk / pesanan..." value="{{ request('q') }}">
    </form>

    <div class="d-flex align-items-center gap-2 ms-auto">
      <a class="nav-icon" href="{{ $sellerDashboardUrl }}" title="Dashboard">
        <i class="bi bi-speedometer2"></i>
      </a>

      <a class="nav-icon" href="{{ $sellerProductsUrl }}" title="Produk">
        <i class="bi bi-box-seam"></i>
      </a>

      <a class="nav-icon" href="{{ $sellerOrdersUrl }}" title="Pesanan">
        <i class="bi bi-receipt"></i>
      </a>

      {{-- ✅ profile icon becomes photo if available --}}
      <a class="nav-icon overflow-hidden p-0" href="{{ route('seller.settings') }}" title="Pengaturan Toko">
        @if($avatarUrl)
          <img
            src="{{ $avatarUrl }}?v={{ optional($u->updated_at)->timestamp }}"
            alt="Profil"
            style="width:100%;height:100%;object-fit:cover;display:block;"
          >
        @else
          <i class="bi bi-person"></i>
        @endif
      </a>

      <form method="POST" action="{{ route('logout') }}" class="ms-1">
        @csrf
        <button class="btn btn-sm btn-danger">Logout</button>
      </form>
    </div>
  </div>
</div>
