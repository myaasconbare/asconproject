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
        Schema::create('matrix_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('amount', 20);
            $table->decimal('referral_reward', 20);
            $table->boolean('is_active');
            $table->boolean('is_recommended')->default(false);
            $table->json('commission');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matrix_plans');
    }
};
