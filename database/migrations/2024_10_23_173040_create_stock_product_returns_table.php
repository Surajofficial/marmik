<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_product_returns', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('invoice_type');
            $table->string('return_reason');
            $table->date('return_date')->nullable();
            $table->string('customer_phone');
            $table->string('customer_name');
            $table->text('customer_address')->nullable();
            $table->string('place_of_supply');
            $table->json('products'); // Store product details as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_product_returns');
    }
};
