<?php

use App\Enums\TradeOutcome;
use App\Enums\TradeStatus;
use App\Enums\TradeTypes;
use App\Enums\TradeVolume;
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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('crypto_currency_id')
                ->constrained('crypto_currencies')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->decimal('original_price', 28, 8)->default(0);
            $table->decimal('winning_amount', 28, 8)->default(0);
            $table->decimal('amount', 28, 8)->default(0);
            $table->integer('duration')->nullable();
            $table->string('period')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->enum('type', TradeTypes::values())
                ->default(TradeTypes::TRADE);
            $table->enum('volume', TradeVolume::values())
                ->default(TradeVolume::HIGH);
            $table->enum('outcome', TradeOutcome::values())->default(TradeOutcome::DRAW);
            $table->enum('status', TradeStatus::values())
                ->default(TradeStatus::RUNNING);
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
