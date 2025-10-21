<?php
 
namespace App\Livewire\User\Forms;
 
use Livewire\Attributes\Validate;
use Livewire\Form;
 
class TradeForm extends Form
{

    #[Validate(['required', 'numeric'])]
    public $amount;
    #[Validate(['required', 'exists:trade_durations,id'], message:[
        'duration.required' => 'Expiry Time is required',
        'duration.exists' => 'Invalid Expiry Time',
    ])]
    public $duration;

}
