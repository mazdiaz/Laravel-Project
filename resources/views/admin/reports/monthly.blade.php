<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Bulanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h2 class="fw-bold mb-1">Laporan Bulanan</h2>
      <div class="text-muted">
        Periode: {{ $start->format('Y-m-d') }} s/d {{ $end->format('Y-m-d') }}
      </div>
    </div>

    <form method="GET" action="{{ route('admin.reports.monthly') }}" class="d-flex gap-2">
      <input type="month" name="month" class="form-control" value="{{ $month }}">
      <button class="btn btn-primary" type="submit">Tampilkan</button>
    </form>
  </div>

  <div class="row g-3 mb-3">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Total Orders</div>
          <div class="fs-4 fw-bold">{{ number_format($totalOrders) }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Gross Revenue</div>
          <div class="fs-4 fw-bold">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Revenue (excl. cancelled)</div>
          <div class="fs-4 fw-bold">Rp {{ number_format($netRevenue, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="fw-bold mb-2">Breakdown Status</div>
          <div class="table-responsive">
            <table class="table table-sm mb-0 align-middle">
              <thead>
                <tr>
                  <th>Status</th>
                  <th class="text-end">Orders</th>
                  <th class="text-end">Revenue</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($byStatus as $row)
                  <tr>
                    <td><span class="badge text-bg-secondary">{{ $row->status }}</span></td>
                    <td class="text-end">{{ number_format($row->orders) }}</td>
                    <td class="text-end">Rp {{ number_format($row->revenue, 0, ',', '.') }}</td>
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

    <div class="col-md-7">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="fw-bold mb-2">Top Sellers</div>
          <div class="table-responsive">
            <table class="table table-sm mb-0 align-middle">
              <thead>
                <tr>
                  <th>Seller</th>
                  <th class="text-end">Orders</th>
                  <th class="text-end">Revenue</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($topSellers as $s)
                  <tr>
                    <td>
                      <div class="fw-semibold">{{ $s->seller->name ?? ('Seller #'.$s->seller_id) }}</div>
                      <div class="small text-muted">{{ $s->seller->email ?? '' }}</div>
                    </td>
                    <td class="text-end">{{ number_format($s->orders) }}</td>
                    <td class="text-end">Rp {{ number_format($s->revenue, 0, ',', '.') }}</td>
                  </tr>
                @empty
                  <tr><td colspan="3" class="text-muted text-center py-3">No data</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card shadow-sm mt-3">
        <div class="card-body">
          <div class="fw-bold mb-2">Daily Revenue</div>
          <div class="table-responsive">
            <table class="table table-sm mb-0 align-middle">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th class="text-end">Orders</th>
                  <th class="text-end">Revenue</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($daily as $d)
                  <tr>
                    <td>{{ $d->day }}</td>
                    <td class="text-end">{{ number_format($d->orders) }}</td>
                    <td class="text-end">Rp {{ number_format($d->revenue, 0, ',', '.') }}</td>
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
  </div>
</div>

</body>
</html>
