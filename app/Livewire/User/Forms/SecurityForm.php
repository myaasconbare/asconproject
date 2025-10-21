<?php
 
namespace App\Livewire\User\Forms;
 
use Livewire\Attributes\Validate;
use Livewire\Form;
 
class SecurityForm extends Form
{

    #[Validate(['required', 'current_password'])]
    public string $current_password = "";

    #[Validate( 
        rule:['required', 'confirmed', 'min:6'], 
        message:[
            'password.required' => 'Password can\'t be empty',
            'password.min' => 'Password length is too short',
            'password.confirmed' => 'Passwords doesn\'t match',
        ]
    )]
    public string $password = "password";
    public string $password_confirmation = "password";

}
