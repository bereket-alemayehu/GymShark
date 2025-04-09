<?php

use App\Models\Product;
use App\Models\ProductSubCategory;
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
            $table->foreignIdFor(ProductSubCategory::class)->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();        
            $table->decimal('price', 20, 4)->default(0); 
            $table->decimal('discount_price', 20, 4)->default(0); // Price after discount
            $table->decimal('discount_percentage', 5, 2)->default(0); // Percentage of discount  
            $table->boolean('is_new')->default(false); // New product flag
            $table->boolean('is_active')->default(false); // Featured product flag    
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
