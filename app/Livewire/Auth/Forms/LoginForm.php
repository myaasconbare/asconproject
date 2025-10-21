<?php
 
namespace App\Livewire\Auth\Forms;
 
use Livewire\Attributes\Validate;
use Livewire\Form;
 
class LoginForm extends Form
{
    public string $email = "";
    public string $password = "";
    public bool $rememeberMe = false;
}
