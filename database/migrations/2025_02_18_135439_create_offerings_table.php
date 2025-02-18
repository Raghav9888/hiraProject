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
        Schema::create('offerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('long_description')->nullable();
            $table->text('short_description')->nullable();
            $table->json('location')->nullable();
            $table->text('help')->nullable();
            $table->json('categories')->nullable();
            $table->json('tags')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('type');
            $table->json('booking_duration')->nullable();
            $table->string('calendar_display_mode')->nullable();
            $table->boolean('confirmation_requires')->default(false);
            $table->boolean('cancel')->default(false);
            $table->json('maximum_block')->nullable();
            $table->string('period_booking_period')->nullable();
            $table->string('booking_default_date_availability')->nullable();
            $table->string('booking_check_availability_against')->nullable();
            $table->json('restrict_days')->nullable();
            $table->time('block_start')->nullable();
            $table->json('range')->nullable();
            $table->json('cost')->nullable();
            $table->json('cost_range')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offerings');
    }
};
