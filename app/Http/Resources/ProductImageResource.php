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
                'id' => $this->product->id,
                'name' => $this->product->name,
                'slug' => $this->product->slug,
            ],
            'productCategory' => [
                'id' => $this->product->subcategory->productCategory->id,
                'name' => $this->product->subcategory->productCategory->name,
            ],
            'subcategory' => [
                'id' => $this->product->subcategory->id,
                'name' => $this->product->subcategory->name,
            ],
            'productVariant' => [
                'id' => $this->productVariant->id,
                'name' => $this->productVariant->name,
                
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
