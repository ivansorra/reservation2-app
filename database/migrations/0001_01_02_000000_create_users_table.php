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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id'); // Primary key for users
            $table->unsignedInteger('membership_id')->nullable(); // Foreign key
            $table->foreign('membership_id')->references('membership_id')->on('membership')->onDelete('cascade');
            $table->string('name');
            $table->string('email_address')->unique();
            $table->date('birthdate');
            $table->bigInteger('contact_no')->nullable();
            $table->boolean('user_status')->default(1);
            $table->timestamps();
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('account_id');
            $table->unsignedInteger('user_id'); // Foreign key to `users`
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade'); // Ensure user exists
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email_address')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedInteger('user_id')->nullable(); // Define user_id as nullable
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null'); // Add foreign key constraint
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('users');
    }
};
