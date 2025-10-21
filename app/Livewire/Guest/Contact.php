<?php

namespace App\Livewire\Guest;

use App\Traits\ActionRateLimiter;
use App\Traits\Notify;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Contact extends GuestLayout
{
    use ActionRateLimiter, Notify;

    #[Validate(['required', 'email'])]
    public $email;

    #[Validate('required')]
    public $message;

    #[Validate('required')]
    public $subject;

    public function submit(){
        return $this->limit('contact', 'contact-limit');
    }

    public function contact()
    {
        try {
            $this->validate();
          
            $email = $this->email;
            $message = $this->message;
            $subject = $this->subject;


            // dispatch(function() use($fullname, $email, $message, $subject) {
            //     Mail::to(config('app.support_mail'))->send(new MailContactMail([
            //         'fullname' => $fullname,
            //         'email' => $email,
            //         'message' => $message,
            //         'subject' => $subject,
            //     ]));
            // })->afterResponse();
        } catch (ValidationException $e) {
            return $this->notifyError($e->errors());
        }

        $this->reset();

        return $this->notifySuccess('Mail has been sent');
    }


    public function render()
    {
        return view('livewire.guest.contact');
    }
}
