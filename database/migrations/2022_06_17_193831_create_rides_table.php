<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Ride;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id')->constrained("users")->onDelete("cascade");
            $table->string('pickupLocation');
            $table->unsignedBigInteger('numOfSeats')->default(0);
            $table->enum('typeOfContent', [ Ride::RIDE_TYPE_PERSONS, Ride::RIDE_TYPE_GOODS])->default(Ride::RIDE_TYPE_PERSONS);
            $table->enum('status', [ Ride::RIDE_STATUS_PROGRESS, Ride::RIDE_STATUS_STARTED, Ride::RIDE_STATUS_ENDED])->default(Ride::RIDE_STATUS_PROGRESS);
            $table->unsignedBigInteger('departure');
            $table->unsignedBigInteger('destination');
            $table->string('departureDay');
            $table->string('departureTime');
            $table->longText('comments')->nullable();
            $table->double('pricePerSeat')->default(0);
            $table->string('carModel');
            $table->string('carNumberPlate');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rides');
    }
    
};
