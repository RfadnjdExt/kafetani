@extends('layouts.app')

@section('title', 'Menu Kafe')

@section('content')

<div class="page" id="page-menu">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-label">Kafetani · Menu</div>
        <h1 class="page-header-title">Menu Kafe</h1>
        <p class="page-header-sub">Minuman dan makanan segar dari bahan-bahan pilihan petani lokal</p>
    </div>

    {{-- Grid Produk Menu --}}
    <div class="market-grid" style="padding: 0 2rem 4rem; max-width: 1200px; margin: 0 auto;">

        @forelse ($products as $product)
            <div class="product-card">
                <div class="product-thumb">
                    @if ($product->gambar && file_exists(public_path('products/' . $product->gambar)))
                        <img src="{{ asset('products/' . $product->gambar) }}"
                             alt="{{ $product->nama_produk }}"
                             loading="lazy">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;background:var(--cream2);">☕</div>
                    @endif
                </div>
                <div class="product-body">
                    <div class="product-cat">
                        {{ optional($product->category)->name ?? 'Menu Kafe' }}
                    </div>
                    <div class="product-name">{{ $product->nama_produk }}</div>
                    <p class="product-desc">{{ $product->deskripsi }}</p>
                    <div class="product-footer">
                        <span class="product-price">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </span>
                        <button class="add-btn"
                            data-id="{{ $product->id_product }}"
                            data-name="{{ $product->nama_produk }}"
                            data-price="{{ $product->harga }}"
                            data-image="{{ $product->gambar }}">
                            +
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p style="grid-column:1/-1; text-align:center; color:var(--text-light); padding:4rem;">
                Menu kafe belum tersedia.
            </p>
        @endforelse

    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('menu.js') }}"></script>
@endpush
