<?php

namespace App\Livewire;

use Livewire\Component;

use App\Enums\ServerMessageTypes;
use App\Models\StakingPlan;
use App\Models\User;
use App\Services\InvestmentService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use App\Traits\WithStakeInvestment;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Throwable;


class StakingInvestmentPlansList extends Component
{
    use WithStakeInvestment;

    public function render()
    {
        return view('livewire.staking-investment-plans-list');
    }
}
