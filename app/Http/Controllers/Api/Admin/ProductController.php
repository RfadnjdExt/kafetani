<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /api/admin/products?type=cafe|market|all
     */
    public function index(Request $request): JsonResponse
    {
        $type = $request->query('type', 'all');

        $products = Product::with('category')
            ->when(in_array($type, ['cafe', 'market']), fn ($q) => $q->where('type', $type))
            ->orderBy('type')
            ->orderBy('nama_produk')
            ->get();

        return response()->json([
            'success'  => true,
            'products' => ProductResource::collection($products),
        ]);
    }

    /**
     * POST /api/admin/products
     * Tambah produk baru. Kirim sebagai multipart/form-data kalau menyertakan gambar.
     */
    public function store(Request $request): JsonResponse
    {
        return $this->save($request);
    }

    /**
     * POST /api/admin/products/{product}
     * Update produk. Dipakai POST (bukan PUT) supaya kompatibel dengan upload
     * gambar multipart dari Android tanpa perlu method-spoofing.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        return $this->save($request, $product);
    }

    /**
     * DELETE /api/admin/products/{product}
     */
    public function destroy(Product $product): JsonResponse
    {
        if ($product->gambar) {
            @unlink(public_path('img/products/' . $product->gambar));
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus.',
        ]);
    }

    /**
     * Logic bersama add/edit — sama seperti Admin\ProductController::save() versi web.
     */
    private function save(Request $request, ?Product $product = null): JsonResponse
    {
        $data = $request->validate([
            'nama_produk' => ['required', 'string', 'max:100'],
            'harga'       => ['required', 'integer', 'min:1'],
            'stok'        => ['required', 'integer', 'min:0'],
            'deskripsi'   => ['nullable', 'string'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'type'        => ['required', 'in:cafe,market'],
            'petani'      => ['nullable', 'string', 'max:100'],
            'gambar'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            $ext      = $request->file('gambar')->getClientOriginalExtension();
            $filename = uniqid('prod_', true) . '.' . strtolower($ext);
            $request->file('gambar')->move(public_path('img/products'), $filename);

            if ($product && $product->gambar) {
                @unlink(public_path('img/products/' . $product->gambar));
            }

            $data['gambar'] = $filename;
        } elseif ($product) {
            // Tidak ada file baru di-upload → pertahankan gambar lama, jangan ditimpa null.
            unset($data['gambar']);
        }

        if ($product) {
            $product->update($data);
            $message = 'Produk berhasil diperbarui.';
        } else {
            $product = Product::create($data);
            $message = 'Produk baru berhasil ditambahkan.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'product' => new ProductResource($product->load('category')),
        ]);
    }
}
