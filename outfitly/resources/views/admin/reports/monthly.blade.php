@extends('layouts.admin')

@section('title', 'Laporan Bulanan')

@section('content')
<style>
    /* CSS SAAT DI-PRINT */
    @media print {
        .navbar, .sidebar, footer, .btn, form, .no-print, .page-header-actions {
            display: none !important;
        }

        body {
            background-color: white !important;
            color: black !important;
            font-family: 'Times New Roman', Times, serif;
            -webkit-print-color-adjust: exact; 
        }

        .container, .container-fluid, .card, .card-body {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important; 
            border: none !important;
        }

        /* Tampilkan Kop Surat */
        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        .table {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 12px; 
        }
        .table th, .table td {
            border: 1px solid black !important; 
            padding: 4px 8px !important;
        }
        .table thead th {
            background-color: #f0f0f0 !important;
            color: black !important;
            font-weight: bold;
        }
        
        /* Atur Cards Summary menjadi kotak simpel */
        .kpi-card {
            border: 1px solid black !important;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        
        /* Layout Grid Bootstrap fix untuk print */
        .col-md-4, .col-md-6, .col-lg-5, .col-lg-7 {
            float: left;
            width: 100% !important; 
            display: block;
        }
        .summary-row .col-md-4 {
            width: 33% !important;
            float: left;
        }
        
        /* Hentikan pemotongan halaman di tengah tabel */
        tr { page-break-inside: avoid; }
    }

    /* Sembunyikan Kop Surat di layar biasa */
    .print-header {
        display: none;
    }
</style>

{{-- KOP SURAT --}}
<div class="print-header">
    <h2 class="fw-bold text-uppercase mb-0">Report Outfitly</h2>
    <p class="mb-0">Jl. Halimun Raya No 2, RT 15/RW 6, Kecamatan Setiabudi, Kota Jakarta Selatan Provinsi DKI Jakarta</p>
    <p class="small">Email: admin@outfitly.test | Telp: 0812-3456-7890</p>
</div>

{{-- Header Halaman --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 no-print">
    <div>
        <h2 class="fw-bold m-0">Laporan Bulanan</h2>
        <span class="text-muted small">Periode: {{ $start->format('d M Y') }} s/d {{ $end->format('d M Y') }}</span>
    </div>

    <form method="GET" action="{{ route('admin.reports.monthly') }}" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-month"></i></span>
            <input type="month" name="month" class="form-control border-start-0" value="{{ $month }}">
        </div>
        <button class="btn btn-primary" type="submit">Tampilkan</button>
        {{-- Tombol Print --}}
        <button type="button" onclick="window.print()" class="btn btn-sm btn-success">
            <i class="bi bi-printer-fill me-1"></i> Cetak Laporan
        </button>
    </form>
</div>

{{-- Judul Laporan di Body --}}
<div class="d-none d-print-block mb-3">
    <h4 class="fw-bold">Laporan Penjualan Bulanan</h4>
    <p>Periode: {{ $start->format('d F Y') }} - {{ $end->format('d F Y') }}</p>
</div>

{{-- KPI Cards --}}
<div class="row g-3 mb-4 summary-row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 kpi-card">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-bold">Total Orders</div>
                <div class="fs-4 fw-bold text-dark">{{ number_format($totalOrders) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 kpi-card">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-bold">Gross Revenue</div>
                <div class="fs-4 fw-bold text-dark">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 kpi-card">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-bold">Net Revenue</div>
                <div class="fs-4 fw-bold text-dark">Rp {{ number_format($netRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Konten Utama --}}
<div class="row g-4">
    {{-- Tabel Status & Top Seller --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4 kpi-card">
            <div class="card-header bg-white py-2 fw-bold border-bottom">
                Rincian Status Pesanan
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Status</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($byStatus as $row)
                            <tr>
                                <td>{{ ucfirst($row->status) }}</td>
                                <td class="text-end">{{ number_format($row->orders) }}</td>
                                <td class="text-end">Rp {{ number_format($row->revenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-2">Data kosong</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm kpi-card">
            <div class="card-header bg-white py-2 fw-bold border-bottom">
                Top 10 Penjual
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Nama Penjual</th>
                            <th class="text-end">Trx</th>
                            <th class="text-end">Omzet</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topSellers as $s)
                            <tr>
                                <td>{{ $s->seller->name ?? 'Deleted' }}</td>
                                <td class="text-end">{{ number_format($s->orders) }}</td>
                                <td class="text-end">Rp {{ number_format($s->revenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-2">Data kosong</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tabel Harian --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100 kpi-card">
            <div class="card-header bg-white py-2 fw-bold border-bottom">
                Laporan Penjualan Harian
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-end">Jumlah Order</th>
                            <th class="text-end">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daily as $d)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($d->day)->format('d/m/Y') }}</td>
                                <td class="text-end">{{ number_format($d->orders) }}</td>
                                <td class="text-end">Rp {{ number_format($d->revenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4">Tidak ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection