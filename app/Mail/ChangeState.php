<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeState extends Mailable
{
    use Queueable, SerializesModels;

    public $mensagem;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensagem, $user)
    {
        $this->mensagem = $mensagem;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = 'Administração';

        $subject = 'Alteração no estado da sua conta';

        return $this->markdown('email.changestate');
    }
}
