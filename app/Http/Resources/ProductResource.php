<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'discount_percentage' => $this->discount_percentage,
            'is_new' => $this->is_new,
            'is_active' => $this->is_active,
            'features' => $this->features,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'slug' => $this->slug,
            'productCategory' => [
                'id' => $this->productCategory->id,
                'name' => $this->productCategory->name,
            ],            
           
            'variants' => ProductVariantResource::collection($this->variants),
            'images' => ProductImagesResource::collection($this->images),
        ];
    }
}
