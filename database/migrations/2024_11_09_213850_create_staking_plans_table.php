<?php

use App\Enums\Periods;
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
        Schema::create('staking_plans', function (Blueprint $table) {
            $table->id();
            $table->string('duration');
            $table->decimal('interest_rate', 20);
            $table->decimal('minimum_amount', 20);
            $table->decimal('maximum_amount', 20);
            $table->enum('period', Periods::values());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staking_plans');
    }
};
