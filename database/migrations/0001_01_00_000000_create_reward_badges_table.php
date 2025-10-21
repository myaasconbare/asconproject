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
        Schema::create('reward_badges', function (Blueprint $table) {
            $table->id();
            $table->integer('level');
            $table->string('name');
            $table->decimal('minimum_invest', 20);
            $table->decimal('minimum_team_invest', 20);
            $table->decimal('minimum_deposit', 20);
            $table->integer('minimum_referral_count');
            $table->decimal('reward', 20);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_badges');
    }
};
