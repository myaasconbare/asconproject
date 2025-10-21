<?php

use App\Enums\StakingInvestmentStatus;
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
        Schema::create('staking_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('staking_plan_id')
                ->nullable()
                ->constrained('staking_plans')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->decimal('amount', 20);
            $table->decimal('interest', 20);
            $table->decimal('total_return')->nullable();
            $table->enum('status', StakingInvestmentStatus::values())
                ->default(StakingInvestmentStatus::RUNNING);
            $table->timestamp('next_interest_date')->nullable();
            $table->timestamp('last_interest_date')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paused_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staking_investments');
    }
};
