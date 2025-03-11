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
            // Drop the existing 'buffering' column if it exists
            if (Schema::hasColumn('offerings', 'buffer_time')) {
                $table->dropColumn('buffer_time');
            }

            // Add the new 'buffering' column with varchar type
            $table->string('buffer_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offerings', function (Blueprint $table) {
            // Drop the 'buffering' column
            if (Schema::hasColumn('offerings', 'buffer_time')) {
                $table->dropColumn('buffer_time');
            }
        });

        Schema::table('offerings', function (Blueprint $table) {
            // Add the 'buffering' column back with the date type
            $table->date('buffer_time')->nullable();
        });
    }
};
