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
        Schema::create('coupon_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // BIGINT UNSIGNED NOT NULL
            
            $table->unsignedBigInteger('coupon_id'); // BIGINT UNSIGNED NOT NULL
            $table->dateTime('used_at')->nullable(); // DATETIME NULL
            // Unique constraint to ensure each user-coupon pair is unique
            $table->unique(['user_id', 'coupon_id'], 'unique_user_coupon');

            // Foreign key constraints
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

                  $table->foreign('coupon_id')
                  ->references('id')->on('coupons_new') // Ensure this matches your coupons table name
                  ->onDelete('cascade');
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_user');
    }
};
