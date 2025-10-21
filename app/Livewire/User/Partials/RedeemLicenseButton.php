<?php

namespace App\Livewire\User\Partials;

use App\Services\InvestmentService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Livewire\Component;

class RedeemLicenseButton extends Component
{
    use Notify, ActionRateLimiter;

    public function submit()
    {
        return $this->limit('redeem', 'redeem-limit');
    }

    public function redeem()
    {

        try {
            $totalLicensesAffected = resolve(InvestmentService::class)->redeemLicense(Auth::user());

            return $this->notifySuccess(sprintf("%s Successfully redeemed", $totalLicensesAffected));
        } catch (Exception $e) {
            return $this->notifyError($e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.user.partials.redeem-license-button');
    }
}
