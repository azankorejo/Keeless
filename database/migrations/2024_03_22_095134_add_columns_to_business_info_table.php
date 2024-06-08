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
            $table->string('web_url')->nullable();
            $table->string('support_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_information', function (Blueprint $table) {
            $table->dropColumn('web_url');
            $table->dropColumn('support_email');
        });
    }
};
