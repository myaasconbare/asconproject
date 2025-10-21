<?php

namespace App\Livewire\User\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class InvestmentForm extends Form
{
    #[Validate(['required', 'numeric'], message: [
        'amount.required' => 'Please enter amount',
        'amount.numeric' => 'Invalid amount',
    ])]
    public $amount;

    // #[Validate(['required', 'exists:licenses,id'], attribute:'currency')]
    // public $selectedLicense;

    #[Validate(['required', 'exists:portfolios,id'], attribute:'Portfolio')]
    public $selectedPortfolio;
}