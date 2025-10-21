<?php

namespace App\Livewire\Guest\Partials;

use App\Models\CryptoCurrency;
use Livewire\Component;
use Livewire\WithPagination;

class CryptoPriceChanges extends Component
{
    use WithPagination;

    public function render()
    {
        $currencies = CryptoCurrency::active()
            ->paginate()
            ->withQueryString();
        $topGainers = CryptoCurrency::active()->topGainers()
            ->get();
        $topLosers = CryptoCurrency::active()->topLosers()
            ->get();

        return view('livewire.guest.partials.crypto-price-changes', ['topGainers' => $topGainers, 'topLosers' => $topLosers, 'currencies' => $currencies]);
    }
}
