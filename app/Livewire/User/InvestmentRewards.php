<?php

namespace App\Livewire\User;

use App\Actions\RewardBadgeAction;
use App\Models\RewardBadge;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class InvestmentRewards extends DashboardLayout
{
    public function mount(){
    //    DB::beginTransaction();

        // (new RewardBadgeAction(auth()->user()))->execute();

    }

    public function render()
    {
        $rewardBadges = RewardBadge::withActive()->get();

        return view('livewire.user.investment-rewards', compact('rewardBadges'));
    }
}
