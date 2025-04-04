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
            $table->foreignIdFor(ProductCategory::class)->nullable()->constrained('product_categories')->cascadeOnDelete();
            $table->string('slug')->unique();        
            $table->decimal('price', 20, 4)->default(0);
            $table->decimal('sale_price', 20, 4)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->enum('stock_status',['active', 'inactive'])->default('active');
            $table->string('description')->nullable();           
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->onDelete('cascade');
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
