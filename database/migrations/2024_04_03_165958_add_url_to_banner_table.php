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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('gst_no')->nullable();
            $table->string('new_field')->nullable();
            $table->string('extra_id')->nullable();
            $table->string('extra_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('gst_no');
            $table->dropColumn('new_field');
            $table->dropColumn('extra_id');
            $table->dropColumn('extra_value');
        });
    }
};
