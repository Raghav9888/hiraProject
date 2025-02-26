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

            $table->dropColumn('type');
            $table->dropColumn('calendar_display_mode');
            $table->dropColumn('confirmation_requires');
            $table->dropColumn('cancel');
            $table->dropColumn('maximum_block');
            $table->dropColumn('period_booking_period');
            $table->dropColumn('booking_default_date_availability');
            $table->dropColumn('booking_check_availability_against');
            $table->dropColumn('restrict_days');
            $table->dropColumn('block_start');
            $table->dropColumn('range');
            $table->dropColumn('cost');
            $table->dropColumn('cost_range');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->string('type');
            $table->string('calendar_display_mode')->nullable();
            $table->boolean('confirmation_requires');
            $table->boolean('cancel');
            $table->boolean('maximum_block');
            $table->string('period_booking_period');
            $table->string('booking_default_date_availability');
            $table->string('booking_check_availability_against');
            $table->json('restrict_days');
            $table->json('block_start');
            $table->json('range');
            $table->json('cost');
            $table->json('cost_range');
        });
    }
};
