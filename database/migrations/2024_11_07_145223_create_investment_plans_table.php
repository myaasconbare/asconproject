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
        Schema::create('investment_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_recommended')->default(true);
            $table->boolean('is_fixed')->default(false);
            $table->boolean('is_unlimited')->default(false);
            // $table->enum('amount_type', ['fixed', 'range'])->default('range');
            $table->decimal('minimum_amount', 20)->nullable();
            $table->decimal('maximum_amount', 20)->nullable();
            $table->decimal('amount', 20)->nullable();
            $table->decimal('minimum_interest_rate', 20);
            $table->decimal('maximum_interest_rate', 20);
            $table->integer('duration');
            $table->enum('period', ['hours', 'days']);
            $table->json('features')->nullable();
            $table->text('terms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_plans');
    }
};
