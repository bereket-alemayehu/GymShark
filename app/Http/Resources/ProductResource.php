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
            'slug' => $this->slug,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'discount_percentage' => $this->discount_percentage,
            'is_new' => $this->is_new,
            'is_active' => $this->is_active,
            'features' => $this->features,
            'description' => $this->description,
            'information' => $this->information,
            'delivery_info' => $this->delivery_info,
            'size_fit' => $this->size_fit,
            'materials' => $this->materials,
            'made_in' => $this->made_in,
            'care' => $this->care,
            'detail_image' => $this->detail_image,
            'thumbnail_image' => $this->thumbnail_image,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'inner_title' => $this->inner_title,
            'inner_description' => $this->inner_description,
            'inner_subtitle' => $this->inner_subtitle,
            'inner_subdescription' => $this->inner_subdescription,
            'inner_image' => $this->inner_image,
            'inner_base' => $this->inner_base,
            'inner_basevalue' => $this->inner_basevalue,
            'inner_depth' => $this->inner_depth,
            'inner_depthvalue' => $this->inner_depthvalue,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'productCategory' => [
                'id' => $this->productCategory->id,
                'name' => $this->productCategory->name,
                'slug' => $this->productCategory->slug,
                'meta_title' => $this->productCategory->meta_title,
                'meta_description' => $this->productCategory->meta_description,
                'created_at' => $this->productCategory->created_at,
                'updated_at' => $this->productCategory->updated_at,
                'products_count' => $this->productCategory->products_count,
            ],

            'productVariants' => $this->variants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'color' => $variant->color,
                    'size' => $variant->size,
                    'sku' => $variant->sku,
                    'stock_quantity' => $variant->stock_quantity,
                    'price' => $variant->price,
                ];
            }),

            'productImages' => $this->variants->flatMap(function ($variant) {
                return $variant->images->map(function ($image) use ($variant) {
                    return [
                        'id' => $image->id,
                        'image' => $image->image,
                        'is_featured' => $image->is_featured,
                        'created_at' => $image->created_at,
                        'updated_at' => $image->updated_at,
                        'product_id' => $variant->product_id,
                        'product_variant_id' => $image->product_variant_id,
                    ];
                });
            }),
        ];
    }
}
