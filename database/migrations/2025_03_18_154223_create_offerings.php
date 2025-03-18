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
            $table->string('scheduling_window_offering_type')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('scheduling_window_event_type')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->dropColumn('scheduling_window_offering_type');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('scheduling_window_event_type');
        });
    }
};
