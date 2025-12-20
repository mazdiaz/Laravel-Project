<!doctype html>
@extends('layouts.customer')
@section('title', 'Dashboard Pembeli')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
      <h4 class="fw-bold m-0">Hai, {{ auth()->user()->name }} 👋</h4>
      <div class="text-muted">Selamat datang kembali. Yuk cek pesanan dan produk terbaru.</div>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-primary">
      <i class="bi bi-grid me-1"></i> Belanja Lagi
    </a>
  </div>

  <div class="row g-3">
    <div class="col-12 col-md-4">
      <div class="card-like kpi">
        <div>
          <div class="text-muted small">Total Pesanan</div>
          <div class="fs-4 fw-bold">{{ $totalOrders ?? 0 }}</div>
        </div>
        <div class="icon"><i class="bi bi-receipt"></i></div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card-like kpi">
        <div>
          <div class="text-muted small">Pesanan Diproses</div>
          <div class="fs-4 fw-bold">{{ $inProgress ?? 0 }}</div>
        </div>
        <div class="icon" style="background:rgba(16,185,129,.12);color:var(--c-accent)">
          <i class="bi bi-truck"></i>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card-like kpi">
        <div>
          <div class="text-muted small">Total Belanja (bulan ini)</div>
          <div class="fs-4 fw-bold">Rp {{ number_format($spentThisMonth ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="icon"><i class="bi bi-cash-coin"></i></div>
      </div>
    </div>
  </div>

  <div class="card-like mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div class="fw-bold">Pesanan Terbaru</div>
      <a href="{{ route('customer.orders.index') }}" class="small">Lihat semua</a>
    </div>

    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead class="small text-muted">
          <tr>
            <th style="width:90px;">Order</th>
            <th style="width:130px;">Tanggal</th>
            <th>Total</th>
            <th style="width:140px;">Status</th>
            <th style="width:110px;" class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse(($recentOrders ?? []) as $o)
            <tr>
              <td class="fw-semibold">#{{ $o->id }}</td>
              <td class="text-muted small">{{ optional($o->created_at)->format('Y-m-d') }}</td>
              <td class="fw-semibold">Rp {{ number_format($o->total_amount ?? 0, 0, ',', '.') }}</td>
              <td><span class="badge text-bg-secondary">{{ $o->status }}</span></td>
              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('customer.orders.show', $o) }}">Detail</a>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada pesanan.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection






