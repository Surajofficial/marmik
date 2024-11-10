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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('size')->default('M')->nullable();
            $table->string('sku')->unique();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('length')->nullable();
            $table->string('weight')->nullable();
            $table->json('rules')->nullable();
            $table->boolean('is_featured')->deault(false);
            $table->boolean('is_best_seller')->deault(false);
            $table->longText('best_seller_no')->nullable();
            $table->longText('fearured_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
