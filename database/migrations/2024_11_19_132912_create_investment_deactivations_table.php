<?php

use App\Enums\InvestmentDeactivationStatus;
use App\Models\InvestmentDeactivation;
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
        Schema::create('investment_deactivations', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('transaction_id');
            $table->foreignId('investment_id')
                ->constrained('investments')
                ->cascadeOnDelete();
            $table->string('amount');
            $table->enum('status', InvestmentDeactivationStatus::values())
                ->default(InvestmentDeactivationStatus::PENDING);
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('declined_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_deactivations');
    }
};
