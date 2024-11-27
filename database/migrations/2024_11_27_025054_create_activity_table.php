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
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('activity_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('travel_id');
            $table->string('activity_name');
            $table->string('location');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('travel_id')->references('travel_id')->on('flight_reservation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity');
    }
};
