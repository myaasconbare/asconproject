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
        Schema::create('matrix_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('matrix_plan_id')
                ->constrained('matrix_plans')
                ->cascadeOnDelete();
            $table->string('transaction_id');
            $table->decimal('amount', 20);
            $table->decimal('referral_commission', 20)->default(0.00);
            $table->decimal('level_commission', 20)->default(0.00);
            $table->enum('status', ['running', 'closed'])->default('running');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matrix_enrollments');
    }
};
