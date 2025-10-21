<?php

namespace App\Livewire\Auth;

use App\Livewire\Auth\Forms\ResetPasswordForm;
use App\Livewire\Guest\GuestLayout;
use App\Models\VerificationToken;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

class ResetPassword extends GuestLayout
{
    use ActionRateLimiter, Notify;

    public ResetPasswordForm $form;

    #[Locked]
    public $token;


    #[Computed]
    public function verificationToken()
    {
        return VerificationToken::with('user')
            ->where('code', $this->token)->first();
    }

    public function submit()
    {
        return $this->limit('changePassword', 'change-password-limit');
    }

    public function changePassword()
    {
        $verificationToken = $this->verificationToken;

        if (!$verificationToken || $this->verificationToken->user->email !== $this->form->email) 
            return $this->notifyError('This password reset token is invalid');

        $tokenExpiryTime = config('auth.passwords.users.expire');

        if (now()->isAfter($verificationToken->created_at->addMinutes($tokenExpiryTime)))
            return $this->notifyError('Token has expired');

        try {
            $this->validate();

            $this->verificationToken->user->password = Hash::make($this->form->password);
            $this->verificationToken->user->save();

            $this->verificationToken->delete();

        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        } catch (Throwable $e) {
            Log::info('unable to reset password', ['message' => $e->getMessage()]);

            return $this->notifyError("Something went wrong");
        }

        return to_route('auth.login')->with('success', 'Password has been changed successfully, Enter your details below to login');
    }

    public function mount($token = null)
    {
       
    }


    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
