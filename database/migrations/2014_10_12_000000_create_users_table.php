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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('phone_number')->default();
            $table->string('nic')->nullable();
            $table->string('primary_address')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('points')->nullable();
            $table->string('language')->nullable();
            $table->enum('status', [0, 1])->default(0);
            $table->string('avatar')->nullable();
            $table->enum('type', ["passenger", 'driver', 'administrator']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};