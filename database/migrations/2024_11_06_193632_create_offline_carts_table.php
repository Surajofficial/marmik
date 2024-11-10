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
        Schema::create('offline_carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('offline_invoices')->onDelete('cascade');
            $table->foreignId('stock_id')->constrained('stocks')->onDelete('cascade');
            $table->integer('quantity');
            $table->float('price');
            $table->integer('discount');
            $table->integer('cgst');
            $table->integer('sgst');
            $table->integer('gst');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_carts');
    }
};
