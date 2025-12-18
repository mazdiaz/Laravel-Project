@extends('layouts.admin')

@section('title', 'Edit User')

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
            <h4 class="fw-bold mb-0">Edit User #{{ $user->id }}</h4>
        </div>
        <div class="card-body p-4">
            
            @if ($errors->any())
                <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
                </div>
            @endif

            <div class="row mb-4 g-3">
                <div class="col-md-6">
                    <label class="small text-muted text-uppercase fw-bold">Nama Lengkap</label>
                    <div class="fs-5">{{ $user->name }}</div>
                </div>
                <div class="col-md-6">
                    <label class="small text-muted text-uppercase fw-bold">Email Address</label>
                    <div class="fs-5">{{ $user->email }}</div>
                </div>
            </div>

            <hr class="text-muted opacity-25 mb-4">

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-semibold">Role Akses</label>
                    <select class="form-select form-select-lg" name="role" required>
                        @foreach (['customer','seller','admin'] as $r)
                        <option value="{{ $r }}" @selected(old('role', $user->role)===$r)>
                            {{ ucfirst($r) }}
                        </option>
                        @endforeach
                    </select>
                    <div class="form-text">Peran menentukan fitur apa yang bisa diakses user ini.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Status Akun</label>
                    <select class="form-select form-select-lg" name="is_active" required>
                        <option value="1" @selected((string)old('is_active', (int)$user->is_active)==='1')>Active (Bisa Login)</option>
                        <option value="0" @selected((string)old('is_active', (int)$user->is_active)==='0')>Suspended (Dilarang Login)</option>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection