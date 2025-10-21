<?php

namespace App\Livewire\Auth;

use App\Livewire\Auth\Forms\ForgotPasswordForm;
use App\Livewire\Guest\GuestLayout;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ForgotPassword extends GuestLayout
{
    use ActionRateLimiter, Notify;

    public ForgotPasswordForm $form;

    public function submit()
    {
        return $this->limit('forgotPassword', 'forgot-password-limit');
    }

    public function forgotPassword()
    {
        try {
            $this->form->validate();

            $user = User::where('email', $this->form->email)->first();

            if ($user) {
                resolve(UserService::class)->sendPasswordVerification($user);
            }
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        } catch (Exception $e) {
            return $this->notifyError($e->getMessage());
        }

        return $this->notifySuccess('The provided email address will receive an reset password mail if it\'s associated with any account');
    }

    public function render()
    {
        // return to_route('auth.login')->with('success', 'Password has been changed successfully, Enter your details below to login');

        return view('livewire.auth.forgot-password')
            ->title(config('app.name') . " - Forgot Password");
    }
}
