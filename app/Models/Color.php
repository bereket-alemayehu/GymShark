<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }
    public function products() {
        return $this->hasManyThrough(Product::class, ProductVariant::class);
    }
    public function images() {
        return $this->hasManyThrough(ProductImages::class, ProductVariant::class);
    }
}
