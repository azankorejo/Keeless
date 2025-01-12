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
        Schema::create('email_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->boolean('use_smtp')->default(0);
            $table->boolean('use_otp')->default(0);
            $table->string('email')->nullable();
            $table->string('server')->nullable();
            $table->string('port')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_information');
    }
};
