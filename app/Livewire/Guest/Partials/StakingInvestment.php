<?php

namespace App\Livewire\Guest\Partials;

use App\Traits\WithStakeInvestment;
use Livewire\Component;

class StakingInvestment extends Component
{
    use WithStakeInvestment;
    
    public function render()
    {
        return view('livewire.guest.partials.staking-investment');
    }
}
