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
        Schema::create('routines', function (Blueprint $table) {
            $table->id();
            $table->string('age')->nullable();
            $table->string('skin')->nullable();
            $table->string('pconcern_id')->nullable();
            $table->string('sconcern_id')->nullable();
            $table->string('sensitive')->nullable();
            $table->string('pb')->nullable();
            $table->string('pid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routines');
    }
};
