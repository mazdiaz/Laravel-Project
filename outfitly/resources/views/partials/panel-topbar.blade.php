@php
  $u = auth()->user();
  $avatarUrl = ($u && $u->avatar_path)
    ? \Illuminate\Support\Facades\Storage::url($u->avatar_path)
    : null;
@endphp

<header class="panel-topbar">
  <div class="container-fluid px-4 d-flex align-items-center gap-3">
    <a href="{{ route('landing') }}" class="panel-logo">
      Outfit<span>ly</span>
    </a>

    <form class="panel-search ms-3" method="GET" action="#">
      <i class="bi bi-search"></i>
      <input type="text" placeholder="Cari produk / pesanan..." />
    </form>

    <div class="ms-auto d-flex align-items-center gap-2">
      @auth
        <a class="panel-icon" href="{{ $dashboardUrl ?? url('/') }}" title="Dashboard">
          <i class="bi bi-speedometer2"></i>
        </a>

        <a class="nav-icon p-0 overflow-hidden" href="{{ route('profile.show') }}" title="Profil">
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

        @php $role = auth()->user()->role; @endphp
        @if($role === 'customer')
          <a class="panel-icon" href="{{ route('cart.index') }}" title="Keranjang">
            <i class="bi bi-bag"></i>
          </a>
        @endif

        <span class="panel-user">{{ auth()->user()->name }}</span>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-sm btn-outline-danger">Logout</button>
        </form>
      @endauth
    </div>
  </div>
</header>