<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = ProductCategory::with('products')->get();
        return ProductCategoryResource::collection($productCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:product_categories',
            'description' => 'nullable|string',
            'image' => 'nullable|json',
        ]);
        $productCategory = ProductCategory::create($validated);
        return [
            'message' => 'Product category created successfully',
            'data' => new ProductCategoryResource($productCategory),
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $procuctCategory = ProductCategory::with('products')->findOrFail($id);
        return new ProductCategoryResource($procuctCategory);
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
