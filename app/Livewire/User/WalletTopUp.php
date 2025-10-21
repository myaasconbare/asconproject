<?php

namespace App\Livewire\User;

use App\Enums\Transaction\WalletType;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

class WalletTopUp extends DashboardLayout
{
    use ActionRateLimiter, Notify;

    #[Validate(['required', 'in:trade_wallet'], message: [
        'wallet.required' => 'Wallet is required',
        'wallet.in' => 'Invalid Wallet!',
    ])]
    public $wallet;

    #[Validate(['required', 'numeric'], message: [
        'amount.required' => 'Please enter amount',
        'amount.numeric' => 'Invalid amount',
    ])]
    public $amount;

    public function submit()
    {
        return $this->limit('topUp', 'top-up-limit');
    }
    public function topUp()
    {
        try {

            DB::transaction(function () {
                $this->validate();

                $wallet = WalletType::from($this->wallet)->value;

                $this->user->decrement('deposit_wallet', $this->amount);

                $this->user->increment($wallet, $this->amount);
            });
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        } catch (Throwable $e) {
            return $this->notifyError("Unable to top up selected wallet");
        }

        return $this->notifySuccess("Wallet topped up successfully");
    }

    public function render()
    {
        return view('livewire.user.wallet-top-up');
    }
}
