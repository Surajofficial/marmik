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
        Schema::table('ship_rocket_users', function (Blueprint $table) {
            $table->text('token')->change();
            $table->timestamp('token_at')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ship_rocket_users', function (Blueprint $table) {
            $table->string('token', 255)->nullable()->change();
            $table->timestamp('token_at')->nullable()->change();
        });
    }
};
