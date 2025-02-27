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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offering_id')->constrained('offerings')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Customer
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->date('booking_date');
            $table->string('time_slot');
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_confirmed')->default(false);
            // Billing Details
            $table->string('first_name');
            $table->string('last_name');
            $table->string('billing_company')->nullable();
            $table->string('billing_address');
            $table->string('billing_address2');
            $table->string('billing_country');
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_postcode');
            $table->string('billing_phone');
            $table->string('billing_email');
            $table->string('notes')->nullable();

            // Shipping Details (if applicable)
            $table->string('shipping_name')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_email')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
