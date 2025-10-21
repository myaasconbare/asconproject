<?php

namespace App\Livewire\Traits;

use Illuminate\Support\Facades\Auth;

trait EnsureIsLoggedIn
{
    public function bootEnsureIsLoggedIn()
    {
        if(Auth::guest()) return to_route('guest.home');
    }
}
