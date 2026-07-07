<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'product_id'  => $this->product_id,
            'nama_produk' => $this->whenLoaded('product', fn () => $this->product?->nama_produk),
            'gambar_url'  => $this->whenLoaded('product', function () use ($request) {
                return $this->product?->gambar
                    ? $request->getSchemeAndHttpHost() . '/img/products/' . $this->product->gambar
                    : null;
            }),
            'quantity'    => $this->quantity,
            'price'       => $this->price,
            'subtotal'    => $this->subtotal,
        ];
    }
}
