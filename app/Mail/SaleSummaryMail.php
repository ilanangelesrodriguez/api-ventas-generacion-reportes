<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SaleSummaryMail extends Mailable
{
    use Queueable, SerializesModels;
    public $saleDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($saleDetails)
    {
        $this->saleDetails = $saleDetails;
    }

    public function build(): SaleSummaryMail
    {
        return $this->subject('Resumen de su Compra')
            ->view('emails.sale_summary');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sale Summary Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
