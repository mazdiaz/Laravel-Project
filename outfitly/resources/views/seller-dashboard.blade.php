@extends('layouts.seller')

@section('title', 'Dashboard Penjual')

@section('content')
  <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
    <h5 class="m-0 seller-title">Dashboard Penjual</h5>

    <div class="d-flex gap-2 align-items-center">
      <form method="GET" action="{{ route('seller.dashboard') }}">
        <input name="month" type="month" class="form-control"
          value="{{ $month ?? date('Y-m') }}"
          style="width:180px"
          onchange="this.form.submit()" />
      </form>

      <a class="btn btn-orange" href="{{ route('seller.products.create') }}">
        <i class="bi bi-plus-lg me-1"></i> Tambah Produk
      </a>
    </div>
  </div>

  {{-- KPI --}}
  <div class="row g-3">
    <div class="col-6 col-lg-3">
      <div class="card-like kpi">
        <div class="d-flex align-items-center gap-2">
          <div class="icon"><i class="bi bi-cash-stack"></i></div>
          <div class="small text-muted">Total Penjualan (bulan)</div>
        </div>
        <div id="kpiSales" class="value mt-1">Rp {{ number_format($salesMonth ?? 0, 0, ',', '.') }}</div>
        <div id="kpiSalesSub" class="text-muted small mt-1"></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="card-like kpi">
        <div class="d-flex align-items-center gap-2">
          <div class="icon"><i class="bi bi-bag-check"></i></div>
          <div class="small text-muted">Jumlah Pesanan</div>
        </div>
        <div id="kpiOrders" class="value mt-1">{{ number_format($ordersMonth ?? 0, 0, ',', '.') }}</div>
        <div class="text-muted small mt-1">Visibel di etalase</div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="card-like kpi">
        <div class="d-flex align-items-center gap-2">
          <div class="icon"><i class="bi bi-box-seam"></i></div>
          <div class="small text-muted">Produk Aktif</div>
        </div>
        <div id="kpiActive" class="value mt-1">{{ number_format($activeProducts ?? 0, 0, ',', '.') }}</div>
        <div class="text-muted small mt-1">Visibel di etalase</div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="card-like kpi">
        <div class="d-flex align-items-center gap-2">
          <div class="icon"><i class="bi bi-exclamation-triangle"></i></div>
          <div class="small text-muted">Stok Rendah</div>
        </div>
        <div id="kpiLow" class="value mt-1">{{ number_format($lowStockCount ?? 0, 0, ',', '.') }}</div>
        <div class="text-muted small mt-1">Visibel di etalase</div>
      </div>
    </div>
  </div>

  <!-- Chart -->
  <div class="card-like mt-3">
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div class="fw-semibold" style="color:var(--navyText)">Penjualan Harian</div>
      <div class="text-muted small">Bulan terpilih</div>
    </div>
    <div class="chart-wrap">
      <canvas id="salesChart"></canvas>
    </div>
  </div>

  <!-- Tables -->
  <div class="row g-3 mt-1">
    <div class="col-12 col-lg-7">
      <div class="card-like">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <div class="fw-semibold" style="color:var(--navyText)">Pesanan Terbaru</div>
          <a href="{{ route('seller.orders.index') }}" class="small">Lihat semua</a>
        </div>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Tanggal</th>
                <th>Pembeli</th>
                <th>Total</th>
                <th>Status</th>
                <th>Fulfillment</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($latestOrders as $o)
                <tr>
                  <td>#{{ $o->id }}</td>
                  <td>{{ optional($o->created_at)->format('Y-m-d') }}</td>
                  <td>{{ $o->buyer_id ?? '-' }}</td>
                  <td>Rp {{ number_format($o->total_amount ?? 0, 0, ',', '.') }}</td>
                  <td><span class="badge bg-secondary">{{ $o->status }}</span></td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('seller.orders.show', $o->id) }}">Detail</a>
                  </td>
                </tr>
              @empty
                <tr><td colspan="6" class="text-muted">Belum ada pesanan.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-5">
      <div class="card-like">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <div class="fw-semibold" style="color:var(--navyText)">Stok Rendah</div>
          <a href="{{ route('seller.products.index') }}" class="small">Kelola produk</a>
        </div>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>SKU</th>
                <th>Produk</th>
                <th class="text-end">Stok</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($lowStockProducts as $p)
                <tr>
                  <td>{{ $p->id }}</td>
                  <td>{{ $p->name }}</td>
                  <td class="text-end">{{ $p->stock }}</td>
                </tr>
              @empty
                <tr><td colspan="3" class="text-muted">Tidak ada stok rendah.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const labels = @json($chartLabels ?? []);
    const values = @json($chartValues ?? []);

    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Penjualan (Rp)',
          data: values,
          tension: 0.35,
          fill: true,
          pointRadius: 2,
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: (v) => 'Rp ' + new Intl.NumberFormat('id-ID').format(v)
            }
          }
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: (ctx) => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
            }
          }
        }
      }
    });
  </script>
@endpush