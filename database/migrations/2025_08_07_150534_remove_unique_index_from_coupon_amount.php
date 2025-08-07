<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('discounts', function (Blueprint $table) {
// Drop the unique index that was mistakenly applied to coupon_amount
            $table->dropUnique('discounts_coupon_code_unique');
        });
    }

    public function down()
    {
        Schema::table('discounts', function (Blueprint $table) {
// Restore the unique index if needed
            $table->unique('coupon_amount', 'discounts_coupon_code_unique');
        });
    }
};
