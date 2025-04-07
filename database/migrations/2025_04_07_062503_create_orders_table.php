<?php

use App\Models\Product;
use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete(); // Foreign Key
            $table->foreignIdFor(Product::class)->nullable()->constrained()->cascadeOnDelete(); // Foreign Key
            $table->foreignId('billing_address_id')->constrained('adresses')->cascadeOnDelete(); // Foreign Key
            $table->foreignId('shipping_address_id')->constrained('adresses')->cascadeOnDelete(); // Foreign Key
            $table->string('order_number')->unique(); // Unique order number
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
