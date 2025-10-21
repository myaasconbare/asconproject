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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignId('reward_badge_id')
                ->nullable()
                ->constrained('reward_badges')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreignUuid('referrer_user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->integer('referral_level')->nullable();

            $table->string('image')->nullable();

            $table->boolean('is_2fa_enabled')->default(false);
            $table->boolean('is_suspended')->default(false);

            $table->string('2fa_secret')->nullable();

            $table->string('name')->nullable();
            $table->string('timezone')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('deposit_wallet')->default(0.00);
            $table->string('interest_wallet')->default(0.00);
            $table->string('residual_wallet')->default(0.00);

            $table->string('trade_wallet')->default(0.00);
            $table->string('trade_practice_wallet')->default(1000.00);

            $table->string('total_invested')->default(0.00);
            $table->string('total_profits')->default(0.00);
            $table->string('running_investment')->default(0.00);

            $table->string('matrix_commission')->default(0.00);
            $table->string('matrix_referral_commission')->default(0.00);
            $table->string('matrix_level_commission')->default(0.00);


            $table->decimal('total_trading', 20)->default(0.00);
            $table->decimal('winning_amount', 20)->default(0.00);
            $table->decimal('loss_amount', 20)->default(0.00);

            $table->decimal('total_deposited', 20)->default(0.00);
            $table->decimal('total_withdrawn', 20)->default(0.00);

            $table->decimal('investment_commission', 20)->default(0.00);
            $table->decimal('referral_commission', 20)->default(0.00);
            $table->decimal('level_commission', 20)->default(0.00);

            $table->string('direct_team_volume')->default(0.00);
            $table->string('total_team_volume')->default(0.00);

            $table->integer('total_direct_referrals')->default(0);
            $table->integer('total_referrals')->default(0);
            
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Schema::create('sessions', function (Blueprint $table) {
        //     $table->string('id')->primary();
        //     $table->foreignId('user_id')->nullable()->index();
        //     $table->string('ip_address', 45)->nullable();
        //     $table->text('user_agent')->nullable();
        //     $table->longText('payload');
        //     $table->integer('last_activity')->index();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
