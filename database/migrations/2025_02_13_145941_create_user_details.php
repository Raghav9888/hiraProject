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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->text('bio')->nullable();
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->json('tags')->nullable();
            $table->json('images')->nullable();
            $table->text('about_me')->nullable();
            $table->text('help')->nullable();
            $table->text('specialities')->nullable();
            $table->text('certifications')->nullable();
            $table->text('endorsements')->nullable();
            $table->string('timezone')->nullable();
            $table->boolean('is_opening_hours')->default(false);
            $table->boolean('is_notice')->default(false);
            $table->boolean('is_google_analytics')->default(false);
            $table->text('privacy_policy')->nullable();
            $table->text('terms_condition')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
