<?php

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
        Schema::create('product_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductCategory::class)->constrained()->cascadeOnDelete(); // Link to categories like Men, Women, Kids
            $table->string('name'); // e.g., "T-shirts", "Bottoms", "Jackets"
            $table->string('slug')->unique(); // e.g., "t-shirts", "bottoms", "jackets"
            $table->text('description')->nullable(); // Description of the sub-category
            $table->array('image')->nullable(); // Image URL or path for the sub-category
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sub_categories');
    }
};
