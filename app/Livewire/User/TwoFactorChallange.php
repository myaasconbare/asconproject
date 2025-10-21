<?php

namespace App\Livewire\User;

use App\Livewire\Guest\GuestLayout;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TwoFactorChallange extends GuestLayout
{
    use Notify, ActionRateLimiter;

    #[Validate(['required', 'size:6'], message: [
        'twoFactorCode.required' => 'Verification code can\'t be empty',
        'twoFactorCode.size' => 'The provided two factor authentication code was invalid.',
    ])]
    public $twoFactorCode = "";


    public function mount()
    {
        // dd( session('user_id'));
        if (!session('user_id')) return to_route('auth.login');
    }

    public function logout()
    {
        Auth::logout(Auth::user());
        return to_route('guest.home');
    }

    public function submit()
    {
        if (Auth::guest()) return to_route('auth.login')->with('expired', 'Session expired. Please login to continue');
        return $this->limit('verify', 'verify-limit');
    }

    public function verify()
    {
        try {
            $this->validate();

            $userService = new UserService;

            $isValid2FACode = $userService->isValid2FACode([
                'user_id' => Auth::id(),
                'code' => $this->twoFactorCode,
                '2fa_secret' => Auth::user()->{'2fa_secret'},
            ]);


            if (!$isValid2FACode) {
                return $this->notifyError('The provided two factor authentication code was invalid.');
            }

            $isValidUser = User::where('id', session('user_id'))->exists();

            if (!$isValidUser) return to_route('auth.login');

            session(['two_factor_verified' => true]);

            return to_route('user.dashboard');
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        }
    }


    public function render()
    {
        return view('livewire.user.two-factor-challange');
    }
}
