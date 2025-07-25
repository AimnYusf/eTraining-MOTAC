<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationNotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $pengguna, $kursus, $status;
    /**
     * Create a new message instance.
     */
    public function __construct($pengguna, $kursus, $status)
    {
        $this->pengguna = $pengguna;
        $this->kursus = $kursus;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = ($this->status == 1) ? 'Dihantar' : 'Disokong';

        return new Envelope(
            subject: 'Notifikasi: Permohonan Kursus' . strtoupper($this->kursus['kur_nama']) . ' Telah ' . $statusText,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.application-notification',
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
