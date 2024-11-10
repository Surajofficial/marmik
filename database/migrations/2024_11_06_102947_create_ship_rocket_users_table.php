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
        Schema::create('ship_rocket_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();  
            $table->string('password');       
            $table->string('token')->nullable();     
            $table->timestamp('token_at')->nullable();  
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ship_rocket_users');
    }
};
