<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    // "to",
    // "from",
    // "status",
    // "distance"
    public function up(): void
    {
        Schema::create('route_directions', function (Blueprint $table) {
            $table->id();
            $table->string("to");
            $table->string("from");
            $table->enum('status', ["active", 'suspended']);
            $table->string("distance");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_directions');
    }
};
