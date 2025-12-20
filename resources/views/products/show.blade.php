@extends('layouts.storefront')

@section('title', $product->name)

@section('content')
  <div class="py-2">
    <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">&larr; Kembali</a>

    <div class="card shadow-sm mt-3">
      <div class="row g-0">
        <div class="col-md-5">
          <img class="img-fluid"
               src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://via.placeholder.com/600x400' }}"
               alt="{{ $product->name }}">
        </div>
        <div class="col-md-7">
          <div class="card-body">
            <h3 class="fw-bold">{{ $product->name }}</h3>
            <p class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p>{{ $product->description }}</p>
            <p class="small text-muted">Stok: {{ $product->stock }}</p>

            @auth
              @if (auth()->user()->role === 'customer')
                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                  @csrf
                  <button class="btn btn-primary mb-3" type="submit">Tambah ke Keranjang</button>
                </form>
              @endif
            @endauth
          </div>
        </div>
      </div>
    </div>

    <hr class="my-4">

    <h4 class="fw-bold mb-3">Ulasan Produk</h4>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
      </div>
    @endif

    @php $avg = $product->reviews->avg('rating'); @endphp

    <div class="mb-3">
      <span class="fw-semibold">Rating rata-rata:</span>
      <span>{{ $avg ? number_format($avg, 1) : '-' }}/5</span>
      <span class="text-muted">({{ $product->reviews->count() }} ulasan)</span>
    </div>

    @auth
      @if (auth()->user()->role === 'customer' && $canReview)
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <form method="POST" action="{{ route('reviews.store', $product->id) }}">
              @csrf
              <div class="row g-2 align-items-end">
                <div class="col-md-3">
                  <label class="form-label">Rating</label>
                  <select class="form-select" name="rating" required>
                    @for ($i = 5; $i >= 1; $i--)
                      <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                  </select>
                </div>
                <div class="col-md-9">
                  <label class="form-label">Komentar (opsional)</label>
                  <input class="form-control" name="comment" value="{{ old('comment') }}" placeholder="Tulis ulasan singkat...">
                </div>
              </div>

              <button class="btn btn-primary mt-3" type="submit">Kirim Ulasan</button>
              <div class="small text-muted mt-2">*Hanya pembeli yang pernah checkout produk ini yang bisa memberi ulasan.</div>
            </form>
          </div>
        </div>
      @else
        <div class="alert alert-info">Hanya pembeli yang telah membeli produk ini yang dapat memberikan ulasan.</div>
      @endif
    @endauth

    @if ($product->reviews->isEmpty())
      <div class="text-muted">Belum ada ulasan.</div>
    @else
      @foreach ($product->reviews->sortByDesc('created_at') as $r)
        <div class="card shadow-sm mb-2">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div class="fw-semibold">{{ $r->user->name ?? 'User' }}</div>
              <div class="badge bg-secondary">{{ $r->rating }}/5</div>
            </div>
            @if ($r->comment)
              <div class="mt-2">{{ $r->comment }}</div>
            @endif
            <div class="small text-muted mt-2">{{ $r->created_at->format('Y-m-d H:i') }}</div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
@endsection
