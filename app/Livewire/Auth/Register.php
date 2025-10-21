<?php

namespace App\Livewire\Auth;

use App\Enums\ServerMessageTypes;
use App\Livewire\Auth\Forms\RegisterForm;
use App\Livewire\Guest\GuestLayout;
use App\Models\NotificationSetting;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Pest\Logging\TeamCity\ServiceMessage;
use Throwable;

class Register extends GuestLayout
{
    use ActionRateLimiter, Notify;

    public RegisterForm $form;

    public $userTimezone;

    public function mount(){
        // unset($this->referrer);
        // dd(session('reference'));
    }

    #[Computed]
    public function referrer(){
        return User::find(session('reference'));
    }

    public function submit()
    {        
        return $this->limit('handleRegistration', 'register-attempt');

    }

    public function handleRegistration()
    {

        try {
            $this->form->validate();

            $userService = new UserService;

            $user = $userService->create([
                'name' => $this->form->name,
                'email' => $this->form->email,
                'referrer_user_id' => $this->referrer?->id,
                'password' => $this->form->password,
                'timezone' => $this->userTimezone,
            ]);

            Auth::login($user);

            return to_route('user.dashboard');
            
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        } catch (Throwable $e) {
            return $this->notifyError("Something went wrong");
        }
    }


    public function render()
    {
        return view('livewire.auth.register')
            ->title(config('app.name') . " - Register");
    }
}
