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
        Schema::table('user_details', function (Blueprint $table) {
           
            $table->string('IHelpWith',500)->nullable()->after('help');
            $table->string('HowIHelp',500)->nullable()->after('IHelpWith');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn(['IHelpWith', 'HowIHelp']);
        }); 
    }
};
