@extends('layouts.admin')

@section('title', 'Tambah User Baru')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-6 col-md-8">
      
    <div class="mb-3">
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left"></i> Kembali ke List User
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h4 class="fw-bold mb-0">Tambah User Baru</h4>
            <p class="text-muted small">Buat akun untuk Seller, Customer, atau Admin.</p>
        </div>
        <div class="card-body p-4">
            
            @if ($errors->any())
                <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Penjual A">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="penjual1@outfitly.test">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" class="form-control" name="password" required placeholder="Minimal 8 karakter">
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="seller" @selected(old('role') == 'seller')>Seller</option>
                            <option value="admin" @selected(old('role') == 'admin')>Admin</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Awal</label>
                        <select class="form-select" name="is_active" required>
                            <option value="1" @selected(old('is_active') == '1')>Active</option>
                            <option value="0" @selected(old('is_active') == '0')>Suspended</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-primary" type="submit">Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection