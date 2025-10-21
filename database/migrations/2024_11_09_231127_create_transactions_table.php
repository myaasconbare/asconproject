<?php

use App\Enums\Transaction;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('pre_balance', 28, 8)->default(0);
            $table->decimal('post_balance', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
            $table->enum('type', Transaction\Type::values())
                ->default(Transaction\Type::PLUS->value);
            $table->enum('wallet_type', Transaction\WalletType::values())
                ->default(Transaction\WalletType::DEPOSIT_WALLET->value);
            $table->enum('source', Transaction\Source::values())
                ->default(Transaction\Source::ALL->value);
            $table->string('details')->nullable();
            $table->string('transactionable_id')->nullable();
            $table->string('transactionable_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
