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
        Schema::table('business_information', function (Blueprint $table) {
            $table->boolean('use_email_for_login')->default(0);
            $table->boolean('use_phone_for_login')->default(0);
            $table->boolean('use_username_for_login')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_information', function (Blueprint $table) {
            $table->dropColumn('use_email_for_login');
            $table->dropColumn('use_phone_for_login');
            $table->dropColumn('use_username_for_login');
        });
    }
};
