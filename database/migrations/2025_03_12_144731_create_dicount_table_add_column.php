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
        Schema::table('discounts', function (Blueprint $table) {
            $table->string('apply_to')->nullable(); // Adding new column

            // Drop the existing 'offerings' column before re-adding it
            if (Schema::hasColumn('discounts', 'offerings')) {
                $table->dropColumn('offerings');
            }

            $table->json('offerings')->nullable(); // Re-adding with JSON type
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn('apply_to'); // Removing new column

            if (Schema::hasColumn('discounts', 'offerings')) {
                $table->dropColumn('offerings'); // Dropping JSON version
            }

            $table->string('offerings')->nullable(); // Restoring original column (assuming it was a string)
        });
    }
};
