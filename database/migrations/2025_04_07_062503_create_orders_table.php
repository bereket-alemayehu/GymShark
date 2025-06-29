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
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();           
            $table->decimal('total_price', 20, 4);
            $table->string('payment_status')->default('pending'); // Pending, Completed, Failed
            $table->string('payment_reference')->nullable(); // Chapa Payment Reference
            $table->string('payment_method')->nullable(); // Chapa, Stripe, etc.

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
