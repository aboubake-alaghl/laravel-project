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
        Schema::create('drivers_delivery_categories', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('delivery_categories_id');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('delivery_categories_id')->references('id')->on('delivery_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers_delivery_categories');
    }
};
