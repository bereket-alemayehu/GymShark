<?php

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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign Key
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign Key
            $table->unique(['user_id', 'product_id']); // Prevent duplicate entries
            // Optional, for storing user IDs or emails with whom the wishlist is shared
            $table->string('shared_with')->nullable(); // For storing user IDs or emails with whom the wishlist is shared
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
