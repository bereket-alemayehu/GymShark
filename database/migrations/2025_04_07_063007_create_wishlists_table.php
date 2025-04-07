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
            $table->integer('quantity')->default(1); // Default quantity is 1
            $table->boolean('is_favorite')->default(false); // Optional, for marking as favorite
            $table->boolean('is_shared')->default(false); // Optional, for shared wishlists
            $table->string('shared_with')->nullable(); // Optional, for storing user IDs or emails with whom the wishlist is shared
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
