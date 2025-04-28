<?php

namespace App\Http\Controllers;

use App\Http\Resources\PromotionResource;
use App\Models\Product;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotedProducts = Product::where('is_active', true)
            ->where(function ($query) {
                $query->where('discount_price', '>', 0)
                      ->orWhere('discount_percentage', '>', 0);
            })
            ->latest()
            ->paginate(20);

        return PromotionResource::collection($promotedProducts);
    }
}
