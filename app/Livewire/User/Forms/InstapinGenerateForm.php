<?php

namespace App\Livewire\User\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class InstapinGenerateForm extends Form
{
    #[Validate(['required', 'numeric'], message: [
        'amount.required' => 'Please enter amount',
        'amount.numeric' => 'Invalid amount',
    ])]
    public $amount;
}