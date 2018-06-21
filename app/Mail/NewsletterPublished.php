<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsletterPublished extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $sendBy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $sendBy)
    {
        $this->message = $message;
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
        $subject = 'Nova Newsletter';
        $sendBy = $this->sendBy;

        return $this->from($sendBy, $name)->subject($subject)->markdown('email.newsletterPublished');
    }
}
