<?php
 
namespace App\Livewire\Auth\Forms;
 
use Livewire\Attributes\Validate;
use Livewire\Form;
 
class RegisterForm extends Form
{
    #[Validate( 
        rule:['required', 'email', 'unique:users,email'], 
        attribute:'Email Address', 
        message:[
            'email.required' => ':attribute is required',
            'email.email' => 'The provided email address is not valid',
            'email.unique' => 'An account with this email already exists',
        ]
    )]
    public string $email = "";

    #[Validate( 
        rule:['required'], 
        message:[
            'name.required' => 'Please enter your name',
        ]
    )]
    public string $name = "";



    #[Validate( 
        rule:['required', 'confirmed', 'min:6'], 
        message:[
            'password.required' => 'Password can\'t be empty',
            'password.min' => 'Password length is too short',
            'password.confirmed' => 'Passwords doesn\'t match',
        ]
    )]
    public string $password = "";
    public string $password_confirmation = "";


    public $userTimezone = "";

}
