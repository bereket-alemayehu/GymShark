<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
            'size' => $this->size,
            'color' => $this->color,
            'stock-quantity' => $this->stock_quantity,
            'sku' => $this->sku,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'slug' => $this->product->slug,
            ],
            'productCategory' => [
                'id' => $this->product->subcategory->productCategory->id,
                'name' => $this->product->subcategory->productCategory->name,
            ],

            'productImages' => ProductImagesResource::collection($this->whenLoaded('images')),

        ];
    }
}
