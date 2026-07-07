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
            // Catatan: kolom 'petani' di tabel product isinya teks bebas
            // (contoh: "Pak Budi - Gayo, Aceh"), bukan foreign key ke tabel
            // farmers — jadi dikirim apa adanya sebagai string, sama seperti
            // yang dipakai di tampilan web (lihat database/seeders).
            'petani'        => $this->petani,
            'type'          => $this->type,
            'category_id'   => $this->category_id,
            'category_name' => $this->whenLoaded('category', fn () => $this->category?->name),
            'gambar_url'    => $this->gambar
                ? $request->getSchemeAndHttpHost() . '/img/products/' . $this->gambar
                : null,
        ];
    }
}
