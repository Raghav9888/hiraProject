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
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('reschedule_status', ['none', 'requested', 'approved'])->default('none');
            $table->decimal('refunded_to_wallet', 10, 2)->nullable();
            $table->timestamp('rescheduled_at')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['reschedule_status', 'refunded_to_wallet', 'rescheduled_at']);
        });
    }
};
