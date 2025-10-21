<?php

namespace App\Livewire\User;

use App\Services\InvestmentService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class ActiveInvestment extends DashboardLayout
{
    use WithPagination, Notify, ActionRateLimiter;

    const REQUEST_END_LICENSE = "requestEndLicense";
    const CANCEL_TERMINATION = "cancelTermination";

    const ACTIONS = [self::REQUEST_END_LICENSE, self::CANCEL_TERMINATION];

    public function submit($investmentId = null, $action = null)
    {

        if (!in_array($action, self::ACTIONS)) return;

        return $this->limit('handleSubmit', 'limit-submit-action', params: func_get_args());
    }


    public function handleSubmit($investmentId, $action)
    {

        $investmentService = resolve(InvestmentService::class);

        
        try {
            $user = Auth::user();
            $handle = match ($action) {
                self::CANCEL_TERMINATION => [
                    $investmentService->cancelTermination($user, $investmentId),
                    'License Termination cancelled successfully'
                ],
                self::REQUEST_END_LICENSE => [
                    $investmentService->requestEndLicense($user, $investmentId),
                    'Batch License Deactivation has been requested successfully',
                ],
            };
        } catch (Throwable $e) {
            return $this->notifyError($e->getMessage());
        }

        return $this->notifySuccess($handle[1]);
    }

    public function render()
    {
        $investments = $this->user
            ->investments()
            ->where(function ($query) {
                $query->active()
                    ->orWhere(fn($query) => $query->pendingDeactivation());
            })
            ->paginate()
            ->withQueryString();

        return view('livewire.user.active-investment', compact('investments'));
    }
}
