<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Outfitly')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  {{-- reuse same theme tokens --}}
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
    .card-like{
      background:var(--card);
      border:1px solid var(--border);
      border-radius:var(--radius);
      box-shadow:0 10px 30px rgba(0,0,0,.05);
    }
    .btn-primary{ background:var(--cust); border-color:var(--cust); }
    .btn-outline-primary{ color:var(--cust); border-color:rgba(37,99,235,.35); }
    .btn-outline-primary:hover{ background:var(--cust); border-color:var(--cust); }
  </style>

  @stack('styles')
</head>
<body>

  @include('partials.navbar')

  <main class="container py-4">
    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
