@extends('layouts.app')
@section('title', 'Menu Kafe  Kafetani')

@push('scripts')
    <script src="{{ asset('script-menu.js') }}"></script>
@endpush

@section('content')
<div class="page" id="page-menu"
     data-meja="{{ $table->nomor ?? '' }}"
     data-logged-in="{{ auth()->check() ? '1' : '0' }}">

  @isset($table)
    <div class="page-header" style="padding-bottom:.5rem;">
      <div class="page-header-label" style="display:flex;align-items:center;gap:.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Pesan dari Meja {{ $table->nomor }}{{ $table->keterangan ? ' · ' . $table->keterangan : '' }}
      </div>
      <h1 class="page-header-title">Menu Kafe</h1>
      <p class="page-header-sub">Pilih menu, masukkan keranjang, lalu checkout langsung — tanpa perlu login.</p>
    </div>
  @else
  <div class="page-header">
    <div class="page-header-label">Kafetani · Menu Kafe</div>
    <h1 class="page-header-title">Menu Kafe</h1>
    <p class="page-header-sub">Minuman, pastry, dan camilan buatan sendiri dari bahan lokal</p>
  </div>
  @endisset

  <div class="filter-bar">
    @foreach($categories as $i => $cat)
      <button class="filter-tab {{ $i === 0 ? 'active' : '' }}" data-cat="{{ $cat }}">
        {{ $cat }}
      </button>
    @endforeach
  </div>

  <div class="products-grid" id="menu-grid">
    @forelse($products as $prod)
      <div class="product-card" data-cat="{{ $prod->category->name ?? '' }}">
        <div class="product-thumb">
          @if($prod->gambar)
            <img src="{{ asset_v('products/' . $prod->gambar) }}"
                 alt="{{ $prod->nama_produk }}" loading="lazy">
          @endif
        </div>
        <div class="product-body">
          <div class="product-cat">{{ $prod->category->name ?? '' }}</div>
          <div class="product-name">{{ $prod->nama_produk }}</div>
          <p class="product-desc">{{ $prod->deskripsi }}</p>
          <div class="product-footer">
            <span class="product-price">Rp {{ number_format($prod->harga, 0, ',', '.') }}</span>
            <button class="add-btn"
              data-id="{{ $prod->nama_produk }}"
              data-name="{{ $prod->nama_produk }}"
              data-price="{{ $prod->harga }}"
              data-image="{{ $prod->gambar }}">+</button>
          </div>
        </div>
      </div>
    @empty
      <p style="grid-column:1/-1;text-align:center;color:var(--text-light);padding:4rem">
        Menu belum tersedia.
      </p>
    @endforelse
  </div>

</div>
@endsection
