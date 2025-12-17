@extends('layouts.storefront')
@section('title', 'Home')
@section('content')
  <!-- Hero -->
  <section id="tentang" class="hero-section text-center text-md-start d-flex align-items-center">
    <div class="container py-5">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h1 class="fw-bold display-5 mb-3">Temukan <span class="text-primary">Gaya Fashion</span> Terbaikmu</h1>
          <p class="text-muted">Outfitly adalah platform e-commerce fashion yang menyediakan pakaian, sepatu, dan aksesoris stylish dengan kualitas premium.</p>
          <form class="d-flex mt-4" id="searchForm" method="GET" action="{{ url('/') }}">
            <input class="form-control me-2" type="search" name="q" placeholder="Cari produk fashion..." id="searchInput">
            <button class="btn btn-primary" type="submit">Cari</button>
          </form>
        </div>
        <div class="col-md-6 text-center">
          <img style="border-radius: 50%;" src="{{ asset('assets/img/outfitly.png') }}" alt="fashion" class="img-fluid" width="400">
        </div>
      </div>
    </div>
  </section>

  <!-- Produk -->
  <section class="container py-5" id="produk"> <!-- Added id="produk" for linking -->
    <h2 class="text-center fw-bold mb-4">Produk Unggulan</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <img src="{{ asset('assets/img/kemeja-pria.jpeg') }}" class="card-img-top" alt="produk 1">
          <div class="card-body text-center">
            <h5 class="card-title">Kemeja Pria</h5>
            <p class="card-text text-muted">Rp199.000</p>
            <a class="btn btn-outline-primary" href="{{ route('maintenance') }}">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm">
          <img src="{{ asset('assets/img/dress-wanita.jpeg') }}" class="card-img-top" alt="produk 2">
          <div class="card-body text-center">
            <h5 class="card-title">Dress Wanita</h5>
            <p class="card-text text-muted">Rp249.000</p>
            <a class="btn btn-outline-primary" href="{{ route('maintenance') }}">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm">
          <img src="{{ asset('assets/img/sneakers.jpeg') }}" class="card-img-top" alt="produk 3">
          <div class="card-body text-center">
            <h5 class="card-title">Sneakers</h5>
            <p class="card-text text-muted">Rp299.000</p>
            <a class="btn btn-outline-primary" href="{{ route('maintenance') }}">Lihat Detail</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Kontak & Alamat -->
  <section id="kontakAlamat" class="contact-section bg-light py-5">
    <div class="container text-center">
      <h2 class="fw-bold mb-4">Kontak & Alamat</h2>
      <p class="text-muted">Hubungi kami untuk pertanyaan atau kerja sama</p>
      <p>📞 0812-3456-7890 | ✉️ outfitlyofficial@gmail.com</p>
      <p>📍 Jl. Halimun Setia Budi, Jakarta Selatan</p>
    </div>
  </section>

  <footer class="text-center py-3 bg-primary text-white">
    &copy; 2025 Outfitly Official. All Rights Reserved.
  </footer>
@endsection