<?php

use App\Models\Product;
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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->json('color')->nullable(); // Link to color (e.g., Red)
            $table->json('size')->nullable(); // Link to size (e.g., M)
            $table->string('sku')->unique(); // Stock keeping unit, unique for each variant
            $table->integer('stock_quantity')->default(0);
            //$table->decimal('price', 15, 2)->default(0.00); // Price for this specific variant (could be different from base price)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
