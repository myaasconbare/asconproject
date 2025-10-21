<?php

use App\Enums\Wallets;
use App\Enums\WithdrawalStatus;
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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')
            ->constrained('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
        $table->foreignId('withdrawal_currency_id')
            ->nullable()
            ->constrained('withdrawal_currencies')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
        $table->string('currency_name')->nullable();
        $table->string('transaction_id')->unique();
        $table->decimal('amount', 20);
        $table->decimal('final_amount')->nullable();
        $table->decimal('charge', 20)->default(0.00);
        $table->enum('wallet', Wallets::values());
        $table->string('user_wallet_address');
        $table->enum('status', WithdrawalStatus::values())
            ->default(WithdrawalStatus::PENDING);
        $table->json('payment_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
