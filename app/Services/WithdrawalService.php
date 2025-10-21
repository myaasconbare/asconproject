<?php

namespace App\Services;

use App\Models\User;
use App\Enums\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class WithdrawalService
{
    /**
     * Create a new class instance.
     */

    public function __construct()
    {
        //
    }

    public function validate($details, $user)
    {
        throw_if($user->{$details['selectedWallet']} < $details['amount'], 'Insufficient Wallet Balance');
    }

    public function initiateWithdrawal($details)
    {

        $this->validate($details, Auth::user());

        DB::transaction(function () use (&$payout, $details) {
            $user = User::active();

            $payout = $user->withdrawals()
                ->create([
                    'withdrawal_currency_id' => $details['currencyId'],
                    'transaction_id' => transactionId(),
                    'amount' => $details['amount'],
                    'user_wallet_address' => $details['walletAddress'],
                    'wallet' => $details['selectedWallet']
                ]);
            $preBalance = $user->{$details['selectedWallet']};

            $user->decrement($details['selectedWallet'], $payout->amount);


            $payout->transaction()->create([
                'user_id' => $user->id,
                'amount' => $details['amount'],
                'pre_balance' => $preBalance,
                'post_balance' => $user->deposit_wallet,
                'type' => Transaction\Type::PLUS,
                'source' => Transaction\Source::ALL,
                'details' => sprintf("%s Cashout request of", Number::currency($details['amount'])),
            ]);
        });
    }
}
