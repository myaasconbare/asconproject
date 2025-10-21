<?php

namespace App\Livewire\Auth\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ResetPasswordForm extends Form
{
    #[Validate(['required', 'min:6', 'same:passwordConfirmation'], message: [
        'password.required' => "New Password can't be empty",
        'password.min' => "New Password's length is too short",
        'password.same' => "Passwords doesn't match",

    ])]
    public string $password;

    #[Validate(['required'], message: [
        'passwordConfirmation.required' => "Repeat Password can't be empty",
    ])]
    public string $passwordConfirmation;

    #[Validate(
        rule: ['required', 'email'],
        attribute: 'Email Address',
        message: [
            'email.required' => ':attribute is required',
            'email.email' => 'The provided email address is not valid',
        ]
    )]
    public string $email = "";
}
