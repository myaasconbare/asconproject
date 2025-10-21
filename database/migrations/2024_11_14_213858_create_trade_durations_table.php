<?php

use App\Enums\TradePeriods;
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
        Schema::create('trade_durations', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')
                ->default(true);
            $table->integer('duration');
            $table->enum('period', TradePeriods::values());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_durations');
    }
};
