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
        // Modify 'cancellation_time_slot' in offerings table
        Schema::table('offerings', function (Blueprint $table) {
            $table->string('cancellation_time_slot')->nullable()->change();
        });

        // Create 'events' table
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offering_id')->constrained('offerings')->onDelete('cascade');
            $table->string('specify')->nullable();
            $table->dateTime('date_and_time')->nullable();
            $table->string('recurring_days')->nullable();
            $table->string('event_duration')->nullable();
            $table->string('sports')->nullable();
            $table->string('scheduling_window')->nullable();
            $table->string('email_template')->nullable();
            $table->string('client_price')->nullable();
            $table->string('tax_amount')->nullable();
            $table->string('intake_form')->nullable();
            $table->boolean('is_cancelled')->default(0);
            $table->string('cancellation_time_slot')->nullable();
            $table->boolean('is_confirmation')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'cancellation_time_slot' in offerings table
        Schema::table('offerings', function (Blueprint $table) {
            $table->dateTime('cancellation_time_slot')->nullable()->change();
        });

        // Drop 'events' table
        Schema::dropIfExists('events');
    }
};
