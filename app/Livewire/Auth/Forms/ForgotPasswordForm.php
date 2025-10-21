<?php
 
namespace App\Livewire\Auth\Forms;
 
use Livewire\Attributes\Validate;
use Livewire\Form;
 
class ForgotPasswordForm extends Form
{
    #[Validate( 
        rule:['required', 'email'], 
        attribute:'Email Address', 
        message:[
            'email.required' => ':attribute is required',
            'email.email' => 'The provided email address is not valid',
        ]
    )]
    public string $email = "nobledsmarts@gmail.com";
}
