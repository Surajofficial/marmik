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
        Schema::table('billings', function (Blueprint $table) {
            $table->string('bdate')->nullable()->change();
            $table->string('pstatus')->nullable()->change();
            $table->string('product')->nullable()->change();
            $table->string('qty')->nullable()->change();
            $table->string('billingName')->nullable()->change();
            $table->string('billingAddress')->nullable()->change();
            $table->string('alltax')->nullable()->change();
            $table->string('subtotal')->nullable()->change();
            $table->string('pmethod')->nullable()->change();
            $table->string('cgst')->nullable();
            $table->string('sgst')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->string('bdate')->nullable(false)->change();
            $table->string('pstatus')->nullable(false)->change();
            $table->string('product')->nullable(false)->change();
            $table->string('qty')->nullable(false)->change();
            $table->string('billingName')->nullable(false)->change();
            $table->string('billingAddress')->nullable(false)->change();
            $table->string('alltax')->nullable(false)->change();
            $table->string('subtotal')->nullable(false)->change();
            $table->string('pmethod')->nullable(false)->change();
        });
    }
};
