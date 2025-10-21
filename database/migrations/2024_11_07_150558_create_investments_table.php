<?php

use App\Enums\InvestmentStatus;
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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('reference_id')->unique();
            
            $table->foreignId('license_id')
                ->constrained('licenses')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('profitability_percentage')
                ->nullable();
            $table->decimal('minimum_interest_rate', 20)
                ->nullable();
            $table->decimal('maximum_interest_rate', 20)
                ->nullable();
            $table->string('transaction_id');
            $table->decimal('amount', 20);
            $table->string('interests_received')
                ->default(0.00);
            $table->integer('run_times')
                ->default(0);
            $table->integer('total_minutes');
            $table->integer('minutes_remaining');
            $table->enum('status', InvestmentStatus::values())
                ->default(InvestmentStatus::ACTIVE);
            $table->timestamp('last_payment')
                ->nullable();
            $table->timestamp('upcoming_payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
