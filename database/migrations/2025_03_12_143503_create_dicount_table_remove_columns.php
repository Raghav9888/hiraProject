<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn([
                'coupon_description',
                'apply_all_services',
                'coupon_amount',
                'minimum_spend',
                'maximum_spend',
                'individual_use_only',
                'exclude_sale_items',
                'exclude_services',
                'email_restrictions',
                'usage_limit_per_coupon',
                'usage_limit_to_x_items',
                'usage_limit_per_user'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->text('coupon_description')->nullable();
            $table->boolean('apply_all_services')->default(false);
            $table->decimal('coupon_amount', 8, 2)->nullable();
            $table->decimal('minimum_spend', 8, 2)->nullable();
            $table->decimal('maximum_spend', 8, 2)->nullable();
            $table->boolean('individual_use_only')->default(false);
            $table->boolean('exclude_sale_items')->default(false);
            $table->json('exclude_services')->nullable();
            $table->json('email_restrictions')->nullable();
            $table->integer('usage_limit_per_coupon')->nullable();
            $table->integer('usage_limit_to_x_items')->nullable();
            $table->integer('usage_limit_per_user')->nullable();
        });
    }
};
