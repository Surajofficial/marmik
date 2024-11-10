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
        Schema::table('stock_product_returns', function (Blueprint $table) {
            //
            $table->decimal('sub_totals', 10, 2)->after('products')->default(0);
            $table->decimal('total_cgst', 10, 2)->after('sub_totals')->default(0);
            $table->decimal('total_sgst', 10, 2)->after('total_cgst')->default(0);
            $table->decimal('total_amount', 10, 2)->after('total_sgst')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_product_returns', function (Blueprint $table) {
            //
            $table->dropColumn('sub_totals');
            $table->dropColumn('total_cgst');
            $table->dropColumn('total_sgst');
            $table->dropColumn('total_amount');
        });
    }
};
