@extends('layouts.customer') {{-- or layouts.panel if you want shared --}}
@section('title', 'Profil')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp

<div class="card-like p-4" style="max-width:820px;">
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

  <div class="d-flex align-items-center gap-3 mb-4">
    <div style="width:72px;height:72px;border-radius:16px;overflow:hidden;background:#eee;display:flex;align-items:center;justify-content:center;">
      @if ($user->avatar_path)
        <img src="{{ Storage::url($user->avatar_path) }}" style="width:100%;height:100%;object-fit:cover;">
      @else
        <span class="fw-bold">{{ strtoupper(substr($user->name,0,1)) }}</span>
      @endif
    </div>
    <div>
      <div class="fw-bold">{{ $user->name }}</div>
      <div class="text-muted small">{{ $user->email }}</div>
      <span class="badge text-bg-secondary">{{ $user->role }}</span>
    </div>
  </div>

  <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Foto Profil</label>
      <input class="form-control" type="file" name="avatar" accept="image/*">
      <div class="small text-muted mt-1">JPG/PNG/WEBP, max 2MB.</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">No HP</label>
      <input class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
    </div>

    <div class="mb-3">
      <label class="form-label">Alamat</label>
      <textarea class="form-control" name="address" rows="4">{{ old('address', $user->address) }}</textarea>
    </div>

    <button class="btn btn-primary" type="submit">Simpan</button>
  </form>
</div>
@endsection
