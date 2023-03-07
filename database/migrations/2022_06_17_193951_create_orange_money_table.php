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
        Schema::create('orange_money', function (Blueprint $table) {
            $table->id();
            $table->string('txnid', 100)->nullable();
            $table->integer('user_id');
            $table->integer('ride_id');
            $table->string('notif_token', 50);
            $table->integer('phone_number');
            $table->string('amount');
            $table->string('pay_token');
            $table->text('message');
            $table->enum('status', ['0', '1', '2'])->default('0');
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
        Schema::dropIfExists('orange_money');
    }
};
