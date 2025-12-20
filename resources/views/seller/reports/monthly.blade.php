@extends('layouts.seller')
@section('title', 'Laporan Penjualan Bulanan')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
      <h5 class="m-0 seller-title">Laporan Penjualan Bulanan</h5>
      <div class="text-muted small">
        Periode: {{ $start->format('Y-m-d') }} s/d {{ $end->format('Y-m-d') }}
      </div>
    </div>

    <form method="GET" action="{{ route('seller.reports.monthly') }}" class="d-flex gap-2">
      <input type="month" name="month" class="form-control" value="{{ $month }}" style="width:180px;">
      <button class="btn btn-primary" type="submit">Tampilkan</button>
    </form>
  </div>

  <div class="row g-3 mb-3">
    <div class="col-md-4">
      <div class="card-like kpi">
        <div class="text-muted small">Total Orders</div>
        <div class="fs-4 fw-bold">{{ number_format($totalOrders ?? 0) }}</div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-like kpi">
        <div class="text-muted small">Gross Revenue</div>
        <div class="fs-4 fw-bold">Rp {{ number_format($grossRevenue ?? 0, 0, ',', '.') }}</div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-like kpi">
        <div class="text-muted small">Revenue (excl. cancelled)</div>
        <div class="fs-4 fw-bold">Rp {{ number_format($netRevenue ?? 0, 0, ',', '.') }}</div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-5">
      <div class="card-like">
        <div class="fw-semibold mb-2" style="color:var(--navyText)">Breakdown Status</div>
        <div class="table-responsive">
          <table class="table table-sm mb-0 align-middle">
            <thead>
              <tr class="small text-muted">
                <th>Status</th>
                <th class="text-end">Orders</th>
                <th class="text-end">Revenue</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($byStatus as $row)
                @php
                  $badge = match($row->status) {
                    'completed'  => 'text-bg-success',
                    'cancelled'  => 'text-bg-danger',
                    'processing' => 'text-bg-primary',
                    'shipped'    => 'text-bg-info',
                    'paid'       => 'text-bg-warning',
                    default      => 'text-bg-secondary',
                  };
                @endphp
                <tr>
                  <td><span class="badge {{ $badge }}">{{ $row->status }}</span></td>
                  <td class="text-end">{{ number_format($row->orders ?? 0) }}</td>
                  <td class="text-end">Rp {{ number_format($row->revenue ?? 0, 0, ',', '.') }}</td>
                </tr>
              @empty
                <tr><td colspan="3" class="text-muted text-center py-3">No data</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-7">
      <div class="card-like">
        <div class="fw-semibold mb-2" style="color:var(--navyText)">Top Products</div>
        <div class="table-responsive">
          <table class="table table-sm mb-0 align-middle">
            <thead>
              <tr class="small text-muted">
                <th>Produk</th>
                <th class="text-end">Qty</th>
                <th class="text-end">Revenue</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($topProducts as $p)
                <tr>
                  <!-- <td class="fw-semibold">Product #{{ $p->product_id }}</td> -->
                  <td class="fw-semibold">{{ $p->product_name }}</td>
                  <td class="text-end">{{ number_format($p->qty ?? 0) }}</td>
                  <td class="text-end">Rp {{ number_format($p->revenue ?? 0, 0, ',', '.') }}</td>
                </tr>
              @empty
                <tr><td colspan="3" class="text-muted text-center py-3">No data</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="card-like mt-3">
        <div class="fw-semibold mb-2" style="color:var(--navyText)">Daily Revenue</div>
        <div class="table-responsive">
          <table class="table table-sm mb-0 align-middle">
            <thead>
              <tr class="small text-muted">
                <th>Tanggal</th>
                <th class="text-end">Orders</th>
                <th class="text-end">Revenue</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($daily as $d)
                <tr>
                  <td>{{ $d->day }}</td>
                  <td class="text-end">{{ number_format($d->orders ?? 0) }}</td>
                  <td class="text-end">Rp {{ number_format($d->revenue ?? 0, 0, ',', '.') }}</td>
                </tr>
              @empty
                <tr><td colspan="3" class="text-muted text-center py-3">No data</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
