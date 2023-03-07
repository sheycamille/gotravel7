<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ride_passengers', function (Blueprint $table) {
            $table->id();
            $table->integer('ride_id');
            $table->string('passenger_id');
            $table->enum('paid', ['pending', 'completed'])->default('pending');
            $table->enum('type', ['persons', 'goods']);
            $table->integer('num_of_seats');
            $table->enum('status', ['in_process', 'in_progess', 'ended', 'cancelled', 'refunded'])->default('in_process');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ride_passengers');
    }
};
