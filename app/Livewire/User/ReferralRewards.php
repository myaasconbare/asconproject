<?php

namespace App\Livewire\User;

use App\Enums\CommissionType;
use App\Models\User;
use App\Traits\withTransactions;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ReferralRewards extends DashboardLayout
{

    public $commissionType = CommissionType::REFERRAL->value;
    public string $title = "Referral Commissionn";

    public function render()
    {
        return view('livewire.user.referral-rewards');
    }
}
