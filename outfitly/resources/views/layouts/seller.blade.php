<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Seller Panel')</title>

  {{-- Bootstrap + Icons (your dashboard depends on these) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  {{-- Seller dashboard theme --}}
  <link rel="stylesheet" href="{{ asset('assets/css/seller.css') }}">

  @stack('styles')
</head>
<body class="seller-body">

  @include('seller.partials.topbar')

  <div class="container-xl py-4">
    <div class="row g-3">
      <aside class="col-12 col-md-3">
        @include('seller.partials.sidebar')
      </aside>

      <main class="col-12 col-md-9">
        @yield('content')
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
