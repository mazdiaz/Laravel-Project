@extends('layouts.seller')
@section('title', 'Monitoring Pesanan')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
      <h5 class="m-0 seller-title">Monitoring Pesanan</h5>
      <div class="text-muted small">Lihat pesanan yang masuk untuk produk kamu.</div>
    </div>
  </div>

  <div class="card-like">
    {{-- Filters --}}
    <form method="GET" action="{{ route('seller.orders.index') }}" class="row g-2 align-items-end mb-3">
      <div class="col-12 col-md-5">
        <label class="form-label small text-muted mb-1">Pencarian</label>
        <input type="text" name="q" class="form-control"
               placeholder="Order ID / nama pembeli / email..."
               value="{{ $q ?? '' }}">
      </div>

      <div class="col-6 col-md-3">
        <label class="form-label small text-muted mb-1">Status</label>
        <select name="status" class="form-select">
          <option value="">Semua</option>
          @foreach (['pending','paid','processing','shipped','completed','cancelled'] as $st)
            <option value="{{ $st }}" @selected(($status ?? '')===$st)>{{ ucfirst($st) }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-6 col-md-3">
        <label class="form-label small text-muted mb-1">Urutan</label>
        <select name="sort" class="form-select">
          <option value="latest"     @selected(($sort ?? 'latest')==='latest')>Terbaru</option>
          <option value="oldest"     @selected(($sort ?? '')==='oldest')>Terlama</option>
          <option value="total_desc" @selected(($sort ?? '')==='total_desc')>Total Tertinggi</option>
          <option value="total_asc"  @selected(($sort ?? '')==='total_asc')>Total Terendah</option>
        </select>
      </div>

      <div class="col-12 col-md-1 d-grid">
        <button class="btn btn-primary" type="submit">Go</button>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table align-middle table-hover mb-0">
        <thead>
          <tr class="small text-muted">
            <th style="width:90px;">Order</th>
            <th style="width:130px;">Tanggal</th>
            <th>Pembeli</th>
            <th style="width:90px;" class="text-end">Item</th>
            <th style="width:170px;" class="text-end">Total</th>
            <th style="width:140px;">Status</th>
            <th style="width:110px;" class="text-end">Aksi</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($orders as $o)
            @php
              $buyerName  = $o->buyer->name ?? ('User #'.($o->buyer_id ?? '-'));
              $buyerEmail = $o->buyer->email ?? '';
              $itemsCount = $o->items?->count() ?? 0;

              $badge = match($o->status) {
                'completed'  => 'text-bg-success',
                'cancelled'  => 'text-bg-danger',
                'processing' => 'text-bg-primary',
                'shipped'    => 'text-bg-info',
                'paid'       => 'text-bg-warning',
                default      => 'text-bg-secondary',
              };
            @endphp

            <tr>
              <td class="fw-semibold">#{{ $o->id }}</td>
              <td class="small text-muted">{{ optional($o->created_at)->format('Y-m-d') }}</td>

              <td>
                <div class="fw-semibold">{{ $buyerName }}</div>
                <div class="small text-muted">{{ $buyerEmail }}</div>
              </td>

              <td class="text-end">{{ $itemsCount }}</td>

              <td class="text-end fw-semibold">
                Rp {{ number_format($o->total_amount ?? 0, 0, ',', '.') }}
              </td>

              <td><span class="badge {{ $badge }}">{{ $o->status }}</span></td>

              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('seller.orders.show', $o->id) }}">
                  Detail
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">Belum ada pesanan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $orders->links() }}
    </div>
  </div>
@endsection
