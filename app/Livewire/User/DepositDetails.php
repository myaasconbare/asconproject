<?php

namespace App\Livewire\User;

use App\Models\Deposit;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DepositDetails extends DashboardLayout
{
    public $transactionId;

    public function mount($transactionId){
        // transactionId
        if(!$this->transactionId) return to_route('user.dashboard');
    }

    #[Computed]
    public function deposit(){
        return Deposit::where('transaction_id', $this->transactionId)->first();
    }
    public function render()
    {
        return view('livewire.user.deposit-details');
    }
}
