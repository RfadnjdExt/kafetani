<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        $products   = Product::with('category')
                             ->where('type', 'cafe')
                             ->where('stok', '>', 0)
                             ->orderBy('category_id')
                             ->orderBy('nama_produk')
                             ->get();

        $categories = Category::orderBy('name')->get();

        return view('menu.index', compact('products', 'categories'));
    }
}
