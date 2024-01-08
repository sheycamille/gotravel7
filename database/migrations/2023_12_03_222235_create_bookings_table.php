<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void

    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rideId')->constrained('rides')->onDelete('cascade');
            $table->foreignId('passengerId')->constrained('users')->onDelete('cascade');
            $table->integer('totalCost')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->string('numberOfSeats')->nullable();
            $table->string('transactionId')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
