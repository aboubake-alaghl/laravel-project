<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->rememberToken();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->unique();
            $table->string('phone_code');
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('default_address_id')->nullable();
            $table->foreign('default_address_id')->references('id')->on('addresses')->onDelete('cascade');

            $table->boolean('gender');
            $table->boolean('is_active')->default(true);
            $table->string('reset_otp')->nullable();
            $table->string('email_confirm_otp')->nullable();
            $table->date('dob')->nullable();
            // $table->string('qr_code')->unique();
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
