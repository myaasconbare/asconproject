<?php

namespace App\Livewire\Guest\Partials;

use App\Models\CryptoCurrency;
use Livewire\Component;

class CurrencySection extends Component
{
    public function render()
    {
        $currencies = CryptoCurrency::where('is_active', true)->take(10)->get();

        return view('livewire.guest.partials.currency-section', ['currencies' => $currencies]);
    }
}
