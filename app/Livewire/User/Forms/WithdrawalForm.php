<?php

namespace App\Livewire\User\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class WithdrawalForm extends Form
{
    #[Validate(['required', 'numeric'], message: [
        'amount.required' => 'Please enter withdrawal amount',
        'amount.numeric' => 'Invalid amount',
    ])]
    public $amount;

    #[Validate(['required'], message: [
        'walletAddress.required' => 'Please enter your wallet address'
    ])]
    public $walletAddress;

    #[Validate(['required', 'exists:withdrawal_currencies,id'], message: [
        'currencyId.required' => 'Please choose currency',
        'currencyId.exists' => 'Selected currency not recognized',
    ])]
    public $currencyId;

    #[Validate(['required', 'in:deposit_wallet,interest_wallet'], message: [
        'selectedWallet.required' => 'Please choose a wallet',
        'selectedWallet.in' => 'Selected wallet not recognized',
    ])]
    public $selectedWallet;

}