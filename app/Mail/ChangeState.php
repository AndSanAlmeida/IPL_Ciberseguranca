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
    public $sendBy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensagem, $user, $sendBy)
    {
        $this->mensagem = $mensagem;
        $this->user = $user;
        $this->sendBy = $sendBy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = 'IPLeiria | Cibersegurança';
        $subject = 'Alteração no estado da sua conta';
        $sendBy = $this->sendBy;

        return $this->from($sendBy, $name)->subject($subject)->markdown('email.changestate');
    }
}
