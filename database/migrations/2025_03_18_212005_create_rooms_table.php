<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('room_number')->unique();
            $table->unsignedInteger('capacity');
            $table->unsignedBigInteger('price');
            $table->boolean('is_reserved')->default(false);

            $table->unsignedBigInteger('floor_id');
            $table->foreign('floor_id')->references('id')->on('floors');//add foriegn key constraints
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
