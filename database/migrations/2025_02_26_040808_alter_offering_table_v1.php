<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->string('offering_type')->nullable();
            $table->dateTime('from_date')->nullable();
            $table->dateTime('to_date')->nullable();
            $table->boolean('availability')->default(true);
            $table->string('availability_type')->nullable();
            $table->string('client_price')->nullable();
            $table->string('tax_amount')->nullable();
            $table->string('scheduling_window')->nullable();
            $table->string('buffer_time')->nullable();
            $table->text('email_template')->nullable();
            $table->string('intake_form')->nullable();
            $table->boolean('is_cancelled')->default(false);
            $table->dateTime('cancellation_time_slot')->nullable();
            $table->boolean('is_confirmation')->default(false);
        });
    }

    public function down()
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->dropColumn([
                'offering_type', 'booking_duration', 'from_date', 'to_date', 'availability',
                'availability_type', 'client_price', 'tax_amount', 'scheduling_window',
                'buffer_time', 'email_template', 'intake_form', 'is_cancelled',
                'cancellation_time_slot', 'is_confirmation'
            ]);
        });
    }
};
