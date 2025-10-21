<?php

namespace App\Livewire\User;

use Livewire\Component;

class Referrals extends DashboardLayout
{
    public function render()
    {
        $referrals = $this->user->directReferrals()->get();

        return view('livewire.user.referrals', compact('referrals'));
    }
}
