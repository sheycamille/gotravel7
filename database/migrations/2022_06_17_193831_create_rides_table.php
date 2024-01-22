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
            $table->string('pickup_location');
            $table->unsignedBigInteger('num_of_seats')->default(0);
            $table->unsignedBigInteger('num_of_seats_left')->default(0);
            $table->enum('type', [ Ride::RIDE_TYPE_PERSONS, Ride::RIDE_TYPE_GOODS])->default(Ride::RIDE_TYPE_PERSONS);
            $table->enum('status', [ Ride::RIDE_STATUS_PROGRESS, Ride::RIDE_STATUS_STARTED, Ride::RIDE_STATUS_ENDED])->default(Ride::RIDE_STATUS_PROGRESS);
            $table->string('departure');
            $table->string('destination');
            $table->string('start_day');
            $table->string('start_time');
            $table->longText('comments')->nullable();
            $table->double('cost')->default(0);
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