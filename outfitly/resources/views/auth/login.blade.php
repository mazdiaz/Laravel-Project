@extends('layouts.app')
@section('title', 'Login')

@php($hideSearch = true)

@section('content')
<div class="container-xl py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card-like p-4">
        <h4 class="fw-bold mb-1">Login</h4>
        <div class="text-muted small mb-3">Masuk untuk melanjutkan.</div>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" required>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <label class="small text-muted d-flex align-items-center gap-2 m-0">
              <input type="checkbox" name="remember"> Remember me
            </label>
            <a class="small" href="{{ route('landing') }}">Back</a>
          </div>

          <button class="btn btn-primary w-100" type="submit">Login</button>

          <div class="text-center small text-muted mt-3">
            Belum punya akun? <a href="{{ route('register') }}">Register</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
