<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $url;
    public $sendBy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $sendBy)
    {
        $this->user = $user;
        $this->sendBy = $sendBy;
        $this->url = url('/user/'.$user->id.'/confirmation/'.$user->email_token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = 'IPLeiria | Cibersegurança';
        $subject = 'Ativação de conta';
        $sendBy = $this->sendBy;

        return $this->from($sendBy, $name)->subject($subject)->markdown('email.activateaccount');
    }
}
