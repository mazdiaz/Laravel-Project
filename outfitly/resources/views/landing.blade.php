@extends('layouts.storefront')
@section('title', 'Home')
@section('content')



      <!-- Hero Carousel Full Image Only -->
      <div class="container text-center position-relative">
      <h1 class="fw-bold display-5 mb-3">Best Collections<span class="text-danger"> Here!</span></h1><br />
     
<section class="hero-full-image position-relative">
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000">
    <!-- Indicators (titik-titik bawah) -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="4"></button>
    </div>

    <div class="carousel-inner">
      <!-- Slide 1 -->
      <div class="carousel-item active">
        <img src="{{ asset('assets/img/pict 1.png') }}" class="d-block w-100" alt="Fashion Promo 1">
      </div>
      <!-- Slide 2 -->
      <div class="carousel-item">
        <img src="{{ asset('assets/img/pict 2.png') }}" class="d-block w-100">
      </div>
      <!-- Slide 3 -->
      <div class="carousel-item">
        <img src="{{ asset('assets/img/pict 3.png') }}" class="d-block w-100">
      </div>
      <!-- Slide 4 -->
      <div class="carousel-item">
        <img src="{{ asset('assets/img/pict 4.png') }}" class="d-block w-100">
      </div>
      <!-- Slide 5 -->
      <div class="carousel-item">
        <img src="{{ asset('assets/img/pict 5.png') }}" class="d-block w-100">
      </div>
    </div>

    <!-- Controls (panah kiri-kanan besar semi-transparan) -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>

  <!-- Hero -->
  <section id="tentang" class="hero-section text-center text-md-start d-flex align-items-center">
    <div class="container py-5">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h1 class="fw-bold display-5 mb-3">Temukan <span class="text-danger">Gaya Fashion</span> Terbaikmu</h1>
          <p class="text-muted">Outfitly adalah platform e-commerce fashion yang menyediakan pakaian, sepatu, dan aksesoris stylish dengan kualitas premium.</p>
          <form class="d-flex mt-4" id="searchForm" method="GET" action="{{ url('/') }}">
            <input class="form-control me-2" type="search" name="q" placeholder="Cari produk fashion..." id="searchInput">
            <button class="btn btn-danger" type="submit">Cari</button>
          </form>
        </div>
        <div class="col-md-6 text-center">
          <img style="border-radius: 50%;" src="{{ asset('assets/img/logo.png') }}" alt="fashion" class="img-fluid" width="400">
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
          <img src="{{ asset('assets/img/pict 6.png') }}" class="card-img-top" alt="produk 1">
          <div class="card-body text-center">
            <h5 class="card-title">Dress Wanita</h5>
            <p class="card-text text-muted">Rp324.000</p>
            <a class="btn btn-outline-primary" href="{{ route('maintenance') }}">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm">
          <img src="{{ asset('assets/img/pict 7.png') }}" class="card-img-top" alt="produk 2">
          <div class="card-body text-center">
            <h5 class="card-title">Kemeja Pria</h5>
            <p class="card-text text-muted">Rp249.000</p>
            <a class="btn btn-outline-primary" href="{{ route('maintenance') }}">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm">
          <img src="{{ asset('assets/img/pict 8.png') }}" class="card-img-top" alt="produk 3">
          <div class="card-body text-center">
            <h5 class="card-title">Boots Unisex</h5>
            <p class="card-text text-muted">Rp2.310.000</p>
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