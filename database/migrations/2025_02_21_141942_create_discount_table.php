<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('coupon_code')->unique()->nullable();
            $table->text('coupon_description')->nullable();
            $table->string('discount_type')->nullable();
            $table->boolean('apply_all_services')->default(false);
            $table->decimal('coupon_amount', 10, 2)->nullable();
            $table->decimal('minimum_spend', 10, 2)->nullable();
            $table->decimal('maximum_spend', 10, 2)->nullable();
            $table->boolean('individual_use_only')->default(false);
            $table->boolean('exclude_sale_items')->default(false);
            $table->json('offerings')->nullable();
            $table->string('exclude_services')->nullable();
            $table->string('email_restrictions')->nullable();
            $table->integer('usage_limit_per_coupon')->nullable();
            $table->integer('usage_limit_to_x_items')->nullable();
            $table->integer('usage_limit_per_user')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
};
