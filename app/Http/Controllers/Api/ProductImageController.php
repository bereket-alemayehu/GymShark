<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductImageResource;
use App\Models\ProductImages;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productImage = ProductImages::with('productVariant.product', 'productVariant.product.subcategory', 'productVariant.product.subcategory.productCategory', 'productVariant')->get();
        return ProductImageResource::collection($productImage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productImage = ProductImages::with('productVariant.product', 'productVariant.product.subcategory', 'productVariant.product.subcategory.productCategory', 'productVariant')->findOrFail($id);
        return new ProductImageResource($productImage);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
