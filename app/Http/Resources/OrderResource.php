<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'tracking_code' => $this->tracking_code,
            'status' => $this->status,
            'discount_code' => $this->cart?->discount?->code ?? null,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
            'shipping_address' => $this->shipping_address,
            'products' => CartItemResource::collection($this->cart?->items),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
