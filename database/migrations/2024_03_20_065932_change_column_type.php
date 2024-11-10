<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku',500)->change();
            $table->string('condition',500)->change();
        });
    }

    public function down()
    {
        // Revert the changes if needed
    }
};
