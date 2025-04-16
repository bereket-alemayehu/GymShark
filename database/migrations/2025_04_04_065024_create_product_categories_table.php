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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
   
            $table->string('slug')->unique();
            $table->foreignIdFor(ProductCategory::class)->constrained()->cascadeOnDelete(); // Link to categories like Men, Women, Kids
            $table->string('name'); // e.g., "T-shirts", "Bottoms", "Jackets"
            $table->string('meta_description')->nullable(); // Meta description for SEO
            $table->string('title')->nullable(); // Meta keywords for SEO
            $table->string('meta_title')->nullable(); // Meta title for SEO
            // Unique code for the sub-category, e.g., "TSH", "BTM", "JCK"
            $table->text('description')->nullable(); // Description of the sub-category
            $table->string('image')->nullable(); // Image URL or path for the sub-category
            $table->enum('type',['men','women','kids','accessories'])->default('men');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
