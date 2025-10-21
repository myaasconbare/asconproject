<?php

namespace App\Livewire\User\Forms;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TwoFactorForm extends Form
{
    public $QRImage;

    #[Validate(['required', 'size:6'], message:[
        'otp.required' => 'Google Authentication code can\'t be empty',
        'otp.size' => 'Invalid Authentication code',
    ])]
    public ?string $otp = "";

    #[Locked]
    public $google2FASecret;

    public $google2fa;

    public bool $is2faEnabled;
}