<?php

namespace App\Livewire\User;

use App\Enums\ServerMessageTypes;
use App\Livewire\User\Forms\InvestmentForm;
use App\Models\Portfolio;
use App\Services\InvestmentService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Throwable;

class Investment extends DashboardLayout
{
    // use Notify, ActionRateLimiter;

    // public InvestmentForm $form;

    // public function submit(){
    //     return $this->limit('invest', 'invest-limit');
    // }

    // public function invest(){
    //     try {
    //         $this->form->validate();

    //         $investmentService = resolve(InvestmentService::class);

    //         $investmentService->invest($this->form->amount, $this->form->selectedPortfolio);

    //     } catch(ValidationException $e){
    //         return $this->notifyError($e->errors(), ServerMessageTypes::WARNING);
    //     } catch (Throwable $e){
    //         return $this->notifyError($e->getMessage(), ServerMessageTypes::WARNING);
    //     }

    //     return $this->notifySuccess('License successfully enrolled');
    // }

    public function render()
    {
        $portfolios = Portfolio::with(['licenses'])->where('is_active', true)->get();


        // dd( $portfolios[0]->least_plan->minimum_amount, $portfolios[0]->max_plan->maximum_amount_label, $portfolios[1]->max_plan->maximum_amount_label);

        return view('livewire.user.investment', compact('portfolios'));
    }
}
