<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,            
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product_variant_id' => $this->product_variant_id,
            'order_id' => $this->order_id,            
            'product_variant' => new ProductVariantResource($this->whenLoaded('productVariant')),
        ];
    }
}
