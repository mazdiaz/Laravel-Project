@extends('layouts.admin')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Data Transaksi</h2>
</div>

<div class="card border-0 shadow-sm mb-4">
  <div class="card-body bg-white rounded">
    <form method="GET" action="{{ route('admin.orders.index') }}">
      <div class="row g-3">
        <div class="col-md-2">
          <label class="form-label small text-muted">Order ID</label>
          <input type="text" class="form-control" name="order_id" 
                 value="{{ request('order_id') }}" placeholder="#123">
        </div>
        <div class="col-md-2">
          <label class="form-label small text-muted">Status</label>
          <select class="form-select" name="status">
            <option value="">Semua Status</option>
            @foreach (['pending','paid','shipped','completed','cancelled'] as $st)
              <option value="{{ $st }}" @selected(request('status') === $st)>{{ ucfirst($st) }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
            <label class="form-label small text-muted">Rentang Tanggal</label>
            <div class="input-group">
                <input type="date" class="form-control" name="from" value="{{ request('from') }}">
                <span class="input-group-text bg-light text-muted">s/d</span>
                <input type="date" class="form-control" name="to" value="{{ request('to') }}">
            </div>
        </div>
        
        <div class="col-md-3">
          <label class="form-label small text-muted">Pembeli (Buyer)</label>
          <input class="form-control" name="buyer" placeholder="Nama/Email..." value="{{ request('buyer') }}">
        </div>
        <div class="col-md-3">
          <label class="form-label small text-muted">Penjual (Seller)</label>
          <input class="form-control" name="seller" placeholder="Nama/Email..." value="{{ request('seller') }}">
        </div>
        <div class="col-md-6 d-flex align-items-end gap-2">
             <button class="btn btn-primary px-4" type="submit">
                <i class="bi bi-funnel"></i> Terapkan Filter
             </button>
             @if(request()->anyFilled(['order_id', 'status', 'from', 'to', 'buyer', 'seller']))
                <a class="btn btn-outline-secondary" href="{{ route('admin.orders.index') }}">Reset</a>
             @endif
        </div>
      </div>
    </form>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-secondary">
          <tr>
            <th class="ps-4">ID</th>
            <th>Pembeli</th>
            <th>Penjual</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th class="text-end pe-4">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($orders as $o)
            <tr>
              <td class="ps-4 fw-bold text-primary">#{{ $o->id }}</td>
              <td>
                <div class="fw-semibold">{{ $o->buyer->name ?? 'Deleted User' }}</div>
                <div class="small text-muted">{{ $o->buyer->email ?? '-' }}</div>
              </td>
              <td>
                <div class="fw-semibold">{{ $o->seller->name ?? 'Deleted User' }}</div>
                <div class="small text-muted">{{ $o->seller->email ?? '-' }}</div>
              </td>
              <td class="fw-bold">Rp {{ number_format($o->total_amount, 0, ',', '.') }}</td>
              <td>
                @php
                    $statusColor = match($o->status) {
                        'pending' => 'warning',
                        'paid' => 'info',
                        'shipped' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary'
                    };
                @endphp
                <span class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} px-3 py-2 rounded-pill">
                    {{ ucfirst($o->status) }}
                </span>
              </td>
              <td class="text-muted small">
                {{ $o->created_at->format('d M Y') }} <br>
                {{ $o->created_at->format('H:i') }}
              </td>
              <td class="text-end pe-4">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.orders.show', $o->id) }}">
                    Detail <i class="bi bi-arrow-right"></i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">
                <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                Belum ada data transaksi yang ditemukan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($orders->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $orders->links() }}
    </div>
  @endif
</div>
@endsection