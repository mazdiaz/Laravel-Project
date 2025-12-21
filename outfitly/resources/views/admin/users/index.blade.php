@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Manajemen User</h2>
    {{-- TOMBOL TAMBAH USER BARU --}}
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah User
    </a>
</div>

{{-- Pesan Error/Success --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="card border-0 shadow-sm mb-4">
  <div class="card-body bg-white rounded">
    <form method="GET" action="{{ route('admin.users.index') }}">
      <div class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label small text-muted">Pencarian</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control border-start-0" name="search" 
                   value="{{ request('search') }}" placeholder="Nama atau email...">
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label small text-muted">Role</label>
          <select class="form-select" name="role">
            <option value="">Semua Role</option>
            @foreach (['customer','seller','admin'] as $r)
              <option value="{{ $r }}" @selected(request('role')===$r)>{{ ucfirst($r) }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label small text-muted">Status</label>
          <select class="form-select" name="active">
            <option value="">Semua Status</option>
            <option value="1" @selected(request('active')==='1')>Active Only</option>
            <option value="0" @selected(request('active')==='0')>Suspended Only</option>
          </select>
        </div>
        <div class="col-md-2">
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Filter</button>
                @if(request()->anyFilled(['search', 'role', 'active']))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-link text-decoration-none text-muted">Reset</a>
                @endif
            </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-secondary">
          <tr>
            <th class="ps-4" style="width:60px;">ID</th>
            <th>Pengguna</th>
            <th>Role</th>
            <th>Status</th>
            <th class="text-end pe-4">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $u)
            <tr>
              <td class="ps-4 text-muted">#{{ $u->id }}</td>
              <td>
                <div class="d-flex align-items-center">
                    <div class="avatar me-2 rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; font-weight: bold;">
                        {{ substr($u->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="fw-bold text-dark">{{ $u->name }}</div>
                        <div class="small text-muted">{{ $u->email }}</div>
                    </div>
                </div>
              </td>
              <td>
                @php
                    $roleColors = ['admin' => 'danger', 'seller' => 'info', 'customer' => 'secondary'];
                    $color = $roleColors[$u->role] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} px-3 py-2 rounded-pill">
                    {{ ucfirst($u->role) }}
                </span>
              </td>
              <td>
                @if ($u->is_active)
                  <span class="badge bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                @else
                  <span class="badge bg-danger bg-opacity-10 text-danger"><i class="bi bi-x-circle me-1"></i> Suspended</span>
                @endif
              </td>
              <td class="text-end pe-4">
                <div class="d-flex justify-content-end gap-2">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.users.edit', $u->id) }}">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    
                    {{-- TOMBOL DELETE --}}
                    @if(auth()->id() !== $u->id)
                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini secara permanen? Data transaksi terkait mungkin akan error jika tidak dihandle.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Data user tidak ditemukan.
                </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($users->hasPages())
  <div class="card-footer bg-white border-0 py-3">
    {{ $users->links() }}
  </div>
  @endif
</div>
@endsection