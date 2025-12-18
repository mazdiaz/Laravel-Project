@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Manajemen Produk</h2>
    <span class="text-muted">Semua Penjual</span>
</div>

<div class="card border-0 shadow-sm mb-4">
  <div class="card-body bg-white rounded">
    <form method="GET" action="{{ route('admin.products.index') }}">
      <div class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label small text-muted">Cari Produk</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control border-start-0" name="search" 
                   value="{{ request('search') }}" placeholder="Nama atau slug...">
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label small text-muted">Status</label>
          <select class="form-select" name="status">
            <option value="">Semua Status</option>
            <option value="active" @selected(request('status')==='active')>Active Only</option>
            <option value="inactive" @selected(request('status')==='inactive')>Inactive Only</option>
          </select>
        </div>
        <div class="col-md-2">
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>
        </div>
        <div class="col-md-2">
            <div class="d-grid gap-2">
                @if(request()->anyFilled(['search', 'seller', 'status']))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-danger">Reset</a>
                @endif
            </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="row g-4">
  @forelse ($products as $p)
    <div class="col-md-6 col-lg-4 col-xl-3">
      <div class="card border-0 shadow-sm h-100 product-card">
        <div class="position-relative">
            <img src="{{ $p->image_path ? Storage::url($p->image_path) : 'https://via.placeholder.com/600x400?text=No+Image' }}" 
                 class="card-img-top" 
                 style="height: 200px; object-fit: cover;" 
                 alt="{{ $p->name }}">
            
            <div class="position-absolute top-0 end-0 p-2">
                @if($p->status === 'active')
                    <span class="badge bg-success shadow-sm">Active</span>
                @else
                    <span class="badge bg-secondary shadow-sm">Inactive</span>
                @endif
            </div>
        </div>

        <div class="card-body d-flex flex-column">
          <h5 class="card-title fw-bold text-truncate" title="{{ $p->name }}">{{ $p->name }}</h5>
          
          <div class="mb-2 text-primary fw-bold">
            Rp {{ number_format($p->price, 0, ',', '.') }}
          </div>

          <div class="small text-muted mb-3 border-top pt-2 mt-auto">
            <div class="d-flex justify-content-between mb-1">
                <span><i class="bi bi-shop me-1"></i> Seller:</span>
                <span class="fw-semibold text-truncate" style="max-width: 100px;">{{ $p->seller->name ?? '-' }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span><i class="bi bi-box-seam me-1"></i> Stok:</span>
                <span class="fw-semibold">{{ $p->stock }} item</span>
            </div>
          </div>

          <div class="d-grid gap-2">
             <form method="POST" action="{{ route('admin.products.toggle', $p->id) }}">
                @csrf
                <button class="btn btn-sm w-100 {{ $p->status==='active' ? 'btn-outline-secondary' : 'btn-outline-success' }}" type="submit">
                   {{ $p->status==='active' ? 'Nonaktifkan' : 'Aktifkan Produk' }}
                </button>
             </form>
             
             <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}" 
                   onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger w-100" type="submit">
                    <i class="bi bi-trash"></i> Hapus
                </button>
             </form>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm py-5 text-center">
            <div class="text-muted">
                <i class="bi bi-box-seam fs-1 d-block mb-3"></i>
                Tidak ada produk yang ditemukan sesuai filter.
            </div>
        </div>
    </div>
  @endforelse
</div>

<div class="mt-4">
  {{ $products->links() }}
</div>
@endsection