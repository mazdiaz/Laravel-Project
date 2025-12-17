@extends('layouts.seller')
@section('title', 'Pengaturan Toko')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
      <h4 class="m-0 fw-bold">Pengaturan Toko</h4>
      <div class="text-muted small">Kelola profil penjual & kontak.</div>
    </div>
  </div>

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

 @php
  $avatarPath = $user->avatar_path;
  $avatarUrl  = $avatarPath ? \Illuminate\Support\Facades\Storage::url($avatarPath) : null;
 @endphp


  <div class="card shadow-sm">
    <div class="card-body p-4">

      <div class="d-flex align-items-center gap-3 mb-4">
        <div style="width:64px;height:64px;border-radius:16px;overflow:hidden;border:1px solid #e5e7eb;background:#f3f4f6;display:grid;place-items:center;">
            @if($avatarUrl)
                <img src="{{ $avatarUrl }}?v={{ optional($user->updated_at)->timestamp }}"
                    alt="Foto Profil"
                    style="width:100%;height:100%;object-fit:cover;display:block;">
            @else
                <i class="bi bi-person text-muted" style="font-size:28px;"></i>
            @endif
        </div>

        <div>
          <div class="fw-bold">{{ $user->name }}</div>
          <div class="text-muted small">{{ $user->email }}</div>
          <span class="badge text-bg-secondary">{{ $user->role }}</span>
        </div>
      </div>

      <form method="POST" action="{{ route('seller.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label">Foto Profil</label>
          <input class="form-control" type="file" name="photo" accept=".jpg,.jpeg,.png,.webp">
          <div class="text-muted small mt-1">JPG/PNG/WEBP, max 2MB.</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">No HP</label>
          <input class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="0812xxxx">
        </div>

        <div class="mb-3">
          <label class="form-label">Alamat</label>
          <textarea class="form-control" name="address" rows="4" placeholder="Alamat lengkap">{{ old('address', $user->address) }}</textarea>
        </div>

        <button class="btn btn-primary" type="submit">Simpan</button>
      </form>
    </div>
  </div>
@endsection
