@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-white dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100">
  <section class="pt-36 pb-24 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <a href="{{ route('legal.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-brand-500 transition-colors mb-8">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
      Back to Legal
    </a>

    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase mb-4">Legal</div>
    <h1 class="font-display text-4xl sm:text-5xl tracking-wider mb-4 text-neutral-900 dark:text-white">COOKIE <span class="text-brand-500">POLICY</span></h1>
    <p class="text-sm text-neutral-400 mb-10">Last updated: {{ $legal['last_updated'] ?? 'June 1, 2026' }}</p>

    <div class="prose prose-neutral dark:prose-invert max-w-none space-y-6 text-sm leading-relaxed text-neutral-600 dark:text-neutral-400">
      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">1. What Are Cookies</h2>
      <p>Cookies are small text files stored on your device when you visit a website. They help the website remember your preferences, improve functionality, and analyze site traffic.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">2. How We Use Cookies</h2>
      <p>We use cookies for the following purposes:</p>
      <ul class="list-disc pl-6 space-y-2">
        <li><strong>Essential Cookies:</strong> Required for the website to function properly, including authentication and security.</li>
        <li><strong>Preference Cookies:</strong> Remember your theme preferences (light/dark mode) and language settings.</li>
        <li><strong>Analytics Cookies:</strong> Help us understand how visitors interact with our site so we can improve the user experience.</li>
        <li><strong>Functional Cookies:</strong> Enable enhanced features such as personalized content and chat functionality.</li>
      </ul>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">3. Types of Cookies We Use</h2>
      <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
          <thead>
            <tr class="border-b border-neutral-300 dark:border-neutral-700">
              <th class="text-left py-3 pr-4 font-semibold text-neutral-900 dark:text-white">Cookie</th>
              <th class="text-left py-3 pr-4 font-semibold text-neutral-900 dark:text-white">Type</th>
              <th class="text-left py-3 font-semibold text-neutral-900 dark:text-white">Duration</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
            <tr>
              <td class="py-3 pr-4">ironcoach-theme</td>
              <td class="py-3 pr-4">Preference</td>
              <td class="py-3">Persistent</td>
            </tr>
            <tr>
              <td class="py-3 pr-4">XSRF-TOKEN</td>
              <td class="py-3 pr-4">Essential</td>
              <td class="py-3">Session</td>
            </tr>
            <tr>
              <td class="py-3 pr-4">laravel_session</td>
              <td class="py-3 pr-4">Essential</td>
              <td class="py-3">Session</td>
            </tr>
            <tr>
              <td class="py-3 pr-4">_ga / _ga_*</td>
              <td class="py-3 pr-4">Analytics</td>
              <td class="py-3">2 years</td>
            </tr>
          </tbody>
        </table>
      </div>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">4. Third-Party Cookies</h2>
      <p>We may use third-party services such as Google Analytics and payment processors that set their own cookies. These third parties have their own privacy policies governing the use of your data.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">5. Managing Cookies</h2>
      <p>You can control and manage cookies in several ways:</p>
      <ul class="list-disc pl-6 space-y-2">
        <li><strong>Browser Settings:</strong> Most browsers allow you to block or delete cookies through their settings menu.</li>
        <li><strong>Opt-Out:</strong> You can opt out of Google Analytics by installing the Google Analytics opt-out browser add-on.</li>
        <li><strong>Do Not Track:</strong> Some browsers support &quot;Do Not Track&quot; signals, which we honor where technically feasible.</li>
      </ul>
      <p>Please note that disabling essential cookies may affect the functionality of our website.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">6. Updates to This Policy</h2>
      <p>We may update this Cookie Policy periodically. Changes will be posted on this page with the updated date.</p>

      <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">7. Contact</h2>
      <p>For questions about our use of cookies, contact us at <strong>{{ $legal['email'] ?? 'privacy@coachpro.com' }}</strong>.</p>
    </div>
  </section>
</div>
@endsection
