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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('gtype')->nullable();
            $table->string('bdate');
            $table->string('pstatus');
            $table->string('product');
            $table->string('qty');
            $table->string('billingName');
            $table->string('billingAddress');
            $table->string('alltax');
            $table->string('subtotal');
            $table->string('pmethod');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
