<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Customer Panel') - Outfitly</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/seller.css') }}">


  <style>
    :root{
        --bg:#f6f3ea;
        --text:#111827;
        --border:#e5e7eb;
    }

    body{ background:var(--bg); color:var(--text); }

    /* keep customer topbar look */
    .topbar{
        background:#fff;
        border-bottom:1px solid var(--border);
        position:sticky; top:0; z-index:1030;
    }
    .brand{ font-weight:900; letter-spacing:.2px; color:var(--text); }

    .search-pill{
        background:#f3f4f6;
        border:1px solid var(--border);
        border-radius:999px;
        padding:.45rem .75rem;
    }
    .search-pill input{ border:0; outline:0; background:transparent; }

    .nav-icon{
        width:40px;height:40px;
        display:grid;place-items:center;
        border-radius:999px;
        border:1px solid var(--border);
        background:#fff;
        color:var(--text);
        text-decoration:none;
    }
    .nav-icon:hover{ background:#f9fafb; }

    .card-like{
        background:#fff;
        border:1px solid var(--border);
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.05);
    }

    .side a{
        display:block;
        padding:.6rem .8rem;
        border-radius:14px;
        text-decoration:none;
        color:var(--text);
    }

    .side a:hover{ background:#f3f4f6; }

    /* active state (adjust color if you want it closer to seller) */
    .side a.active{
        background:#111827;  /* or use a seller primary color */
        color:#fff;
    }

    .page-title{ font-weight:900; }
  </style>

  @stack('head')
</head>
<body>

@php
  $u = auth()->user();
  $avatarUrl = ($u && $u->avatar_path)
    ? \Illuminate\Support\Facades\Storage::url($u->avatar_path)
    : null;
  $cart = session('cart', []);
  $cartCount = 0;
  foreach ($cart as $it) { $cartCount += (int)($it['qty'] ?? 0); }
@endphp

<div class="topbar py-2">
  <div class="container-xl d-flex align-items-center gap-3">
    <a class="brand text-decoration-none fs-4" href="{{ route('products.index') }}">
      Outfit<span class="text-danger">ly</span>
    </a>

    <form class="search-pill d-none d-md-flex align-items-center flex-grow-1" method="GET" action="{{ route('products.index') }}" style="max-width:760px;">
      <i class="bi bi-search me-2 text-muted"></i>
      <input class="w-100" name="q" placeholder="Cari produk..." value="{{ request('q') }}">
    </form>

    <div class="d-flex align-items-center gap-2 ms-auto">
        <a class="nav-icon" href="{{ route('customer.dashboard') }}" title="Dashboard">
            <i class="bi bi-speedometer2"></i>
        </a>

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

        <a class="nav-icon overflow-hidden p-0" href="{{ route('profile.show') }}" title="Profil">
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

<div class="container-xl py-4">
  <div class="row g-3">
    <aside class="col-12 col-lg-3">
      @include('customer.partials.sidebar')
    </aside>

    <main class="col-12 col-lg-9">
      @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      @yield('content')
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
