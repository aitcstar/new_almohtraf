<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $title;
    public $email;
    public $username;
    public $company_name;

    public function __construct($title, $email , $username ,$company_name)
    {
        $this->title = $title;
        $this->email= $email;
        $this->username= $username;
        $this->company_name= $company_name;
    }

    public function build()
    {
        return $this->subject($this->title)
        ->view('frontend.mail.customer-mail');
    }
}
