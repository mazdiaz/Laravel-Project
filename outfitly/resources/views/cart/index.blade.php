@extends('layouts.customer')
@section('title', 'Keranjang')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <h4 class="page-title m-0">Keranjang</h4>
    <div class="text-muted small">Cek item sebelum checkout.</div>
  </div>
  <a class="btn btn-outline-primary" href="{{ route('products.index') }}">
    <i class="bi bi-shop me-1"></i> Belanja
  </a>
</div>

@if (empty($cart))
  <div class="card-like p-4 text-center">
    <div class="text-muted">Keranjang masih kosong.</div>
    <a class="btn btn-primary mt-3" href="{{ route('products.index') }}">Mulai Belanja</a>
  </div>
@else

  {{-- REMOVE FORMS (outside update form) --}}
  @foreach ($cart as $id => $item)
    <form id="rm-{{ $id }}" method="POST" action="{{ route('cart.remove', $id) }}" class="d-none">
      @csrf
    </form>
  @endforeach

  {{-- CLEAR FORM (outside update form) --}}
  <form id="cart-clear" method="POST" action="{{ route('cart.clear') }}" class="d-none">
    @csrf
  </form>

  {{-- UPDATE QTY FORM --}}
  <form method="POST" action="{{ route('cart.update') }}" id="cartUpdateForm">
    @csrf

    <div class="card-like p-2">
      <div class="table-responsive">
        <table class="table mb-0 align-middle">
          <thead>
            <tr class="small text-muted">
              <th>Produk</th>
              <th style="width:120px;">Qty</th>
              <th style="width:160px;" class="text-end">Harga</th>
              <th style="width:170px;" class="text-end">Subtotal</th>
              <th style="width:120px;" class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($cart as $id => $item)
              <tr>
                <td>
                  <div class="d-flex gap-3 align-items-center">
                    @if (!empty($item['image_path']))
                      <img src="{{ Storage::url($item['image_path']) }}"
                           style="width:72px;height:54px;object-fit:cover;border-radius:12px;">
                    @endif
                    <div>
                      <div class="fw-semibold">{{ $item['name'] }}</div>
                      <div class="small text-muted">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                    </div>
                  </div>
                </td>

                <td>
                  <input class="form-control" type="number" min="1" max="99"
                         name="qty[{{ $id }}]" value="{{ $item['qty'] }}">
                </td>

                <td class="text-end">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</td>

                <td class="text-end">
                  <button class="btn btn-sm btn-outline-danger" type="submit" form="rm-{{ $id }}">
                    Hapus
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
      <div class="fw-bold">Total: Rp {{ number_format($total, 0, ',', '.') }}</div>

      <div class="d-flex gap-2">
        <button class="btn btn-outline-primary" type="submit">
          <i class="bi bi-arrow-repeat me-1"></i> Update Qty
        </button>

        <button class="btn btn-outline-danger" type="submit" form="cart-clear">
          <i class="bi bi-trash me-1"></i> Kosongkan
        </button>

        <a class="btn btn-primary" href="{{ route('checkout.show') }}">
          Checkout <i class="bi bi-arrow-right ms-1"></i>
        </a>
      </div>
    </div>
  </form>
@endif
@endsection
