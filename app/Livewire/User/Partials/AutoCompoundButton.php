<?php

namespace App\Livewire\User\Partials;

use App\Services\InvestmentService;
use App\Services\UserService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Livewire\Component;
use Throwable;

class AutoCompoundButton extends Component
{
    use Notify, ActionRateLimiter;

    public function submit(){
        return $this->limit('compound', 'compound-limit');
    }

    public function compound(){
        $user = Auth::user();

        $interestToCompound = $user->interest_wallet + $user->residual_wallet;

        try {
            resolve(InvestmentService::class)->autoCoumpound($user);
        }
        catch(Exception $e) {
            return $this->notifyError($e->getMessage());
        } 

        return $this->notifySuccess(sprintf("%s Successfully added to active license", Number::currency($interestToCompound)));
    }

    public function render()
    {
        return view('livewire.user.partials.auto-compound-button');
    }
}
