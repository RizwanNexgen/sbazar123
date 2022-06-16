<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $email;

    public function __construct($email)
    {
        $this->email = $email; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    // {
    //     return $this->view('mail.forgetpassword');
    // }

     {
        return $this->from('noreply@sbazar.com', 'Sbazar')
            ->replyTo('noreply@sbazar.com', 'Sbazar')
            ->view('mail.forgetpassword')->with([

                'email' => $this->email,
              
            ]);
    }
}
