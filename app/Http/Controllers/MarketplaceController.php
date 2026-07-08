<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\Product;

class MarketplaceController extends Controller
{
    public function index()
    {
        $products = Product::where('type', 'market')
                           ->where('stok', '>', 0)
                           ->with('farmer')
                           ->orderBy('nama_produk')
                           ->get();

        $farmers = Farmer::orderBy('name')->get()->map(fn($f) => [
            'name'   => $f->name,
            'loc'    => $f->location,
            'img'    => $f->avatar ?? 'default.webp',
            'active' => false,
        ]);

        return view('marketplace.index', compact('products', 'farmers'));
    }
}
