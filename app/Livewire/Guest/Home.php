<?php

namespace App\Livewire\Guest;

use App\Services\CoinGeckoService;
use Livewire\Component;

class Home extends GuestLayout
{
    public function mount(){
        // $coinGeckoService = new CoinGeckoService;

        // dd($coinGeckoService->getTopCryptoCurrencies(100));
        if(request()->query('reference')){
            session(['reference' => request()->get('reference')]);
        }
    }
    public function render()
    {
        return view('livewire.guest.home');
    }
}
