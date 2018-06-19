<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->url = url('/user/'.$user->id.'/confirmation/'.$user->email_token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $name = 'IPL-Cibersegurança';

        $subject = 'Ativação de conta';

        return $this->subject('Ativação de Conta')->markdown('email.activateaccount');
    }
}
