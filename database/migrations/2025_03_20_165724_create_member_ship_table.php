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
        Schema::create('membership', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->boolean('confirm_necessary_certifications_credentials')->nullable()->default(0);
            $table->boolean('acknowledge_the_hira_collective_practitioner_agreement')->nullable()->default(0);
            $table->boolean('understand_declaration_serves')->nullable()->default(0);
            $table->boolean('referral_program')->nullable()->default(0);

            $table->string('membership_name')->nullable();
            $table->string('membership_type')->nullable();
            $table->string('payment_status')->nullable();

            $table->string('subscription_status')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('preferred_name')->nullable();
            $table->string('pronouns')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('location')->nullable();
            $table->string('website_social_media_link')->nullable();
            $table->string('business_name')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->string('license_certification_number')->nullable();

            $table->json('membership_modalities')->nullable();
            $table->json('blogs_workshops_events')->nullable();
            $table->json('certificates_images')->nullable();

            $table->text('collaboration_interests')->nullable();

            $table->date('birthday')->nullable();
            $table->dateTime('membership_start_date')->nullable();
            $table->dateTime('renewal_date')->nullable();
            $table->dateTime('cancellation_date')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership');
    }
};
