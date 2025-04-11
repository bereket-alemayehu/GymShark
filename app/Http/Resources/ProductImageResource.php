<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
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
            'is_main' => $this->is_main,
            
            'product' => [
                'id' => $this->productVariant->product->id,
                'name' => $this->productVariant->product->name,
                'slug' => $this->productVariant->product->slug,
            ],
            'productCategory' => [
                'id' => $this->productVariant->product->subcategory->productCategory->id,
                'name' => $this->productVariant->product->subcategory->productCategory->name,
            ],
            'subcategory' => [
                'id' => $this->productVariant->product->subcategory->id,
                'name' => $this->productVariant->product->subcategory->name,
            ],
            'productVariant' => [
                'id' => $this->productVariant->id,
                'sku' => $this->productVariant->sku,
                'color' => $this->productVariant->color,
                
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
