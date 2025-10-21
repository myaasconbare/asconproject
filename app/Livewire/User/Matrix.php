<?php

namespace App\Livewire\User;

use App\Services\MatrixService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Throwable;

class Matrix extends DashboardLayout
{
    
    public function render()
    {
        $matrixService = resolve(MatrixService::class);
        //  $matrixPlans = $matrixService->getPlans();
        $matrixEnrollment = $matrixService->getCurrentScheme(Auth::user());

        return view('livewire.user.matrix', compact('matrixEnrollment'));
    }
}
