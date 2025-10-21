<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;

class Transactions extends DashboardLayout
{
    use WithPagination;

    public function render()
    {
        return view('livewire.user.transactions');
    }
}
