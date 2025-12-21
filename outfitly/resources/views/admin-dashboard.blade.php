@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

  <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
    <h4 class="m-0 fw-bold text-dark">Dashboard Admin</h4>
    <span class="text-muted small">{{ now()->format('l, d F Y') }}</span>
  </div>

  {{-- KPI CARDS --}}
  <div class="row g-3 mb-4">
    {{-- Card 1: Total Pengguna --}}
    <div class="col-6 col-lg-3">
      <div class="card-like kpi p-3 bg-white rounded shadow-sm h-100">
        <div class="d-flex align-items-center gap-2 mb-2">
          <div class="icon bg-primary bg-opacity-10 p-2 rounded text-primary">
            <i class="fa-solid fa-users"></i>
          </div>
          <div class="small text-muted fw-semibold">Total Pengguna</div>
        </div>
        {{-- Gunakan variabel dari Controller --}}
        <div class="fs-4 fw-bold text-dark">{{ number_format($usersCount) }}</div>
        <div class="small text-muted mt-1">User terdaftar</div>
      </div>
    </div>

    {{-- Card 2: Produk Terdaftar --}}
    <div class="col-6 col-lg-3">
      <div class="card-like kpi p-3 bg-white rounded shadow-sm h-100">
        <div class="d-flex align-items-center gap-2 mb-2">
          <div class="icon bg-warning bg-opacity-10 p-2 rounded text-warning">
            <i class="fa-solid fa-box"></i>
          </div>
          <div class="small text-muted fw-semibold">Produk Terdaftar</div>
        </div>
        <div class="fs-4 fw-bold text-dark">{{ number_format($productsCount) }}</div>
        <div class="small text-muted mt-1">{{ $activeProducts }} Aktif</div>
      </div>
    </div>

    {{-- Card 3: Transaksi Bulan Ini --}}
    <div class="col-6 col-lg-3">
      <div class="card-like kpi p-3 bg-white rounded shadow-sm h-100">
        <div class="d-flex align-items-center gap-2 mb-2">
          <div class="icon bg-info bg-opacity-10 p-2 rounded text-info">
            <i class="fa-solid fa-file-invoice-dollar"></i>
          </div>
          <div class="small text-muted fw-semibold">Order Bulan Ini</div>
        </div>
        <div class="fs-4 fw-bold text-dark">{{ number_format($ordersThisMonth) }}</div>
        <div class="small text-muted mt-1">Transaksi baru</div>
      </div>
    </div>

    {{-- Card 4: Pendapatan --}}
    <div class="col-6 col-lg-3">
      <div class="card-like kpi p-3 bg-white rounded shadow-sm h-100">
        <div class="d-flex align-items-center gap-2 mb-2">
          <div class="icon bg-success bg-opacity-10 p-2 rounded text-success">
            <i class="fa-solid fa-money-bill-trend-up"></i>
          </div>
          <div class="small text-muted fw-semibold">Revenue Bulan Ini</div>
        </div>
        <div class="fs-4 fw-bold text-dark">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</div>
        <div class="small text-muted mt-1">Omzet masuk</div>
      </div>
    </div>
  </div>

  {{-- Tabel Aktivitas / Transaksi Terbaru --}}
  <div class="card-like bg-white rounded shadow-sm p-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div class="fw-bold text-dark">Transaksi Terbaru</div>
      <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>

    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light">
          <tr>
            <th>Order ID</th>
            <th>Pembeli</th>
            <th>Total</th>
            <th>Status</th>
            <th>Waktu</th>
          </tr>
        </thead>
        <tbody>
          {{-- Gunakan variabel $latestOrders dari Controller --}}
          @forelse ($latestOrders as $order)
            <tr>
              <td><span class="fw-medium">#{{ $order->id }}</span></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                   <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px">
                        <i class="bi bi-person text-secondary"></i>
                   </div>
                   {{-- PERBAIKAN: Gunakan 'buyer' bukan 'user' --}}
                   <div class="fw-semibold">{{ $order->buyer->name ?? 'User Terhapus' }}</div>
                </div>
              </td>
              <td class="fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
              <td>
                @php
                    $statusColor = match($order->status) {
                        'completed', 'success', 'paid' => 'success',
                        'pending', 'waiting' => 'warning',
                        'cancelled', 'failed' => 'danger',
                        'shipped' => 'primary',
                        default => 'secondary',
                    };
                @endphp
                <span class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} px-3 py-2 rounded-pill">
                    {{ ucfirst($order->status) }}
                </span>
              </td>
              <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-4 text-muted">
                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                Belum ada data transaksi.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection