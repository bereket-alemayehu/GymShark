<?php

use App\Models\Cart;
use App\Models\ProductVariant;
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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cart::class)->constrained()->onDelete('cascade'); // Foreign Key
            $table->foreignIdFor(ProductVariant::class)->constrained()->cascadeOnDeleteonDelete(); // Foreign Key
            $table->unsignedInteger('quantity'); 
            $table->decimal('price', 10, 2); // Price per item
            $table->decimal('total_price', 10, 2); // Total price for this item (quantity * price)           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
