<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id_product,
            'nama_produk'   => $this->nama_produk,
            'harga'         => $this->harga,
            'harga_format'  => $this->harga_format,
            'stok'          => $this->stok,
            'deskripsi'     => $this->deskripsi,
            'farmer_id'     => $this->farmer_id,
            // Relasi foreign key murni ke tabel farmers (lihat Product::farmer()).
            'farmer'        => $this->whenLoaded('farmer', fn () => $this->farmer ? [
                'id'       => $this->farmer->id,
                'name'     => $this->farmer->name,
                'location' => $this->farmer->location,
            ] : null),
            'type'          => $this->type,
            'category_id'   => $this->category_id,
            'category_name' => $this->whenLoaded('category', fn () => $this->category?->name),
            'gambar_url'    => $this->gambar
                ? $request->getSchemeAndHttpHost() . '/img/products/' . $this->gambar
                : null,
        ];
    }
}
