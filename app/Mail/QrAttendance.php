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

class QrAttendance extends Mailable
{
    use Queueable, SerializesModels;

    public $qrCodeFilePath;

    /**
     * Create a new message instance.
     *
     * @param string $qrCodeFilePath The full path to the generated QR code image file.
     */
    public function __construct($qrCodeFilePath)
    {
        $this->qrCodeFilePath = $qrCodeFilePath;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Generated QR Code',
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
            view: 'mail.qr-attendance', // Blade view for the email body
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
        // Convert full path back to storage path if needed, or just delete directly.
        // Assuming $this->qrCodeFullPath is the absolute path, Storage::delete expects relative to storage disk.
        // It's safer to delete by full path or pass the storage-relative path.
        // Let's assume $qrCodePathInStorage (e.g., 'public/qrcodes/qrcode_xxxx.png') was passed instead of full path.
        // Or, convert $this->qrCodeFullPath back to its Storage relative path.

        $relativePath = str_replace(Storage::path(''), '', $this->qrCodeFilePath);
        if (Storage::exists($relativePath)) {
            Storage::delete($relativePath);
            Log::info("QR Code file deleted: " . $relativePath);
        } else {
            Log::warning("Attempted to delete non-existent QR Code file: " . $relativePath);
        }
    }
}
