<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\URL;

class PaymentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public Payment $payment;

    /**
     * Create a new message instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Receipt #' . $this->payment->id . ' // IronCoach',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $signedUrl = URL::temporarySignedRoute(
            'receipts.download.signed', 
            now()->addDays(7), 
            ['id' => $this->payment->id]
        );

        return new Content(
            markdown: 'emails.payment_receipt_body',
            with: [
                'clientName' => $this->payment->client->user->name,
                'amount' => $this->payment->amount,
                'date' => $this->payment->date,
                'signedUrl' => $signedUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdfs.receipt', ['payment' => $this->payment]);
        
        return [
            Attachment::fromData(fn () => $pdf->output(), 'receipt_' . $this->payment->id . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
