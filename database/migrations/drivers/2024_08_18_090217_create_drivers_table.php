<?php

use App\Enums\Driver\DeliveryStatus;
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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('gender')->default(true);
            $table->date('dob')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('criminal_case')->nullable();
            // $table->enum('delivery_status', ['AVAILABLE', 'NOT_AVAILABLE', 'BUSY'])->default('AVAILABLE');
            $table->enum('delivery_status', array_map(fn($status) => $status->name, DeliveryStatus::cases()))->default(DeliveryStatus::AVAILABLE->name);
            $table->enum('status', ['LATER'])->default('LATER');
            $table->integer('national_no')->nullable();
            $table->double('cash_wallet')->default(0);
            $table->double('payment_method_wallet')->default(0);
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');

            $table->unsignedBigInteger('current_location_id')->nullable();
            $table->foreign('current_location_id')->references('id')->on('addresses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
