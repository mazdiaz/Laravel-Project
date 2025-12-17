<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Outfitly')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    :root{
      --cust:#2563eb;
      --bg:#f6f3ea;
      --card:#ffffff;
      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --radius:18px;
    }
    body{ background:var(--bg); color:var(--text); }
    .topbar{ background:#fff; border-bottom:1px solid var(--border); position:sticky; top:0; z-index:1030; }
    .brand{ font-weight:900; letter-spacing:.2px; color:var(--text); }
    .search-pill{ background:#f3f4f6; border:1px solid var(--border); border-radius:999px; padding:.45rem .75rem; }
    .search-pill input{ border:0; outline:0; background:transparent; }
    .nav-icon{
      width:40px;height:40px; display:grid;place-items:center;
      border-radius:999px; border:1px solid var(--border);
      background:#fff; color:var(--text); text-decoration:none;
    }
    .nav-icon:hover{ background:#f9fafb; }
    .card-like{
      background:var(--card); border:1px solid var(--border);
      border-radius:var(--radius); box-shadow:0 10px 30px rgba(0,0,0,.05);
    }
    .btn-primary{ background:var(--cust); border-color:var(--cust); }
    .btn-outline-primary{ color:var(--cust); border-color:rgba(37,99,235,.35); }
    .btn-outline-primary:hover{ background:var(--cust); border-color:var(--cust); }
  </style>

  @stack('head')
</head>
<body>

  @include('customer.partials.topbar')

  <div class="container-xl py-4">
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
