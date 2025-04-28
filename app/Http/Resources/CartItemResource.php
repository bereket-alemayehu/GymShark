<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'product_variant' => new ProductVariantResource($this->whenLoaded('productVariant')),
        ];
    }
}
