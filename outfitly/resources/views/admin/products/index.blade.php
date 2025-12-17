<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@php use Illuminate\Support\Facades\Storage; @endphp

<div class="container py-5">
  <h2 class="fw-bold mb-3">Manajemen Produk (Semua Penjual)</h2>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form method="GET" class="card shadow-sm mb-3">
    <div class="card-body">
      <div class="row g-2">
        <div class="col-md-4">
          <label class="form-label">Search</label>
          <input class="form-control" name="search" value="{{ request('search') }}" placeholder="name/slug">
        </div>
        <div class="col-md-3">
          <label class="form-label">Seller</label>
          <input class="form-control" name="seller" value="{{ request('seller') }}" placeholder="name/email">
        </div>
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select class="form-select" name="status">
            <option value="">(all)</option>
            <option value="active" @selected(request('status')==='active')>active</option>
            <option value="inactive" @selected(request('status')==='inactive')>inactive</option>
          </select>
        </div>
        <div class="col-md-3 d-flex align-items-end gap-2">
          <button class="btn btn-primary w-100" type="submit">Filter</button>
          <a class="btn btn-outline-secondary w-100" href="{{ route('admin.products.index') }}">Reset</a>
        </div>
      </div>
    </div>
  </form>

  <div class="row g-3">
    @forelse ($products as $p)
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          <img class="card-img-top" style="height:200px; object-fit:cover;"
               src="{{ $p->image_path ? Storage::url($p->image_path) : 'https://via.placeholder.com/600x400' }}">

          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div class="fw-bold">{{ $p->name }}</div>
              <span class="badge text-bg-{{ $p->status==='active' ? 'success' : 'secondary' }}">
                {{ $p->status }}
              </span>
            </div>

            <div class="text-muted small mt-1">
              Seller: {{ $p->seller->name ?? '-' }}
            </div>

            <div class="mt-2">
              <div>Rp {{ number_format($p->price, 0, ',', '.') }}</div>
              <div class="small text-muted">Stock: {{ $p->stock }}</div>
            </div>

            <div class="mt-3 d-flex gap-2">
              <form method="POST" action="{{ route('admin.products.toggle', $p->id) }}">
                @csrf
                <button class="btn btn-sm btn-outline-primary" type="submit">
                  {{ $p->status==='active' ? 'Deactivate' : 'Activate' }}
                </button>
              </form>

              <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}"
                    onsubmit="return confirm('Hapus produk ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
              </form>
            </div>

          </div>
        </div>
      </div>
    @empty
      <div class="text-muted">Tidak ada produk.</div>
    @endforelse
  </div>

  <div class="mt-3">
    {{ $products->links() }}
  </div>
</div>

</body>
</html>
