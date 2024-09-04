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
        Schema::create('service_values', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('value');
            $table->unsignedBigInteger('service_attribute_id');
            $table->foreign('service_attribute_id')->references('id')->on('service_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_values');
    }
};
