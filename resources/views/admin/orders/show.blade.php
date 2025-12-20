<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Transaksi #{{ $order->id }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@php use Illuminate\Support\Facades\Storage; @endphp

<div class="container py-5" style="max-width: 980px;">
  <a href="{{ route('admin.orders.index') }}">&larr; Kembali</a>

  <div class="d-flex justify-content-between align-items-start mt-3">
    <div>
      <h2 class="fw-bold mb-1">Detail Transaksi #{{ $order->id }}</h2>
      <div class="text-muted">Tanggal: {{ $order->created_at->format('Y-m-d H:i') }}</div>
    </div>

    <div class="text-end">
      <div class="fw-semibold mb-1">Status</div>
      <form method="POST" action="{{ route('admin.orders.status', $order->id) }}" class="d-flex gap-2">
        @csrf
        <select class="form-select form-select-sm" name="status">
          @foreach (['pending','paid','shipped','completed','cancelled'] as $st)
            <option value="{{ $st }}" @selected($order->status === $st)>{{ $st }}</option>
          @endforeach
        </select>
        <button class="btn btn-sm btn-primary" type="submit">Update</button>
      </form>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
  @endif

  <div class="row g-4 mt-1">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="fw-bold mb-2">Buyer</div>
          <div class="fw-semibold">{{ $order->buyer->name ?? 'Buyer' }}</div>
          <div class="text-muted">{{ $order->buyer->email ?? '' }}</div>

          <hr>

          <div class="fw-bold mb-2">Seller</div>
          <div class="fw-semibold">{{ $order->seller->name ?? 'Seller' }}</div>
          <div class="text-muted">{{ $order->seller->email ?? '' }}</div>

          <hr>

          <div class="fw-bold mb-2">Pengiriman</div>
          <div><span class="text-muted">Nama:</span> {{ $order->shipping_name }}</div>
          <div><span class="text-muted">HP:</span> {{ $order->shipping_phone }}</div>
          <div class="mt-2"><span class="text-muted">Alamat:</span><br>{{ $order->shipping_address }}</div>
        </div>
      </div>
    </div>

    <div class="col-md-7">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="fw-bold mb-3">Item</div>

          @foreach ($order->items as $it)
            <div class="d-flex gap-3 align-items-center mb-3">
              @if ($it->product?->image_path)
                <img src="{{ Storage::url($it->product->image_path) }}"
                     style="width:90px;height:70px;object-fit:cover;border-radius:12px;">
              @endif

              <div class="flex-grow-1">
                <div class="fw-semibold">{{ $it->product->name ?? 'Produk' }}</div>
                <div class="small text-muted">
                  Rp {{ number_format($it->price, 0, ',', '.') }} × {{ $it->quantity }}
                </div>
              </div>

              <div class="fw-semibold">
                Rp {{ number_format($it->subtotal, 0, ',', '.') }}
              </div>
            </div>
          @endforeach

          <hr>
          <div class="d-flex justify-content-between fw-bold">
            <div>Total</div>
            <div>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
