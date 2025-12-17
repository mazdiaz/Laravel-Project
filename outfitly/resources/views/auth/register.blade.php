@extends('layouts.app')
@section('title', 'Register')

@php($hideSearch = true)

@section('content')
<div class="container-xl py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card-like p-4">
        <h4 class="fw-bold mb-1">Register</h4>
        <div class="text-muted small mb-3">Buat akun baru untuk mulai belanja.</div>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input class="form-control" name="name" value="{{ old('name') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-md-6">
              <label class="form-label">Password</label>
              <input class="form-control" type="password" name="password" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Konfirmasi Password</label>
              <input class="form-control" type="password" name="password_confirmation" required>
            </div>
          </div>

          <button class="btn btn-primary w-100" type="submit">Register</button>

          <div class="text-center small text-muted mt-3">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
