@extends('layouts.seller')
@section('title', 'Daftar Produk')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
      <h5 class="m-0 seller-title">Daftar Produk</h5>
      <div class="text-muted small">Kelola produk yang tampil di toko kamu.</div>
    </div>

    <a class="btn btn-orange" href="{{ route('seller.products.create') }}">
      <i class="bi bi-plus-lg me-1"></i> Tambah Produk
    </a>
  </div>

  <div class="card-like">
    {{-- Filters --}}
    <form method="GET" action="{{ route('seller.products.index') }}" class="row g-2 align-items-end mb-3">
      <div class="col-12 col-md-5">
        <label class="form-label small text-muted mb-1">Pencarian</label>
        <input type="text" name="q" class="form-control" placeholder="Nama / slug..."
               value="{{ $search ?? '' }}">
      </div>

      <div class="col-6 col-md-3">
        <label class="form-label small text-muted mb-1">Status</label>
        <select name="status" class="form-select">
          <option value="">Semua</option>
          <option value="active"   @selected(($status ?? '')==='active')>Active</option>
          <option value="inactive" @selected(($status ?? '')==='inactive')>Inactive</option>
          <option value="draft"    @selected(($status ?? '')==='draft')>Draft</option>
        </select>
      </div>

      <div class="col-6 col-md-3">
        <label class="form-label small text-muted mb-1">Urutan</label>
        <select name="sort" class="form-select">
          <option value="latest"     @selected(($sort ?? 'latest')==='latest')>Terbaru</option>
          <option value="oldest"     @selected(($sort ?? '')==='oldest')>Terlama</option>
          <option value="name_asc"   @selected(($sort ?? '')==='name_asc')>Nama A-Z</option>
          <option value="name_desc"  @selected(($sort ?? '')==='name_desc')>Nama Z-A</option>
          <option value="stock_asc"  @selected(($sort ?? '')==='stock_asc')>Stok Terendah</option>
          <option value="stock_desc" @selected(($sort ?? '')==='stock_desc')>Stok Tertinggi</option>
          <option value="price_asc"  @selected(($sort ?? '')==='price_asc')>Harga Terendah</option>
          <option value="price_desc" @selected(($sort ?? '')==='price_desc')>Harga Tertinggi</option>
        </select>
      </div>

      <div class="col-12 col-md-1 d-grid">
        <button class="btn btn-primary" type="submit">Go</button>
      </div>
    </form>

    {{-- Table --}}
    <div class="table-responsive">
      <table class="table align-middle table-hover mb-0">
        <thead>
          <tr class="small text-muted">
            <th style="width:72px;">Gambar</th>
            <th>Nama</th>
            <th style="width:140px;">SKU</th>
            <th style="width:140px;" class="text-end">Harga</th>
            <th style="width:90px;" class="text-end">Stok</th>
            <th style="width:120px;">Status</th>
            <th style="width:120px;">Diperbarui</th>
            <th style="width:90px;" class="text-end">Aksi</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($products as $p)
            @php
              $img = $p->image_path ? asset('storage/'.$p->image_path) : 'https://via.placeholder.com/120';
              $badge = match($p->status) {
                'active' => 'text-bg-success',
                'inactive' => 'text-bg-secondary',
                'draft' => 'text-bg-warning',
                default => 'text-bg-secondary',
              };
              $sku = $p->sku ?? ('SKU-'.$p->id); // if you don't have sku column yet
            @endphp

            <tr>
              <td>
                <img src="{{ $img }}" alt="{{ $p->name }}"
                     style="width:56px;height:56px;object-fit:cover;border-radius:12px;border:1px solid rgba(0,0,0,.08);">
              </td>

              <td>
                <div class="fw-semibold">{{ $p->name }}</div>
                <div class="small text-muted">{{ $p->slug }}</div>
              </td>

              <td class="small">{{ $sku }}</td>

              <td class="text-end">Rp {{ number_format($p->price, 0, ',', '.') }}</td>

              <td class="text-end fw-semibold">{{ $p->stock }}</td>

              <td>
                <span class="badge {{ $badge }}">{{ $p->status }}</span>
              </td>

              <td class="small text-muted">
                {{ optional($p->updated_at)->format('Y-m-d') }}
              </td>

              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('seller.products.edit', $p) }}" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>

                <form method="POST" action="{{ route('seller.products.destroy', $p) }}"
                      class="d-inline"
                      onsubmit="return confirm('Hapus produk ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" type="submit" title="Hapus">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-muted py-4">
                Belum ada produk.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $products->links() }}
    </div>
  </div>
@endsection
