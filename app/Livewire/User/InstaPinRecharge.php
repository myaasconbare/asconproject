<?php

namespace App\Livewire\User;

use App\Livewire\User\Forms\InstapinGenerateForm;
use App\Livewire\User\Forms\InstapinRechargeForm;
use App\Models\RechargePin;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use App\Enums\Transaction;
use App\Enums\Transaction\WalletType;
use Illuminate\Support\Facades\DB;

class InstaPinRecharge extends DashboardLayout
{
    use WithPagination, Notify, ActionRateLimiter;


    public InstapinGenerateForm $instaPinGenerateForm;

    public InstaPinRechargeForm $instaPinRechargeForm;

    public function submitRechargeForm()
    {

        return $this->limit('rechargePin', 'recharge-pin-limit');
    }

    public function rechargePin()
    {
        try {

            $this->instaPinRechargeForm->validate();

            $rechargePin = RechargePin::where('number', $this->instaPinRechargeForm->number)->first();

            if ($rechargePin->used_at) return $this->notifyError("Pin has already been used");

            $preBalance = $this->user->deposit_wallet;

            $this->user->increment('deposit_wallet', $rechargePin->amount);

            $rechargePin->update([
                'used_at' => now(),
                'used_by' => Auth::id(),
            ]);

            $rechargePin->transaction()->create([
                'user_id' => $this->user->id,
                'amount' => $rechargePin->amount,
                'pre_balance' => $preBalance,
                'post_balance' => $this->user->deposit_wallet,
                'type' => Transaction\Type::PLUS,
                'wallet_type' => WalletType::DEPOSIT_WALLET,
                'source' => Transaction\Source::ALL,
                'details' => 'Recharged an E-Pin Worth ' . Number::currency($this->instaPinGenerateForm->amount),
            ]);
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        }

        return $this->notifySuccess('E pin recharged successfully');
    }


    public function submitGenerateForm()
    {

        return $this->limit('generatePin', 'generate-pin-limit');
    }

    public function generatePin()
    {

        try {

            $this->instaPinGenerateForm->validate();

            if ($this->user->deposit_wallet < $this->instaPinGenerateForm->amount) return $this->notifyError('Insufficient Deposit Wallet');


            DB::transaction(function () {
                $preBalance = $this->user->deposit_wallet;

                $this->user->decrement('deposit_wallet', $this->amount);

                $details = 'Generated an E-Pin Worth ' . Number::currency($this->instaPinGenerateForm->amount);

                $rechargePin = $this->user->rechargePins()->create([
                    'details' => $details,
                    'amount' => $this->instapinGenerateForm->amount,
                    'number' => Str::orderedUuid(),
                ]);

                $rechargePin->transaction()->create([
                    'user_id' => $this->user->id,
                    'amount' => $rechargePin->amount,
                    'pre_balance' => $preBalance,
                    'wallet_type' => WalletType::DEPOSIT_WALLET,
                    'post_balance' => $this->user->deposit_wallet,
                    'type' => Transaction\Type::MINUS,
                    'source' => Transaction\Source::ALL,
                    'details' => $details,
                ]);
            });
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        }

        return $this->notifySuccess('E pin generated successfully');
    }

    public function render()
    {
        $pins = $this->user->rechargePins()
            ->paginate()
            ->withQueryString();

        return view('livewire.user.insta-pin-recharge', ['pins' => $pins]);
    }
}
