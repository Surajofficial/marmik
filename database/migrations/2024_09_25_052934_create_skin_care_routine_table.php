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
        Schema::create('skin_care_routine', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name field
            $table->string('gender'); // Gender field
            $table->integer('age'); // Age field
            $table->string('mobile')->unique(); // Mobile field
            $table->string('email')->unique(); // Email field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skin_care_routine');
    }
};
