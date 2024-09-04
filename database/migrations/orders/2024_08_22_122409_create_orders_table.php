<?php

use App\Enums\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('is_paid')->default(false);
            // $table->boolean('is_fragile')->default(false);
            // $table->double('price')->nullable();

            // $table->enum('status', ['DELIVERED', 'CREATED', 'PICKED', 'CANCELED'])->default('CREATED');
            $table->enum('status', array_map(fn($status) => $status->name, OrderStatus::cases()))->default(OrderStatus::CREATED->name);
            // todo: values need to further discussion

            // $table->string('order_qr_code')->nullable();
            $table->string('description');

            $table->unsignedBigInteger('promo_code_id')->nullable();
            // $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onDelete('cascade');
            // todo: will be added when the table is created

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            $table->unsignedBigInteger('from_address_id');
            $table->foreign('from_address_id')->references('id')->on('addresses')->onDelete('cascade');

            $table->unsignedBigInteger('to_address_id')->nullable();
            $table->foreign('to_address_id')->references('id')->on('addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
