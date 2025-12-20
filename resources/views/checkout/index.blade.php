@extends('layouts.customer')
@section('title', 'Checkout')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
      <h4 class="page-title m-0">Checkout</h4>
      <div class="text-muted small">Isi alamat pengiriman dan konfirmasi pesanan.</div>
    </div>
    <a class="btn btn-outline-primary" href="{{ route('cart.index') }}">
      <i class="bi bi-arrow-left me-1"></i> Kembali ke keranjang
    </a>
  </div>

  <div class="row g-3">
    <div class="col-lg-7">
      <div class="card-like p-3">
        <form method="POST" action="{{ route('checkout.process') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Nama Penerima</label>
            <input name="recipient_name" class="form-control" value="{{ old('recipient_name', $defaults['recipient_name'] ?? '') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">No HP</label>
            <input name="phone" class="form-control" value="{{ old('phone', $defaults['phone'] ?? '') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" class="form-control" rows="4" required>{{ old('address', $defaults['address'] ?? '') }}</textarea>
          </div>

          <button class="btn btn-primary w-100" type="submit">
            Bayar & Buat Pesanan
          </button>
        </form>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card-like p-3">
        <div class="fw-bold mb-2">Ringkasan</div>
        <div class="small text-muted mb-2">Total item: {{ count($cart) }}</div>

        <div class="d-flex justify-content-between fw-bold">
          <div>Total</div>
          <div>Rp {{ number_format($total, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>
  </div>
@endsection
