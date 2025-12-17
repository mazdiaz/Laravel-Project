<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="fw-bold mb-3">Manajemen Transaksi</h2>

  <form class="card shadow-sm mb-3" method="GET" action="{{ route('admin.orders.index') }}">
    <div class="card-body">
      <div class="row g-2">
        <div class="col-md-2">
          <label class="form-label">Order ID</label>
          <input class="form-control" name="order_id" value="{{ request('order_id') }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select class="form-select" name="status">
            <option value="">(all)</option>
            @foreach (['pending','paid','shipped','completed','cancelled'] as $st)
              <option value="{{ $st }}" @selected(request('status') === $st)>{{ $st }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">From</label>
          <input class="form-control" type="date" name="from" value="{{ request('from') }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">To</label>
          <input class="form-control" type="date" name="to" value="{{ request('to') }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Buyer</label>
          <input class="form-control" name="buyer" placeholder="name/email" value="{{ request('buyer') }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Seller</label>
          <input class="form-control" name="seller" placeholder="name/email" value="{{ request('seller') }}">
        </div>
      </div>

      <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary" type="submit">Filter</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.orders.index') }}">Reset</a>
      </div>
    </div>
  </form>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table mb-0 align-middle">
        <thead>
          <tr>
            <th style="width:90px;">Order</th>
            <th>Buyer</th>
            <th>Seller</th>
            <th>Total</th>
            <th>Status</th>
            <th style="width:160px;">Created</th>
            <th style="width:110px;"></th>
          </tr>
        </thead>
        <tbody>
          @forelse ($orders as $o)
            <tr>
              <td class="fw-semibold">#{{ $o->id }}</td>
              <td>
                <div class="fw-semibold">{{ $o->buyer->name ?? 'Buyer' }}</div>
                <div class="small text-muted">{{ $o->buyer->email ?? '' }}</div>
              </td>
              <td>
                <div class="fw-semibold">{{ $o->seller->name ?? 'Seller' }}</div>
                <div class="small text-muted">{{ $o->seller->email ?? '' }}</div>
              </td>
              <td>Rp {{ number_format($o->total_amount, 0, ',', '.') }}</td>
              <td><span class="badge text-bg-secondary">{{ $o->status }}</span></td>
              <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
              <td>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.orders.show', $o->id) }}">Detail</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">Belum ada transaksi.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    {{ $orders->links() }}
  </div>
</div>

</body>
</html>
