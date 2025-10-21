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
        Schema::table('users', function (Blueprint $table) {


            // $table->foreignUuid('used_by')
            //     ->after('user_id')
            //     ->nullable()
            //     ->constrained('users')
            //     ->cascadeOnDelete()
            //     ->cascadeOnUpdate();

            // $table->string('interests_received')
            //     ->default(0.00)
            //     ->change();

            // $table->string('transactionable_id')->nullable()->change();

            // $table->integer('transactionable_id')->nullable()->change();
            // $table->string('transactionable_type')->nullable()->change();

            // $table->primary('id');

            // $table->renameColumn('expires_at', 'expires_at');

            $table->after('image', function($table) {
                $table->boolean('is_suspended')->default(false);
                
                // $table->decimal('paid', 20);
                 
                // $table->string('trade_wallet')->default(0.00);
                // $table->string('trade_practice_wallet')->default(0.00);

                // $table->boolean('is_2fa_enabled')->default(false);
                // $table->string('2fa_secret')->nullable();

                // $table->timestamp('completed_at')->nullable();

                // $table->string('address')->nullable();
                // $table->integer('total_minutes');
                // $table->integer('minutes_remaining');

                // $table->string('profitability_percentage')
                // ->nullable();
                // winning_amount
                // 
                // $table->timestamp('deleted_at');

            //     $table->string('min_deposit')
            //     ->nullable();

                // $table->integer('total_referrals')->default(0);
                // $table->float('timezone')->nullable();
                // $table->foreignId('reward_badge_id')
                // ->nullable()
                // ->constrained('reward_badges')
                // ->nullOnDelete()
                // ->cascadeOnUpdate();
                // $table->foreignUuid('referred_user_id')
                //     ->constrained('users')
                //     ->cascadeOnDelete()
                //     ->cascadeOnUpdate();
                // $table->string('referral_level');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
