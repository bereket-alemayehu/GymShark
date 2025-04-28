<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'user_id' => $this->user_id,
            'status' => $this->status,
            'total_price' => $this->cartItems->sum('total_price'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            //'cart_items' => CartItemResource::collection($this->whenLoaded('cartItems')),
            'cart_items' => $this->cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total_price' => $item->total_price,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            }),

        ];
    }
}
