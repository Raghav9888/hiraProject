<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaitlistsTable extends Migration
{
    public function up(): void
    {
        Schema::create('waitlists', function (Blueprint $table) {
            $table->id();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('business_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('current_practice')->nullable();

            $table->json('heard_from')->nullable();     // Instagram, Facebook, etc.
            $table->string('referral_name')->nullable();
            $table->string('other_source')->nullable();

            $table->text('called_to_join')->nullable();
            $table->text('practice_values')->nullable();
            $table->text('excitement_about_hira')->nullable();

            $table->string('call_availability')->nullable(); // Yes / No
            $table->string('newsletter')->nullable();        // Yes / No

            $table->json('uploads')->nullable(); // Store uploaded file names or paths

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waitlists');
    }
}
