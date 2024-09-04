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
        Schema::create('zone_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('price');

            $table->unsignedBigInteger('from_zone_id');
            $table->foreign('from_zone_id')->references('id')->on('zones')->onDelete('cascade');

            $table->unsignedBigInteger('to_zone_id');
            $table->foreign('to_zone_id')->references('id')->on('zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zone_prices');
    }
};
