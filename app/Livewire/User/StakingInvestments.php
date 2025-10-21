<?php

namespace App\Livewire\User;

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
use Livewire\Component;
use Throwable;

class StakingInvestments extends DashboardLayout
{

    use WithStakeInvestment;

    public function render()
    {
        $investments = User::active()
            ->stakingInvestments()
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('livewire.user.staking-investments', compact('investments'));
    }
}
