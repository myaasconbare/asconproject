<?php

namespace App\Livewire\User;

use App\Models\CryptoCurrency;
use Livewire\Component;
use Livewire\WithPagination;

class Trade extends DashboardLayout
{
    use WithPagination;

    public function render()
    {
        $currencies = CryptoCurrency::paginate(20)
        ->withQueryString();
        // dd($currencies);

        return view('livewire.user.trade', compact('currencies'));
    }
}
