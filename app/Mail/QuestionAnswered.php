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
    public $sendBy;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensagem, $questionText, $answerText, $user, $sendBy)
    {
        $this->mensagem = $mensagem;
        $this->questionText = $questionText;
        $this->answerText = $answerText;
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
        $subject = 'Questão Respondida';
        $sendBy = $this->sendBy;

        return $this->from($sendBy, $name)->subject($subject)->markdown('email.questionAnswered');
    }
}
