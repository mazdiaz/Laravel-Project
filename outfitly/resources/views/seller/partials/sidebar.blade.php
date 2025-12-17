<div class="panel-card p-3">
  <div class="fw-bold mb-2">Akun Saya</div>

  @php
    $link = fn($is, $route, $label) =>
      '<a class="d-block px-3 py-2 rounded-3 text-decoration-none '.
      ($is ? 'text-white' : 'text-dark').
      '" style="background:'.($is ? 'var(--navy)' : 'transparent').';"
      href="'.$route.'">'.$label.'</a>';
  @endphp

  <div class="d-grid gap-1">
    {!! $link(request()->routeIs('seller.dashboard'), route('seller.dashboard'), 'Dashboard Penjual') !!}
    {!! $link(request()->routeIs('seller.products.index'), route('seller.products.index'), 'Daftar Produk') !!}
    {!! $link(request()->routeIs('seller.products.create'), route('seller.products.create'), 'Tambah Produk') !!}
    {!! $link(request()->routeIs('seller.orders.*'), route('seller.orders.index'), 'Monitoring Pesanan') !!}
    {!! $link(false, route('seller.orders.index'), 'Riwayat Transaksi') !!}
    {!! $link(request()->routeIs('seller.reports.monthly'), route('seller.reports.monthly'), 'Laporan Penjualan') !!}
    {!! $link(request()->routeIs('seller.settings*'), route('seller.settings'), 'Pengaturan Toko') !!}
  </div>
</div>
