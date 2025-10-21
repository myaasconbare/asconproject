<?php

namespace App\Livewire;

use App\Enums\ServerMessageTypes;
use App\Livewire\User\Forms\InvestmentForm;
use App\Models\Portfolio;
use App\Services\InvestmentService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Throwable;

class InvestmentPlansList extends Component
{
    use Notify, ActionRateLimiter;

    public InvestmentForm $form;

    public function submit()
    {
        if (Auth::guest()) return to_route('auth.login');

        return $this->limit('invest', 'invest-limit');
    }

    public function invest()
    {
        try {
            $this->form->validate();

            $investmentService = resolve(InvestmentService::class);

            $investmentService->invest($this->form->amount, $this->form->selectedPortfolio);
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors(), ServerMessageTypes::WARNING);
        } catch (Throwable $e) {
            return $this->notifyError($e->getMessage(), ServerMessageTypes::WARNING);
        }

        return $this->notifySuccess('License successfully enrolled');
    }

    public function render()
    {
        $portfolios = Portfolio::with(['licenses'])->where('is_active', true)->get();

        return view('livewire.investment-plans-list', ['portfolios' => $portfolios]);
    }
}
