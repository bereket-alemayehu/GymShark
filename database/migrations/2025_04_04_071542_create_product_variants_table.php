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
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Link to Product (e.g., Basic T-shirt)
            $table->foreignId('color_id')->constrained()->onDelete('cascade'); // Link to color (e.g., Red)
            $table->foreignId('size_id')->constrained()->onDelete('cascade'); // Link to size (e.g., M)
            $table->string('sku')->unique(); // Stock keeping unit, unique for each variant
            $table->decimal('price', 15, 2); // Price for this specific variant (could be different from base price)
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
