<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImagesResource extends JsonResource
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
            'image' => $this->image,
            
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product_variant' => [
                'id' => $this->productVariant->id,
                'name' => $this->productVariant->name,
                'price' => $this->productVariant->price,
                'color' => $this->productVariant->color,
                'size' => $this->productVariant->size,
                'stock_quantity' => $this->productVariant->stock_quantity,
                'sku' => $this->productVariant->sku,
            ],
        ];
    }
}
