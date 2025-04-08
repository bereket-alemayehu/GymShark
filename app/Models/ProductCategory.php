<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class ProductCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function subcategories() {
        return $this->hasMany(ProductSubCategory::class);
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
