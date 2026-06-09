@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-white dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100">
  <section class="pt-36 pb-24 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <a href="{{ route('legal.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-brand-500 transition-colors mb-8">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
      Back to Legal
    </a>

    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase mb-4">Legal</div>
    <h1 class="font-display text-4xl sm:text-5xl tracking-wider mb-4 text-neutral-900 dark:text-white">PRIVACY <span class="text-brand-500">POLICY</span></h1>
    <p class="text-sm text-neutral-400 mb-10">Last updated: {{ $legal['last_updated'] ?? 'June 1, 2026' }}</p>

    <div class="prose prose-neutral dark:prose-invert max-w-none space-y-6 text-sm leading-relaxed text-neutral-600 dark:text-neutral-400">
      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">1. Introduction</h2>
      <p>{{ $legal['company'] ?? 'CoachPro' }} (&quot;we,&quot; &quot;our,&quot; or &quot;us&quot;) is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">2. Information We Collect</h2>
      <p>We may collect the following types of information:</p>
      <ul class="list-disc pl-6 space-y-2">
        <li><strong>Personal Data:</strong> Name, email address, phone number, and billing information when you register or fill out a contact form.</li>
        <li><strong>Health &amp; Fitness Data:</strong> Information about your fitness goals, body measurements, training history, and dietary preferences that you voluntarily provide.</li>
        <li><strong>Usage Data:</strong> Information about how you interact with our website, including pages visited, time spent, and referral sources.</li>
        <li><strong>Device Data:</strong> IP address, browser type, operating system, and device identifiers.</li>
      </ul>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">3. How We Use Your Information</h2>
      <p>We use the collected information for the following purposes:</p>
      <ul class="list-disc pl-6 space-y-2">
        <li>To provide and maintain our coaching services</li>
        <li>To personalize your training and nutrition plans</li>
        <li>To communicate with you regarding your account, progress, and updates</li>
        <li>To process payments and send receipts</li>
        <li>To improve our website and service offerings</li>
        <li>To comply with legal obligations</li>
      </ul>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">4. Data Sharing &amp; Disclosure</h2>
      <p>We do not sell your personal information. We may share your data with:</p>
      <ul class="list-disc pl-6 space-y-2">
        <li><strong>Service Providers:</strong> Third-party vendors who assist us with payment processing, email delivery, and data analytics.</li>
        <li><strong>Legal Authorities:</strong> When required by law or to protect our rights and safety.</li>
        <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets.</li>
      </ul>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">5. Data Security</h2>
      <p>We implement industry-standard security measures to protect your data, including SSL encryption, secure servers, and access controls. However, no method of transmission over the Internet is 100% secure.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">6. Your Rights</h2>
      <p>Depending on your jurisdiction, you may have the right to:</p>
      <ul class="list-disc pl-6 space-y-2">
        <li>Access the personal data we hold about you</li>
        <li>Request correction of inaccurate data</li>
        <li>Request deletion of your data</li>
        <li>Object to or restrict processing</li>
        <li>Data portability</li>
        <li>Withdraw consent at any time</li>
      </ul>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">7. Contact Us</h2>
      <p>If you have any questions about this Privacy Policy, please contact us at:</p>
      <p><strong>Email:</strong> {{ $legal['email'] ?? 'privacy@coachpro.com' }}<br><strong>Address:</strong> {{ $legal['address'] ?? 'Tangier, Morocco' }}</p>
    </div>
  </section>
</div>
@endsection
