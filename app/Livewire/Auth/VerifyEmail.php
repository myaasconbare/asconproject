<?php

namespace App\Livewire\Auth;

use App\Enums\ServerMessageTypes;
use App\Livewire\Guest\GuestLayout;
use App\Livewire\Traits\EnsureIsLoggedIn;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class VerifyEmail extends GuestLayout
{
    use EnsureIsLoggedIn;
    
    public function logout(){
        Auth::logout();
        return to_route('guest.home');
    }

    public function submit(){

        if (RateLimiter::tooManyAttempts('verify-email-attempt:' . request()->ip(), $perMinute = 5)) {
            $seconds = RateLimiter::availableIn('verify-email-attempt:' . request()->ip());

            return $this->dispatch('server-message', [
                'type' => ServerMessageTypes::ERROR,
                'payload' =>  'Too many requests.. You may try again in ' . $seconds . ' seconds.'
            ]);
        }

        RateLimiter::increment('verify-email-attempt:' . request()->ip());

        return $this->resendVerification();
    }

    public function resendVerification(){
        $userService = new UserService;

        $userService->sendVerification(Auth::user());
    }

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
