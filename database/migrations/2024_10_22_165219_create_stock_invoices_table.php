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
        Schema::create('stock_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->dateTime('invoice_date');
            $table->string('payment_method');
            $table->decimal('sub_total', 10, 2);
            $table->integer('total_quantity');
            $table->decimal('total_cgst', 10, 2);
            $table->decimal('total_sgst', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('amount_in_words');
            $table->json('products'); // You can store product details as a JSON array
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_invoices');
    }
};
