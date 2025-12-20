@extends('layouts.storefront')
@section('title', 'Produk')
@section('content')
  <h2 class="fw-bold mb-4">Daftar Produk</h2>

  <div class="row g-4">
    @foreach ($products as $p)
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          <img class="card-img-top"
               src="{{ $p->image_path ? asset('storage/'.$p->image_path) : asset('assets/img/placeholder-600x400.png') }}"
               alt="{{ $p->name }}">
          <div class="card-body text-center">
            <h5 class="card-title">{{ $p->name }}</h5>
            <p class="text-muted mb-2">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
            <a class="btn btn-outline-primary" href="{{ route('products.show', $p->slug) }}">Lihat Detail</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-4">
    {{ $products->links() }}
  </div>
@endsection
