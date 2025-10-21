<?php

namespace App\Livewire\User;

use App\Enums\CommissionType;
use Livewire\Component;

class Commissions extends DashboardLayout
{
    public $commissionType = CommissionType::LEVEL->value;
    public string $title = "Level Commissionn";

    public function render()
    {
        return view('livewire.user.commissions');
    }
}
