<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin</title>

  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}" />
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- If you need FontAwesome, prefer the CDN CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <div class="admin-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo">AdminPanel</h2>
      <ul class="menu">
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
        </li>
        <li><a href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users"></i> Manajemen User</a></li>
        <li><a href="{{ route('admin.products.index') }}"><i class="fa-solid fa-box"></i> Manajemen Produk</a></li>
        <li><a href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-file-invoice-dollar"></i> Manajemen Transaksi</a></li>
        <li><a href="{{ route('admin.reports.monthly') }}"><i class="fa-solid fa-chart-column"></i> Laporan Bulanan</a></li>
      </ul>
    </aside>

    <!-- Main -->
    <main class="main-content">
      <!-- Header -->
      <header class="topbar">
        <h1>Dashboard Admin</h1>
        <div class="admin-profile">
          <a href="{{ route('maintenance') ?? '#' }}"> <img src="https://i.pravatar.cc/40" alt="Admin"></a>
          <span>Admin</span>
          <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
          </form>
        </div>
      </header>

      <!-- Statistik -->
      <section class="cards">
        <div class="card">
          <div class="icon"><i class="fa-solid fa-users"></i></div>
          <div class="text">
            <h3>Total Pengguna</h3>
            <p>1,245</p>
          </div>
        </div>
        <div class="card">
          <div class="icon"><i class="fa-solid fa-box"></i></div>
          <div class="text">
            <h3>Produk Terdaftar</h3>
            <p>382</p>
          </div>
        </div>
        <div class="card">
          <div class="icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
          <div class="text">
            <h3>Transaksi Aktif</h3>
            <p>87</p>
          </div>
        </div>
        <div class="card">
          <div class="icon"><i class="fa-solid fa-money-bill-trend-up"></i></div>
          <div class="text">
            <h3>Pendapatan</h3>
            <p>Rp 12.540.000</p>
          </div>
        </div>
      </section>

      <!-- Aktivitas Terbaru -->
      <section class="activity-section">
        <h2>Aktivitas Terbaru</h2>
        <table>
          <thead>
            <tr>
              <th>User</th>
              <th>Aksi</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>David</td>
              <td>Menambah Produk Baru</td>
              <td>2 menit lalu</td>
            </tr>
            <tr>
              <td>Tom</td>
              <td>Memperbarui Harga Produk</td>
              <td>10 menit lalu</td>
            </tr>
            <tr>
              <td>Darren</td>
              <td>Menghapus Akun Penjual</td>
              <td>30 menit lalu</td>
            </tr>
            <tr>
              <td>Alok</td>
              <td>Menambah Data Transaksi</td>
              <td>1 jam lalu</td>
            </tr>
          </tbody>
        </table>
      </section>
    </main>
  </div>

  <script src="{{ asset('assets/js/admin.js') }}"></script>
</body>
</html>
