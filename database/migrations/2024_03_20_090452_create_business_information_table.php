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
        Schema::create('business_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->string('name');
            $table->boolean('use_api')->default(0);
            $table->boolean('use_email')->default(0);
            $table->boolean('use_phone')->default(0);
            $table->boolean('use_username')->default(0);
            $table->text('terms_of_use')->nullable();
            $table->text('privacy_policy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_information');
    }
};
