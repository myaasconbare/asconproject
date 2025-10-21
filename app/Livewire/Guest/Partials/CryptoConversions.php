<?php

namespace App\Livewire\Guest\Partials;

use App\Models\CryptoCurrency;
use Livewire\Component;

class CryptoConversions extends Component
{
    public function render()
    {
        $currencies = CryptoCurrency::active()->limit(9)->get();

        return view('livewire.guest.partials.crypto-conversions', ['currencies' => $currencies]);
    }
}
