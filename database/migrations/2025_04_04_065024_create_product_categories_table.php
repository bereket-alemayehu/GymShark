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
           // $table->foreignIdFor(ProductCategory::class)->constrained()->cascadeOnDelete(); // Link to categories like Men, Women, Kids
            $table->string('name'); // e.g., "T-shirts", "Bottoms", "Jackets"            
            $table->string('title')->nullable(); 
            $table->string('meta_title')->nullable(); 
            $table->string('meta_description')->nullable();       
            $table->text('description')->nullable(); // Description of the sub-category
            $table->string('image')->nullable(); // Image URL or path for the sub-category
            $table->string('banner')->nullable(); // Banner URL or path for the sub-category
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
