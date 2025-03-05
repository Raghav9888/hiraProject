<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure existing endorsements data is valid JSON
        DB::statement("UPDATE user_details SET endorsements = '[]' WHERE endorsements IS NULL OR endorsements = ''");

        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('endorsements'); // Drop old column
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->json('endorsements')->nullable(); // Re-add as JSON column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('endorsements'); // Drop JSON column
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->text('endorsements')->nullable(); // Revert to text column
        });
    }
};
