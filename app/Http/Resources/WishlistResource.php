<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
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
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'discount_price' => $this->product->discount_price,
                'image' => $this->product->image,
                'slug' => $this->product->slug,
                // 'category' => [
                //     'id' => $this->product->productCategory->id,
                //     'name' => $this->product->productCategory->name,
                // ],
            ],
            
            'created_at' => $this->created_at,
        ];
    }
}
