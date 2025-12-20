<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="fw-bold mb-3">Manajemen User</h2>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form method="GET" class="card shadow-sm mb-3">
    <div class="card-body">
      <div class="row g-2">
        <div class="col-md-5">
          <label class="form-label">Search</label>
          <input class="form-control" name="search" value="{{ request('search') }}" placeholder="name/email">
        </div>
        <div class="col-md-3">
          <label class="form-label">Role</label>
          <select class="form-select" name="role">
            <option value="">(all)</option>
            @foreach (['customer','seller','admin'] as $r)
              <option value="{{ $r }}" @selected(request('role')===$r)>{{ $r }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Active</label>
          <select class="form-select" name="active">
            <option value="">(all)</option>
            <option value="1" @selected(request('active')==='1')>active</option>
            <option value="0" @selected(request('active')==='0')>suspended</option>
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-2">
          <button class="btn btn-primary w-100" type="submit">Filter</button>
          <a class="btn btn-outline-secondary w-100" href="{{ route('admin.users.index') }}">Reset</a>
        </div>
      </div>
    </div>
  </form>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table mb-0 align-middle">
        <thead>
          <tr>
            <th style="width:80px;">ID</th>
            <th>User</th>
            <th style="width:120px;">Role</th>
            <th style="width:140px;">Status</th>
            <th style="width:140px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $u)
            <tr>
              <td>#{{ $u->id }}</td>
              <td>
                <div class="fw-semibold">{{ $u->name }}</div>
                <div class="small text-muted">{{ $u->email }}</div>
              </td>
              <td><span class="badge text-bg-secondary">{{ $u->role }}</span></td>
              <td>
                @if ($u->is_active)
                  <span class="badge text-bg-success">active</span>
                @else
                  <span class="badge text-bg-danger">suspended</span>
                @endif
              </td>
              <td>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.users.edit', $u->id) }}">Edit</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    {{ $users->links() }}
  </div>
</div>

</body>
</html>
