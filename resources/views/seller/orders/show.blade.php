@extends('layouts.seller')
@section('title', 'Detail Pesanan')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <a href="{{ route('seller.orders.index') }}" class="btn btn-primary mb-3">&larr; Kembali</a>
      <h5 class="m-0 seller-title mt-1">Detail Pesanan #{{ $order->id }}</h5>
      <div class="text-muted small">
        {{ optional($order->created_at)->format('Y-m-d H:i') }}
      </div>
    </div>

    <form method="POST" action="{{ route('seller.orders.status', $order) }}" class="d-flex gap-2 align-items-center">
      @csrf
      <select name="status" class="form-select" style="width: 200px;">
        @foreach (['pending','paid','processing','shipped','completed','cancelled'] as $st)
          <option value="{{ $st }}" @selected($order->status === $st)>{{ ucfirst($st) }}</option>
        @endforeach
      </select>
      <button class="btn btn-primary" type="submit">Update</button>
    </form>
  </div>

  <div class="row g-3">
    <div class="col-12 col-lg-8">
      <div class="card-like">
        <div class="fw-semibold mb-2" style="color:var(--navyText)">Item Pesanan</div>

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr class="small text-muted">
                <th>Produk</th>
                <th class="text-end" style="width:120px;">Harga</th>
                <th class="text-end" style="width:90px;">Qty</th>
                <th class="text-end" style="width:160px;">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($order->items as $it)
                @php
                  $p = $it->product;
                  $name = $p->name ?? ('Produk #'.$it->product_id);
                  $img = $p?->image_path ? asset('storage/'.$p->image_path) : 'https://via.placeholder.com/120';
                  $price = $it->price ?? ($p->price ?? 0);
                  $qty = $it->quantity ?? 1;
                @endphp

                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <img src="{{ $img }}" alt="{{ $name }}"
                           style="width:44px;height:44px;object-fit:cover;border-radius:10px;border:1px solid rgba(0,0,0,.08);">
                      <div>
                        <div class="fw-semibold">{{ $name }}</div>
                        <div class="small text-muted">ID: {{ $it->product_id }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="text-end">Rp {{ number_format($price, 0, ',', '.') }}</td>
                  <td class="text-end">{{ $qty }}</td>
                  <td class="text-end fw-semibold">Rp {{ number_format($price * $qty, 0, ',', '.') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
          <div style="min-width:260px;">
            <div class="d-flex justify-content-between small text-muted">
              <span>Total</span>
              <span>Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="card-like">
        <div class="fw-semibold mb-2" style="color:var(--navyText)">Pembeli</div>
        <div class="fw-semibold">{{ $order->buyer->name ?? ('User #'.($order->buyer_id ?? '-')) }}</div>
        <div class="small text-muted">{{ $order->buyer->email ?? '' }}</div>

        <hr>
        <div class="small text-muted">Status saat ini</div>
        <div class="fw-semibold">{{ $order->status }}</div>
      </div>
    </div>
  </div>
@endsection
