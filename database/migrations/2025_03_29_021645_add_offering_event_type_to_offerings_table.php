<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->string('offering_event_type')->nullable()->after('id'); // Adjust placement if needed
        });
    }

    public function down(): void
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->dropColumn('offering_event_type');
        });
    }
};

