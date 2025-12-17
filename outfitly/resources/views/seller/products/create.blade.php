@extends('layouts.seller')
@section('title', 'Tambah Produk')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
      <h5 class="m-0 seller-title">Tambah Produk</h5>
      <div class="text-muted small">Isi data produk dan upload foto (opsional).</div>
    </div>

    <a href="{{ route('seller.products.index') }}" class="btn btn-outline-primary">
      <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <div class="fw-semibold mb-1">Periksa input:</div>
      <ul class="mb-0">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row g-3">
      {{-- LEFT: FORM --}}
      <div class="col-12 col-lg-8">
        <div class="card-like p-3">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Nama Produk</label>
              <input type="text" name="name" class="form-control"
                     value="{{ old('name') }}" placeholder="Contoh: Hoodie abu" required>
            </div>

            <div class="col-12">
              <label class="form-label">Deskripsi</label>
              <textarea name="description" class="form-control" rows="5"
                        placeholder="Deskripsi singkat produk...">{{ old('description') }}</textarea>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label">Harga (Rp)</label>
              <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" name="price" class="form-control"
                       value="{{ old('price', 0) }}" min="0" step="1" required>
              </div>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label">Stok</label>
              <input type="number" name="stock" class="form-control"
                     value="{{ old('stock', 0) }}" min="0" step="1" required>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="active" {{ old('status','active')==='active' ? 'selected' : '' }}>active</option>
                <option value="inactive" {{ old('status')==='inactive' ? 'selected' : '' }}>inactive</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Gambar Produk</label>
              <input type="file" name="image" class="form-control" id="imageInput" accept="image/*">
              <div class="small text-muted mt-1">JPG/PNG/WEBP, maks 2MB.</div>
            </div>
          </div>

          <div class="d-flex gap-2 mt-3">
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-check2-circle me-1"></i> Simpan
            </button>
            <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary">
              Batal
            </a>
          </div>
        </div>
      </div>

      {{-- RIGHT: PREVIEW --}}
      <div class="col-12 col-lg-4">
        <div class="card-like p-3">
          <div class="fw-semibold mb-2" style="color:var(--navyText)">Preview Foto</div>

          <div class="border rounded-4 d-flex align-items-center justify-content-center"
               style="height:220px; background:#fafafa; overflow:hidden;">
            <img id="imagePreview" alt="Preview"
                 style="width:100%;height:100%;object-fit:cover;display:none;">
            <div id="imagePlaceholder" class="text-muted small px-3 text-center">
              Pilih gambar untuk melihat preview.
            </div>
          </div>

          <hr class="my-3">

          <div class="small text-muted">
            Tips:
            <ul class="mb-0 mt-1">
              <li>Pakai foto yang terang dan fokus.</li>
              <li>Rasio 4:3 / 1:1 biasanya rapi di katalog.</li>
              <li>Pastikan stok & harga benar sebelum simpan.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@push('scripts')
<script>
  const input = document.getElementById('imageInput');
  const img = document.getElementById('imagePreview');
  const placeholder = document.getElementById('imagePlaceholder');

  if (input) {
    input.addEventListener('change', (e) => {
      const file = e.target.files && e.target.files[0];
      if (!file) {
        img.style.display = 'none';
        placeholder.style.display = 'block';
        img.src = '';
        return;
      }
      const url = URL.createObjectURL(file);
      img.src = url;
      img.style.display = 'block';
      placeholder.style.display = 'none';
    });
  }
</script>
@endpush
