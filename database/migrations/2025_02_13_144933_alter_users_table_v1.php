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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name',200)->nullable()->after('name');
            $table->string('last_name',200)->nullable()->after('first_name');
            $table->string('company',200)->nullable()->after('last_name');
            $table->string('bio',500)->nullable()->after('company');
            $table->string('location',200)->nullable()->after('bio');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('company');
            $table->dropColumn('bio');
            $table->dropColumn('location');
        });
    }
};
