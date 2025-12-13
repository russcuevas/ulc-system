<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $fullname;

    public function __construct($url, $fullname)
    {
        $this->url = $url;
        $this->fullname = $fullname;
    }

    public function build()
    {
        return $this->subject('Account Verification')
                    ->view('emails.admin_verify');
    }
}
