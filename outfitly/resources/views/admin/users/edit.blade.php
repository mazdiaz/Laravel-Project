<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 720px;">
  <a href="{{ route('admin.users.index') }}">&larr; Kembali</a>

  <h2 class="fw-bold mt-3 mb-3">Edit User #{{ $user->id }}</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow-sm">
    <div class="card-body p-4">
      <div class="mb-3">
        <div class="text-muted small">Name</div>
        <div class="fw-semibold">{{ $user->name }}</div>
      </div>
      <div class="mb-3">
        <div class="text-muted small">Email</div>
        <div class="fw-semibold">{{ $user->email }}</div>
      </div>

      <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Role</label>
            <select class="form-select" name="role" required>
              @foreach (['customer','seller','admin'] as $r)
                <option value="{{ $r }}" @selected(old('role', $user->role)===$r)>{{ $r }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Status</label>
            <select class="form-select" name="is_active" required>
              <option value="1" @selected((string)old('is_active', (int)$user->is_active)==='1')>active</option>
              <option value="0" @selected((string)old('is_active', (int)$user->is_active)==='0')>suspended</option>
            </select>
          </div>
        </div>

        <div class="mt-4 d-flex gap-2">
          <button class="btn btn-primary" type="submit">Save</button>
          <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
