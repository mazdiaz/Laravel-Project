@extends('layouts.customer')
@section('title', 'Riwayat Pesanan')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
      <h4 class="page-title m-0">Riwayat Pesanan</h4>
      <div class="text-muted small">Lihat status pesanan kamu dan detail item.</div>
    </div>

    <a class="btn btn-outline-primary" href="{{ route('products.index') }}">
      <i class="bi bi-arrow-left me-1"></i> Belanja lagi
    </a>
  </div>

  @forelse ($orders as $o)
    @php
      $badge = match($o->status) {
        'completed'  => 'text-bg-success',
        'cancelled'  => 'text-bg-danger',
        'processing' => 'text-bg-primary',
        'shipped'    => 'text-bg-info',
        'paid'       => 'text-bg-warning',
        default      => 'text-bg-secondary',
      };
    @endphp

    <div class="card-like p-3 mb-3">
      <div class="d-flex justify-content-between align-items-start gap-3">
        <div>
          <div class="fw-bold">Order #{{ $o->id }}</div>
          <div class="small text-muted">
            {{ optional($o->created_at)->format('Y-m-d H:i') }}
            @if ($o->seller?->name)
              • Penjual: {{ $o->seller->name }}
            @endif
          </div>
        </div>
        <span class="badge {{ $badge }}">{{ $o->status }}</span>
      </div>

      <div class="mt-2 fw-semibold">
        Total: Rp {{ number_format($o->total_amount ?? 0, 0, ',', '.') }}
      </div>

      <hr class="my-3">

      <ul class="mb-0 small">
        @foreach ($o->items as $it)
          <li>{{ $it->product->name ?? 'Produk' }} × {{ $it->quantity }}</li>
        @endforeach
      </ul>

      <div class="mt-3 d-flex justify-content-end">
        <a class="btn btn-sm btn-primary" href="{{ route('customer.orders.show', $o->id) }}">
          Detail
        </a>
      </div>
    </div>
  @empty
    <div class="card-like p-4 text-center text-muted">
      Belum ada pesanan.
    </div>
  @endforelse

  <div class="mt-3">
    {{ $orders->links() }}
  </div>
@endsection
