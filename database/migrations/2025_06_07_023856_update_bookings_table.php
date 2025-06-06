<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('shows_id')
                ->constrained('shows')
                ->onDelete('cascade');
        });

    }

    public function down(): void
    {

    }
};
