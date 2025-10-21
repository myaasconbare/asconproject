<?php

namespace App\Livewire\User;

use App\Livewire\Traits\EnsureIsLoggedIn;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.trade")]
class TradeLayout extends Component
{
    use EnsureIsLoggedIn;

    #[Computed]
    public function user(){
        return User::find(Auth::id());
    }
}
