<?php

use App\Models\Route;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->enum('status', [ Route::STATUS_ACTIVE, Route::STATUS_SUSPENDED])->default(Route::STATUS_ACTIVE,);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
