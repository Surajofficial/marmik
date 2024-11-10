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
        Schema::create('coupons_new', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique(); // VARCHAR(50) UNIQUE NOT NULL
            $table->text('description')->nullable(); // TEXT
            $table->enum('discount_type', ['percentage', 'fixed']); // ENUM('percentage', 'fixed') NOT NULL
            $table->decimal('discount_value', 10, 2); // DECIMAL(10, 2) NOT NULL
            $table->integer('min_order')->default(250); // INTEGER with a default value of 250
            $table->integer('max_discount')->default(250); // INTEGER with a default value of 250
            $table->dateTime('expires_at')->nullable(); // DATETIME
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons_new');
    }
};
