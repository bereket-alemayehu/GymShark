<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'thumbnail_image' => $this->thumbnail_image,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'discount_percentage' => $this->discount_percentage,
            'description' => $this->description,
        ];
    }
}
