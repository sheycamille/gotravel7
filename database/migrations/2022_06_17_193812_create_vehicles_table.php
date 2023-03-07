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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->string('name');
            $table->string('plate_number')->nullable();
            $table->string('prod_year')->nullable();
            $table->string('num_of_seats')->nullable();
            $table->string('cost_per_seat')->nullable();
            $table->string('description');
            $table->enum('status', [0, 1])->default(0);
            $table->string('color')->nullable();
            $table->string('brand')->nullable();
            $table->enum('type', ['compact', 'pickup', 'pickup-truck', 'minivan', 'truck', 'jeep', 'luxury-car', 'mid-size', 'sports-car', 'taxi', 'bus', 'limousine', 'convertible', 'micro-car', 'hybrid', 'mini-van', 'sedan', 'coupe', 'van', 'dyna', 'suv', 'wagon', 'diesel', 'crossover']);
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
        Schema::dropIfExists('vehicles');
    }
};