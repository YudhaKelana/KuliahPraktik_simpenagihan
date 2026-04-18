<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class TaxPaymentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $taxpayerName,
        public string $plateNumber,
        public string $dueDate,
        public float $arrearAmount = 0,
        public ?string $vehicleType = null,
    ) {}

    public function headers(): Headers
    {
        return new Headers(
            text: [
                'X-Priority' => '3',
                'X-Mailer' => 'SamsatMonitoring/1.0',
                'Precedence' => 'bulk',
                'List-Unsubscribe' => '<mailto:' . config('mail.from.address') . '?subject=unsubscribe>',
            ],
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Pengingat Pajak Kendaraan Bermotor - {$this->plateNumber}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tax-payment-reminder',
            text: 'emails.tax-payment-reminder-text',
        );
    }
}
