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
        Schema::create('socials', function (Blueprint $table) {
            $table->id();
            $table->text('photo');
            $table->text('video')->nullable();
            $table->string('link')->nullable();
            $table->string('description')->nullable();
            $table->string('iframe')->nullable();
            $table->enum('social',['instagram','facebook','whatsapp','youtube'])->default('instagram');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socials');
    }
};
