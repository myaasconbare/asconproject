<?php

namespace App\Livewire\Auth;

use App\Enums\ServerMessageTypes;
use App\Livewire\Auth\Forms\LoginForm;
use App\Livewire\Guest\GuestLayout;
use App\Models\NotificationSetting;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use App\Traits\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Login extends GuestLayout
{
    use ActionRateLimiter, Notify;

    public LoginForm $form;


    public function submit(){
        return $this->limit('login', 'login-attempt');
    }

    public function login(){
        $user = User::Where('email', $this->form->email)->first();
        
        if(!password_verify($this->form->password, $user?->password)) {
            return $this->notifyError('These credentials do not match our records.');
        }

        if($user->is_suspended) {
            return $this->notifyError('Account suspended. Please contact customer support');
        }
        
        return resolve(UserService::class)->login($user, $this->form->rememeberMe);
    }

    public function render()
    {    
        return view('livewire.auth.login')
            ->title(config('app.name') . " - Login");
    }
}
