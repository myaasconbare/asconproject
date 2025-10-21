<?php

use App\Enums\ProfitTypes;
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
        Schema::create('staking_profits', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('staking_investment_id')
                ->constrained('staking_investments')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('amount');
            $table->string('pre_balance')->nullable();
            $table->string('post_balance')->nullable();
            $table->string('details')->nullable();
            $table->enum('type', ProfitTypes::values());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staking_profits');
    }
};
