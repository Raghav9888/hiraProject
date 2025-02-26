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
        Schema::table('offerings', function (Blueprint $table) {

            $table->dropColumn('booking_duration');
            $table->string('booking_duration','255')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offerings', function (Blueprint $table) {
            // Optionally, drop the VARCHAR column if you need to reverse the migration
            $table->dropColumn('booking_duration');
            // Add back the original JSON column
            $table->json('booking_duration')->nullable();
        });
    }
};
