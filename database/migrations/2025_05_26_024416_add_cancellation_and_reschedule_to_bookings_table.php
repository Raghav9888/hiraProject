<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('reschedule')->default(false);
            $table->integer('reschedule_time')->nullable()->default(0);
        });


    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['reschedule', 'reschedule_time']);
        });
    }
};

