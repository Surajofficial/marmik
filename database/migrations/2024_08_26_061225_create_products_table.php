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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->longText('how_to_use')->nullable();
            $table->longText('evidence')->nullable();
            $table->string('presc')->nullable();
            $table->string('combo')->nullable();
            $table->foreignId('concern_id')->nullable()->constrained('concerns')->nullOnDelete();
            $table->foreignId('child_concern_id')->nullable()->constrained('concerns')->nullOnDelete();
            $table->foreignId('ptype_id')->nullable()->constrained('product_types')->nullOnDelete();
            $table->foreignId('child_ptype_id')->nullable()->constrained('product_types')->nullOnDelete();
            $table->foreignId('cat_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('child_cat_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('pts')->default('0');
            $table->string('psr')->default('0');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->unsignedBigInteger('cgst')->nullabale();
            $table->unsignedBigInteger('sgst')->nullabale();
            $table->unsignedBigInteger('tax')->nullabale();
            $table->string('hsn_no')->nullable();
            $table->text('photo')->nullable();
            $table->text('video')->nullable();
            $table->string('routine_concern')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
