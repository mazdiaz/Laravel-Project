{{-- resources/views/seller/products/edit.blade.php --}}
@extends('layouts.seller')
@section('title', 'Edit Produk')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
      <h4 class="m-0 fw-bold">Edit Produk</h4>
      <div class="text-muted small">Perbarui detail produk dan gambar.</div>
    </div>

    <a class="btn btn-outline-secondary" href="{{ route('seller.products.index') }}">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @php
    $imgUrl = $product->image_path
      ? \Illuminate\Support\Facades\Storage::url($product->image_path)
      : asset('assets/img/placeholder-600x400.png');
  @endphp

  <form method="POST"
        action="{{ route('seller.products.update', $product->id) }}"
        enctype="multipart/form-data"
        class="card shadow-sm border-0">
    @csrf
    @method('PUT')

    <div class="card-body p-4">
      <div class="row g-4">
        {{-- LEFT: fields --}}
        <div class="col-12 col-lg-8">
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
          </div>

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Harga (Rp)</label>
              <input class="form-control" name="price" type="number" min="0"
                     value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Stok</label>
              <input class="form-control" name="stock" type="number" min="0"
                     value="{{ old('stock', $product->stock) }}" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Status</label>
              <select class="form-select" name="status" required>
                <option value="active" @selected(old('status', $product->status) === 'active')>active</option>
                <option value="inactive" @selected(old('status', $product->status) === 'inactive')>inactive</option>
              </select>
            </div>
          </div>
        </div>

        {{-- RIGHT: image --}}
        <div class="col-12 col-lg-4">
          <div class="border rounded-4 p-3 bg-white">
            <div class="fw-semibold mb-2">Gambar Produk</div>

            <div class="ratio ratio-4x3 rounded-4 overflow-hidden border bg-light">
              <img id="imgPreview"
                   src="{{ $imgUrl }}?v={{ optional($product->updated_at)->timestamp }}"
                   alt="Gambar Produk"
                   style="width:100%;height:100%;object-fit:cover;display:block;">
            </div>

            <div class="mt-3">
              <label class="form-label">Upload baru (opsional)</label>
              <input class="form-control" type="file" name="image" accept="image/*">
              <div class="text-muted small mt-1">JPG/PNG/WEBP disarankan.</div>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <div class="d-flex gap-2">
        <button class="btn btn-primary" type="submit">
          <i class="bi bi-save"></i> Update
        </button>
        <a class="btn btn-outline-secondary" href="{{ route('seller.products.index') }}">Batal</a>
      </div>
    </div>
  </form>
@endsection

@push('scripts')
<script>
  const input = document.querySelector('input[name="image"]');
  const img = document.getElementById('imgPreview');

  if (input && img) {
    input.addEventListener('change', (e) => {
      const file = e.target.files?.[0];
      if (!file) return;
      img.src = URL.createObjectURL(file);
    });
  }
</script>
@endpush
