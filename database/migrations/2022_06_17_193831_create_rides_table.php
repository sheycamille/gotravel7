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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_id');
            $table->integer('vehicle_id')->nullable();
            $table->string('pickup_location');
            $table->integer('num_of_seats');
            $table->integer('num_of_seats_left')->nullable()->default(null);
            $table->enum('type', ['persons', 'goods']);
            $table->enum('status', ['in_process', 'started', 'ended'])->default('in_process');
            $table->string('departure');
            $table->string('destination');
            $table->string('start_day');
            $table->string('start_time');
            $table->longText('comments')->nullable();
            $table->double('cost');
            $table->double('charges')->nullable();
            $table->double('total_cost')->nullable();
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
        Schema::dropIfExists('rides');
    }
};
