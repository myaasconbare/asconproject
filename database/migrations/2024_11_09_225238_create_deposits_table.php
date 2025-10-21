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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('currency')->nullable();
            $table->string('network')->nullable();
            $table->string('pay_amount')->nullable();
            $table->string('destination_wallet_address')->nullable();
            $table->string('sender_wallet_address')->nullable();
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 20);
            // $table->decimal('paid', 20);
            $table->decimal('charge', 20)->default(0.00);
            $table->enum('status', Transaction\Status::values())
                ->default(Transaction\Status::PENDING);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('deposits');
    }
};
