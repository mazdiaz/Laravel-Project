<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Outfitly Panel')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  {{-- Dashboard UI CSS (separate from public pages) --}}
  <link rel="stylesheet" href="{{ asset('assets/css/panel.css') }}">

  @stack('styles')
</head>
<body class="panel-body">

  @include('partials.panel-topbar')

  <div class="panel-shell">
    <aside class="panel-sidebar">
      @yield('sidebar')
    </aside>

    <main class="panel-main">
      <div class="panel-content">
        @yield('content')
      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
