<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Your Coffee Shop Invoice')
                    ->view('emails.invoice');
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Your Invoice from Coffee Shop',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.invoice',
        );
    }

    public function attachments()
    {
        return [];
    }
}
