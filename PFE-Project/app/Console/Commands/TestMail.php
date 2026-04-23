<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    protected $signature = 'mail:send-test {to : Email address to send test to}';
    protected $description = 'Send a test email to verify SMTP configuration';

    public function handle(): void
    {
        $to = $this->argument('to');
        
        $this->info("Sending test email to: {$to}");
        $this->info('SMTP Host: ' . config('mail.mailers.smtp.host'));
        $this->info('SMTP Port: ' . config('mail.mailers.smtp.port'));
        $this->info('SMTP User: ' . config('mail.mailers.smtp.username'));
        $this->info('From:      ' . config('mail.from.address'));
        $this->newLine();

        try {
            Mail::raw('This is a test email from IronCoach. SMTP is working!', function ($message) use ($to) {
                $message->to($to)->subject('[IronCoach] SMTP Test – ' . now()->format('H:i:s'));
            });

            $this->info('✅ Email sent successfully! Check your inbox.');
        } catch (\Exception $e) {
            $this->error('❌ Failed to send email.');
            $this->error($e->getMessage());
        }
    }
}
