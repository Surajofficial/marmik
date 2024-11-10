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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('center_id'); 
            // $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
            $table->foreignId('variant_id')->constrained('product_variants')->onDelete('cascade');
            $table->integer('stock')->default(1);
            $table->string('mfg', 17);
            $table->string('expiry', 17);
            $table->string('batch_no')->nullable();
            $table->float('price');
            $table->float('discount')->nullabale();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
