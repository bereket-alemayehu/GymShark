<?php

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable();
            $table->text('information')->nullable();
            $table->text('delivery_info')->nullable();
            $table->text('size_fit')->nullable();
            $table->json('materials')->nullable();
            $table->string('made_in')->nullable();
            $table->text('care')->nullable();
            $table->string('detail_image')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('inner_title')->nullable();
            $table->text('inner_description')->nullable();
            $table->string('inner_subtitle')->nullable();
            $table->text('inner_subdescription')->nullable();
            $table->string('inner_image')->nullable();
            $table->string('inner_base')->nullable();
            $table->string('inner_baseunit')->nullable();
            $table->string('inner_basevalue')->nullable();
            $table->string('inner_depth')->nullable();
            $table->string('inner_depthvalue')->nullable();
            $table->foreignIdFor(ProductCategory::class)->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->decimal('price', 20, 4)->default(0);
            $table->decimal('discount_price', 20, 4)->default(0); // Price after discount
            $table->decimal('discount_percentage', 5, 2)->default(0); // Percentage of discount  
            $table->boolean('is_new')->default(false); // New product flag
            $table->boolean('is_popular')->default(false); // Featured product flag
            $table->boolean('is_active')->default(true); // Featured product flag    
            $table->text('description')->nullable();
            $table->text('features')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
