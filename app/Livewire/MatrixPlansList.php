<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\MatrixService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Exception;
use Illuminate\Support\Facades\Auth;
use Throwable;


class MatrixPlansList extends Component
{
    use ActionRateLimiter, Notify;

    public $selectedPlanId; 

    public function submit(){
        return $this->limit('matrixEnroll', 'matrix-enroll-attempt');
    }

    public function matrixEnroll(){
        $matrixService = resolve(MatrixService::class);
        try {
            $matrixService->enrollUser($this->selectedPlanId, Auth::user());
        } catch (Throwable $e) {
            return $this->notifyError($e->getMessage());
        }

        $this->notifySuccess('The Matrix Scheme has been enrolled');
    }


    public function render()
    {
        $matrixService = resolve(MatrixService::class);
        $matrixPlans = $matrixService->getPlans();
        $martixSettings = $matrixService->getMatrixSettings();

        return view('livewire.matrix-plans-list', ['matrixPlans' => $matrixPlans, 'matrixService' => $matrixService, 'martixSettings' => $martixSettings]);
    }
}
