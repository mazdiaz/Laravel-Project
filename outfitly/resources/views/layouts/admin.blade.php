<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Panel')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <link rel="stylesheet" href="{{ asset('assets/css/seller.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

  @stack('styles')
</head>
<body class="seller-body" style="background-color: #f5f5f9;"> 
  {{-- Topbar Sederhana --}}
  <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top shadow-sm">
    <div class="container-xl">
      <a class="brand text-decoration-none fs-4" href="{{ route('products.index') }}">
        Outfit<span class="text-danger">ly</span>
      </a>
      <div class="ms-auto d-flex align-items-center gap-3">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown">
                <img src="https://i.pravatar.cc/40" alt="Admin" class="rounded-circle me-2" width="32" height="32">
                <span class="fw-medium small">Admin</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger small">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="container-xl py-4">
    <div class="row g-3">
      {{-- Sidebar Column --}}
      <aside class="col-12 col-md-3">
         @include('admin.partials.sidebar')
      </aside>

      {{-- Main Content Column --}}
      <main class="col-12 col-md-9">
        @yield('content')
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/admin.js') }}"></script>
  @stack('scripts')
</body>
</html>