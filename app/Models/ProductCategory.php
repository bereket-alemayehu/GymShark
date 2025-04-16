<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class ProductCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    /**
     * Get the subcategories associated with the product category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany(Product::class, 'product_category_id');
    }
    protected static function booted()
    {
        static::saving(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
    
}
