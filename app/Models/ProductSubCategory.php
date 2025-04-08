<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductSubCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
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
