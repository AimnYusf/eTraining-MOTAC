<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kursus, $status;
    /**
     * Create a new message instance.
     */
    public function __construct($kursus, $status)
    {
        $this->kursus = $kursus;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = ($this->status == 3) ? 'Tidak Disokong' : 'Tidak Berjaya';

        return new Envelope(
            subject: 'Makluman eTraining: Permohonan ' . $statusText,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.application-failed',
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
