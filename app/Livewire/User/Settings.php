<?php

namespace App\Livewire\User;

use App\Livewire\User\Forms\ProfileForm;
use App\Livewire\User\Forms\SecurityForm;
use App\Livewire\User\Forms\TwoFactorForm;
use App\Services\UserService;
use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Throwable;

class Settings extends DashboardLayout
{
    use ActionRateLimiter, Notify;
    use WithFileUploads;

    public ProfileForm $profile;
    public SecurityForm $security;
    public TwoFactorForm $twoFactor;

    #[Validate(['required', 'image', 'max:5120'])]
    public $image;

    const SECURITY_ACTION = "security";
    const PROFILE_ACTION = "profile";

    #[Computed]
    public function google2FA()
    {
        return app('pragmarx.google2fa');
    }

    public function updateImage()
    {
        $image = $this->image->store('avatar', 'public');

        $this->user->update([
            'image' => $image,
        ]);

        unset($this->user);

        Auth::user()->refresh();

        return ['success' => true, 'message' => 'Changes saved successfully', 'url' => Auth::user()->image_url];
    }

    public function mount()
    {
        $this->profile->fillInputs();

        $this->twoFactor->google2FASecret = Auth::user()->{'2fa_secret'} ?
            Auth::user()->{'2fa_secret'}  :
            $this->google2FA->generateSecretKey();
        $this->twoFactor->is2faEnabled = $this->user->is_2fa_enabled;
    }

    public function handleUser2FA()
    {
        try {
            $this->twoFactor->validate();

            $userService = new UserService();

            $secret = $this->twoFactor->google2FASecret;

            $isValid2FACode = $userService->isValid2FACode([
                'user_id' => Auth::id(),
                'code' => $this->twoFactor->otp,
                '2fa_secret' => $secret,
            ]);

            if (!$isValid2FACode) return $this->notifyError('Wrong verification code!');

            $this->user->update([
                'is_2fa_enabled' =>  !$this->user->is_2fa_enabled,
                '2fa_secret' => $secret,
            ]);

            session(['two_factor_verified' => true]);

            $this->reset('twoFactor.otp');

            $this->twoFactor->is2faEnabled = $this->user->is_2fa_enabled;

            Auth::user()->refresh();
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        }

        return $this->notifySuccess(sprintf("Google Authentication has been %s", ($this->user->is_2fa_enabled ? 'enabled' : 'disabled')));
    }

    public function submit($action)
    {
        if (!in_array($action, [self::SECURITY_ACTION, self::PROFILE_ACTION]))
            return $this->notifyError('Action not recognized');

        return $this->limit('handleSettings', 'settings-limit', params: $action);
    }

    public function handleSettings($action)
    {
        try {

            $userService = resolve(UserService::class);

            switch ($action) {
                case self::SECURITY_ACTION: {
                        $this->security->validate();
                        $userService->updatePassword(Auth::user(), $this->security->all());
                    };
                    break;
                case self::PROFILE_ACTION: {
                        $this->profile->validate();
                        $userService->updateProfileInfo(Auth::user(), $this->profile->all());
                    };
            };
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        } catch (Throwable $e) {
            return $this->notifyError($e->getMessage());
        }

        return $this->notifySuccess('Updated successfuly');
    }


    public function render()
    {
        $countries = config('countries-list');

        return view('livewire.user.settings', compact('countries'));
    }
}
