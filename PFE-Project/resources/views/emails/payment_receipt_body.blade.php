@component('mail::message')
# Payment Receipt Confirmed

Hello {{ $clientName }},

We have successfully processed your payment of **{{ number_format($amount, 2) }} MAD** on {{ $date }}.

Please find your official receipt attached to this email as a PDF document.

@component('mail::button', ['url' => $signedUrl, 'color' => 'success'])
Download PDF Receipt
@endcomponent

Thank you for choosing IronCoach.

Regards,<br>
{{ config('app.name') }}
@endcomponent
