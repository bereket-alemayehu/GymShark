<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'total_price' => $this->total_price,
            'payment_status' => $this->payment_status,
            'order_items' => OrderItemResource::collection($this->orderItems),
            'payment' => new PaymentResource($this->payment),
            'cart_items' => CartItemResource::collection($this->whenLoaded('cartItems')),
        ];
    }
}
