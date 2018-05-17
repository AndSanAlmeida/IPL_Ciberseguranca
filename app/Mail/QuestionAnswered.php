<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuestionAnswered extends Mailable
{
    use Queueable, SerializesModels;

    public $mensagem;
    public $user;
    public $questionText;
    public $answerText;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensagem, $questionText, $answerText, $user)
    {
        $this->mensagem = $mensagem;
        $this->questionText = $questionText;
        $this->answerText = $answerText;
        $this->user = $user;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = 'Oficina de Cibersegurança';

        $subject = 'Questão Respondida';

        return $this->markdown('email.questionAnswered');
    }
}
