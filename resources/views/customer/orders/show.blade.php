@extends('layouts.customer')
@section('title', 'Detail Pesanan #'.$order->id)

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp

  <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
    <div>
      <h4 class="page-title m-0">Detail Pesanan #{{ $order->id }}</h4>
      <div class="text-muted small">Tanggal: {{ $order->created_at->format('Y-m-d H:i') }}</div>
    </div>
    <a class="btn btn-outline-primary" href="{{ route('customer.orders.index') }}">
      <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
  </div>

  <div class="row g-3">
    <div class="col-lg-5">
      <div class="card-like p-3">
        <div class="fw-bold mb-2">Status</div>
        <span class="badge text-bg-secondary">{{ $order->status }}</span>

        <hr>

        <div class="fw-bold mb-2">Penjual</div>
        <div class="fw-semibold">{{ $order->seller->name ?? 'Seller' }}</div>
        <div class="text-muted small">{{ $order->seller->email ?? '' }}</div>

        <hr>

        <div class="fw-bold mb-2">Pengiriman</div>
        <div><span class="text-muted">Nama:</span> {{ $order->shipping_name }}</div>
        <div><span class="text-muted">HP:</span> {{ $order->shipping_phone }}</div>
        <div class="mt-2"><span class="text-muted">Alamat:</span><br>{{ $order->shipping_address }}</div>
      </div>
    </div>

    <div class="col-lg-7">
      <div class="card-like p-3">
        <div class="fw-bold mb-3">Item</div>

        @foreach ($order->items as $it)
          <div class="d-flex gap-3 align-items-center mb-3">
            @if ($it->product?->image_path)
              <img src="{{ Storage::url($it->product->image_path) }}"
                   style="width:90px;height:70px;object-fit:cover;border-radius:14px;">
            @endif

            <div class="flex-grow-1">
              <div class="fw-semibold">{{ $it->product->name ?? 'Produk' }}</div>
              <div class="small text-muted">
                Rp {{ number_format($it->price, 0, ',', '.') }} × {{ $it->quantity }}
              </div>
            </div>

            <div class="fw-bold">
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

      <div class="mt-3 d-flex gap-2">
        <a class="btn btn-outline-primary" href="{{ route('products.index') }}">Belanja lagi</a>
      </div>
    </div>
  </div>
@endsection
