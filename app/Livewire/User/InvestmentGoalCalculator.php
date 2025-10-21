<?php

namespace App\Livewire\User;

use App\Models\License;
use App\Models\Portfolio;
use App\Traits\ProfitRange;
use Illuminate\Support\Number;
use Livewire\Component;

class InvestmentGoalCalculator extends DashboardLayout
{
    use ProfitRange;

    public function render()
    {
        $portfolios = $this->portfolios;
        $licenses = $this->licenses;

        return view('livewire.user.investment-goal-calculator', ['portfolios' => $portfolios, 'licenses' => $licenses]);
    }
}
