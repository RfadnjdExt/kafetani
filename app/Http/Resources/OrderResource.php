<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'total'          => $this->total,
            'total_format'   => $this->total_format,
            'type'           => $this->type,
            'source'         => $this->source,
            'customer_name'  => $this->customer_name,
            'status'         => $this->status,
            'status_label'   => $this->status_label,
            // Field pembayaran Midtrans — payment_status independen dari status
            // fulfillment ('status') di atas. snap_token hanya berguna selagi
            // pembayaran belum diselesaikan (dipakai app buat buka halaman bayar).
            'payment_type'   => $this->payment_type,
            'payment_status' => $this->payment_status,
            'snap_token'     => $this->when($this->payment_status === 'unpaid', $this->snap_token),
            'paid_at'        => optional($this->paid_at)->toIso8601String(),
            'created_at'     => optional($this->created_at)->toIso8601String(),
            'user'           => new UserResource($this->whenLoaded('user')),
            'items'          => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
