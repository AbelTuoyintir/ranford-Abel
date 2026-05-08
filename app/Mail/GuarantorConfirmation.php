<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GuarantorConfirmation extends Mailable
{
      use Queueable, SerializesModels;

    public $supporter;
    public $nominee;
    public $confirmationUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($supporter, $nominee, $confirmationUrl)
    {
        $this->supporter = $supporter;
        $this->nominee = $nominee;
        $this->confirmationUrl = $confirmationUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirm Your Guarantor Approval')
                    ->view('email.guarantor_confirmation');
    }
}
