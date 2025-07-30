<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
// No need for Illuminate\Mail\Mailables\Attachment here, as we're not using attachments()

class ApplicationApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $qrCodeFilePath;
    public $kursus;
    public $pengguna;

    /**
     * Create a new message instance.
     *
     * @param string $qrCodeFilePath The full path to the generated QR code image file.
     */
    public function __construct($qrCodeFilePath, $kursus, $pengguna)
    {
        $this->qrCodeFilePath = $qrCodeFilePath;
        $this->kursus = $kursus;
        $this->pengguna = $pengguna;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Makluman eTraining: Permohonan Berjaya',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.application-approved',
            with: [
                'qrCodeFilePath' => $this->qrCodeFilePath, // Pass the file path to the view
            ],
        );
    }

    /**
     * Handle the event after the message is sent.
     *
     * @return void
     */
    public function afterSend(): void
    {
        // Ensure the file is deleted after the email has been sent.
        $relativePath = str_replace(Storage::path(''), '', $this->qrCodeFilePath);
        if (Storage::exists($relativePath)) {
            Storage::delete($relativePath);
            Log::info("QR Code file deleted: " . $relativePath);
        } else {
            Log::warning("Attempted to delete non-existent QR Code file: " . $relativePath);
        }
    }
}
