<?php

namespace App\Traits;

use App\Enums\ServerMessageTypes;
use App\Models\StakingPlan;
use App\Models\User;
use App\Services\InvestmentService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

trait WithStakeInvestment
{
    use Notify, ActionRateLimiter;

    #[Validate(['exists:staking_plans,id'], message: [
        'selectedPlanId.exists' => 'The Selected Plan is invalid!'
    ], as: "Plan")]
    public $selectedPlanId;

    #[Validate(['required', 'numeric'])]
    public $amount;

    #[Computed]
    public function investmentPlans()
    {
        return StakingPlan::all();
    }

    public function submit()
    {
        if (Auth::guest()) return to_route('auth.login');

        return $this->limit('invest', 'stake-invest-limiter');
    }

    public function invest()
    {
        try {
            $this->validate();

            $investmentService = resolve(InvestmentService::class);

            $investmentService->stake(
                planId: $this->selectedPlanId,
                amount: $this->amount,
                user: Auth::user()
            );
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        } catch (Throwable $e) {

            Log::error('unable to  stake investment', ['message' => $e->getMessage()]);

            return $this->notify($e->getMessage(), ServerMessageTypes::WARNING);
        }

        $this->notifySuccess('Staking Investment has been added successfully');
    }
}
