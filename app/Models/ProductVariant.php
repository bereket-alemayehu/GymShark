<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function product() {
        return $this->belongsTo(Product::class);
    }
    
    public function images() {
        return $this->hasMany(ProductImages::class);
    } 
    public function cartItems() {
        return $this->hasMany(CartItem::class, 'product_variant_id');
    }
    
    
    
    
    
}
