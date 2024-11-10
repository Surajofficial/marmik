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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->text('state')->nullable();
            $table->string('pin')->nullable();
            $table->string('bname')->nullable();
            $table->string('bnumber')->nullable();
            $table->string('bcode')->nullable();
            $table->string('pno')->nullable();
            $table->string('gst')->nullable();
            $table->text('opening')->nullable();
            $table->string('contactp')->nullable();
            $table->string('contactn')->nullable();
            $table->string('odetail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
