<?php

namespace App\Livewire\Guest;

use App\Models\CryptoCurrency;
use Livewire\Component;

class Trade extends GuestLayout
{
    public function render()
    {
        $currencies = CryptoCurrency::active()->get();
        $topGainers = CryptoCurrency::active()->topGainers()->get();
        $topLosers = CryptoCurrency::active()->topLosers()->get();

        return view('livewire.guest.trade', ['topGainers' => $topGainers, 'topLosers' => $topLosers, 'currencies' => $currencies]);
    }
}
