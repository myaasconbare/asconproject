<?php

namespace App\Livewire\User\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class InstapinRechargeForm extends Form
{
    #[Validate(['required', 'exists:recharge_pins,number'], message: [
        'number.required' => 'Please enter a recharge pin',
        'number.exists' => 'Invalid Recharge Pin',
    ])]
    public $number;
}