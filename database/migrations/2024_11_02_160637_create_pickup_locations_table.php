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
        Schema::create('pickup_locations', function (Blueprint $table) {
            $table->id();
            $table->string('pickup_location_nickname'); 
            $table->string('shiper_name'); 
            $table->string('email')->unique(); 
            $table->string('phone'); 
            $table->text('address'); 
            $table->text('address_2')->nullable(); 
            $table->string('city');
            $table->string('state'); 
            $table->string('country'); 
            $table->string('pin_code'); 
            $table->decimal('lat', 10, 8)->nullable(); 
            $table->decimal('long', 11, 8)->nullable(); 
            $table->string('address_type')->nullable(); 
            $table->string('vendor_name')->nullable(); 
            $table->string('gstin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_locations');
    }
};
