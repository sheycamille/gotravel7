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
        Schema::create('momos', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 255);
            $table->string('processing_number')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('ride_id')->nullable();
            $table->string('phone_number');
            $table->double('amount');
            $table->string('status_code')->nullable();
            $table->longText('status_desc')->nullable();
            $table->enum('status',['pending', 'success', 'failed', 'processing'])->default('pending');
            $table->string('type')->nullable();
            $table->string('at')->nullable();
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
        Schema::dropIfExists('momos');
    }
};
