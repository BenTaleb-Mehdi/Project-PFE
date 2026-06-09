@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-white dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100">
  <section class="pt-36 pb-24 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <a href="{{ route('legal.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-brand-500 transition-colors mb-8">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
      Back to Legal
    </a>

    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase mb-4">Legal</div>
    <h1 class="font-display text-4xl sm:text-5xl tracking-wider mb-4 text-neutral-900 dark:text-white">TERMS OF <span class="text-brand-500">SERVICE</span></h1>
    <p class="text-sm text-neutral-400 mb-10">Last updated: {{ $legal['last_updated'] ?? 'June 1, 2026' }}</p>

    <div class="prose prose-neutral dark:prose-invert max-w-none space-y-6 text-sm leading-relaxed text-neutral-600 dark:text-neutral-400">
      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">1. Acceptance of Terms</h2>
      <p>By accessing or using {{ $legal['company'] ?? 'CoachPro' }} (&quot;the Service&quot;), you agree to be bound by these Terms of Service. If you do not agree, please do not use our services.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">2. Description of Services</h2>
      <p>{{ $legal['company'] ?? 'CoachPro' }} provides personalized fitness coaching, nutrition planning, and wellness guidance through digital platforms, including but not limited to our website, mobile application, and direct messaging services.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">3. User Responsibilities</h2>
      <p>As a user of our services, you agree to:</p>
      <ul class="list-disc pl-6 space-y-2">
        <li>Provide accurate and complete information when registering</li>
        <li>Maintain the confidentiality of your account credentials</li>
        <li>Consult with a physician before beginning any exercise or nutrition program</li>
        <li>Use the service in compliance with all applicable laws</li>
        <li>Not misuse or abuse the coaching relationship</li>
      </ul>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">4. Medical Disclaimer</h2>
      <p>{{ $legal['company'] ?? 'CoachPro' }} is not a medical provider. Our coaches are not doctors, physical therapists, or registered dietitians unless explicitly stated. All training and nutrition recommendations are for informational purposes and should not replace professional medical advice. You assume full responsibility for your health and safety.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">5. Payment &amp; Refund Policy</h2>
      <p>Payments for coaching services are billed according to the plan you select. Refunds are handled on a case-by-case basis. We reserve the right to modify pricing with reasonable notice.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">6. Intellectual Property</h2>
      <p>All content provided through the Service, including training programs, nutrition plans, videos, and written materials, is the intellectual property of {{ $legal['company'] ?? 'CoachPro' }} and may not be reproduced, distributed, or shared without our written consent.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">7. Limitation of Liability</h2>
      <p>{{ $legal['company'] ?? 'CoachPro' }}, its coaches, and affiliates shall not be liable for any indirect, incidental, or consequential damages arising from your use of the service, including but not limited to injuries, financial loss, or health complications.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">8. Termination</h2>
      <p>We reserve the right to suspend or terminate your access to the Service at our discretion, particularly in cases of policy violation, abusive behavior, or non-payment.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">9. Changes to Terms</h2>
      <p>We may update these terms from time to time. Continued use of the Service after changes constitutes acceptance of the new terms.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">10. Contact</h2>
      <p>For questions about these terms, contact us at <strong>{{ $legal['support_email'] ?? 'support@coachpro.com' }}</strong>.</p>
    </div>
  </section>
</div>
@endsection
