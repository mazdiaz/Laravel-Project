@extends('layouts.admin')

@section('title', 'Detail Transaksi #' . $order->id)

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp

<div class="row justify-content-center">
    <div class="col-lg-10">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-muted">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <div class="text-muted small">
                Dibuat pada: {{ $order->created_at->format('d F Y, H:i') }}
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4 bg-primary bg-opacity-10">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0 text-primary">Order #{{ $order->id }}</h5>
                    <span class="text-muted small">Status saat ini: <strong>{{ ucfirst($order->status) }}</strong></span>
                </div>
                
                <form method="POST" action="{{ route('admin.orders.status', $order->id) }}" class="d-flex gap-2 align-items-center">
                    @csrf
                    <label class="small fw-bold text-muted mb-0">Update Status:</label>
                    <select class="form-select form-select-sm border-primary" name="status" style="width: 150px;">
                        @foreach (['pending','paid','shipped','completed','cancelled'] as $st)
                            <option value="{{ $st }}" @selected($order->status === $st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold py-3">Informasi Pengiriman</div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="small text-muted text-uppercase fw-bold">Pembeli</label>
                            <div class="fw-semibold">{{ $order->buyer->name ?? 'User Terhapus' }}</div>
                            <div class="small text-muted">{{ $order->buyer->email ?? '-' }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="small text-muted text-uppercase fw-bold">Penjual</label>
                            <div class="fw-semibold">{{ $order->seller->name ?? 'User Terhapus' }}</div>
                            <div class="small text-muted">{{ $order->seller->email ?? '-' }}</div>
                        </div>

                        <hr class="text-muted opacity-25">

                        <div>
                            <label class="small text-muted text-uppercase fw-bold mb-2">Alamat Tujuan</label>
                            <div class="d-flex align-items-start mb-2">
                                <i class="bi bi-geo-alt me-2 text-primary"></i>
                                <div>
                                    <div class="fw-bold">{{ $order->shipping_name }}</div>
                                    <div class="small">{{ $order->shipping_address }}</div>
                                    <div class="small text-muted mt-1"><i class="bi bi-telephone me-1"></i> {{ $order->shipping_phone }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold py-3">Rincian Pesanan</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <thead class="bg-light text-secondary small">
                                    <tr>
                                        <th class="ps-4">Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $it)
                                    <tr class="border-bottom">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $it->product && $it->product->image_path ? Storage::url($it->product->image_path) : 'https://via.placeholder.com/600x400' }}" 
                                                     class="rounded border" 
                                                     style="width: 50px; height: 50px; object-fit: cover; margin-right: 12px;">
                                                <div>
                                                    <div class="fw-semibold text-dark small">{{ $it->product->name ?? 'Produk Terhapus' }}</div>
                                                    <div class="text-muted small">@ Rp {{ number_format($it->price, 0, ',', '.') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-muted">x{{ $it->quantity }}</td>
                                        <td class="text-end fw-semibold pe-4">
                                            Rp {{ number_format($it->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold pt-3">Total Pembayaran</td>
                                        <td class="text-end fw-bold text-primary fs-5 pt-3 pe-4">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection