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
            if (!Schema::hasColumn('discounts', 'apply_to')) {
                $table->string('apply_to')->nullable();
            }

            if (Schema::hasColumn('discounts', 'offerings')) {
                $table->dropColumn('offerings');
            }

            $table->json('offerings')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            if (Schema::hasColumn('discounts', 'apply_to')) {
                $table->dropColumn('apply_to');
            }

            if (Schema::hasColumn('discounts', 'offerings')) {
                $table->dropColumn('offerings');
            }

            $table->string('offerings')->nullable();
        });
    }
};
