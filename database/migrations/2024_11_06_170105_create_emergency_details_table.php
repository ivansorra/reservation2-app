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
        Schema::create('emergency_details', function (Blueprint $table) {
            $table->increments('emergency_id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('name');
            $table->string('contact_no');
            $table->string('address');
            $table->string('relationship');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_details');
    }
};
