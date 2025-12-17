@extends('layouts.app')

@section('title', 'Maintenance')

@push('styles')
  <style>
    .maintenance-page { background: #F5F0E6; display:flex; align-items:center; justify-content:center; min-height:60vh; text-align:center; padding:4rem 0 }
    .maintenance-page h1 { color:#0E2A47; font-weight:800 }
    .maintenance-page p { color:#555; font-size:1.1rem }
    .btn-home { margin-top:20px; background:#E94E1B; color:#fff; font-weight:600; border-radius:12px; padding:10px 20px; text-decoration:none }
  </style>
@endpush

@section('content')
  <div class="maintenance-page">
    <div>
      <img src="https://cdn-icons-png.flaticon.com/512/2965/2965358.png" width="120" alt="Maintenance Icon">
      <h1>Halaman Sedang Dalam Maintenance</h1>
      <p>Developer kami belum selesai<br>Silakan kembali lagi nanti!</p>
      <a href="{{ url()->previous() }}" class="btn-home">Kembali</a>
    </div>
  </div>
@endsection
