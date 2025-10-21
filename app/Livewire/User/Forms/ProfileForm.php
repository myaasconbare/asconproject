<?php

namespace App\Livewire\User\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProfileForm extends Form
{
    #[Validate(['required'])]
    public $firstname;

    #[Validate(['required'])]
    public $lastname;

    #[Validate(['required'])]
    public $phone;

    #[Validate(['required', 'email'])]
    public $email;

    public $address;

    public $country;
    public $city;
    public $postcode;
    public $state;


    public function fillInputs()
    
    {
        // parent::__construct();

        $this->fill([
            "firstname" => Auth::user()->firstname,
            "lastname" => Auth::user()->lastname,
            "phone" => Auth::user()->phone,
            "email" => Auth::user()->email,
            "address" => Auth::user()->address,
            "country" => Auth::user()->country,
            "city" => Auth::user()->city,
            "postcode" => Auth::user()->postcode,
            "state" => Auth::user()->state,
        ]);
    }

}