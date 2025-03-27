<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('offering_id')->nullable()->constrained('offerings')->onDelete('cascade');
            $table->enum('feedback_type', ['practitioner', 'offering']); // Added this column
            $table->text('comment');
            $table->integer('rating')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};

