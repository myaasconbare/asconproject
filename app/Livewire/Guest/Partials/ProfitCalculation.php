<?php

namespace App\Livewire\Guest\Partials;

use App\Models\Portfolio;
use App\Traits\ProfitRange;
use Livewire\Component;

class ProfitCalculation extends Component
{
    use ProfitRange;

    public function render()
    {
        $portfolios = $this->portfolios;
        $licenses = $this->licenses;

        return view('livewire.guest.partials.profit-calculation', ['portfolios' => $portfolios, 'licenses' => $licenses]);
    }
}
