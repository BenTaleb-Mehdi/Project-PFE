@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-white dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100">
  <section class="pt-36 pb-24 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 space-y-4">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase">Legal</div>
      <h1 class="font-display text-5xl sm:text-6xl tracking-wider text-neutral-900 dark:text-white">LEGAL<br/><span class="text-brand-500">INFORMATION</span></h1>
      <p class="text-neutral-500 dark:text-neutral-400 max-w-lg mx-auto font-light">Transparency is at the core of everything we do. Below you will find our policies regarding privacy, terms of service, and cookies.</p>
    </div>

    <div class="grid sm:grid-cols-3 gap-6">
      <a href="{{ route('legal.privacy') }}" class="group p-8 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 hover:border-brand-500/50 transition-all card-hover">
        <div class="w-14 h-14 rounded-xl bg-brand-500/10 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
          <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
        </div>
        <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white mb-2">Privacy Policy</h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400 font-light leading-relaxed">How we collect, use, and protect your personal data.</p>
      </a>

      <a href="{{ route('legal.terms') }}" class="group p-8 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 hover:border-brand-500/50 transition-all card-hover">
        <div class="w-14 h-14 rounded-xl bg-brand-500/10 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
          <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
        </div>
        <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white mb-2">Terms of Service</h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400 font-light leading-relaxed">The rules and guidelines for using our services.</p>
      </a>

      <a href="{{ route('legal.cookies') }}" class="group p-8 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 hover:border-brand-500/50 transition-all card-hover">
        <div class="w-14 h-14 rounded-xl bg-brand-500/10 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
          <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.596.189.866.108.215.396.634.936.634.54 0 .828-.419.936-.634.13-.27.189-.568.189-.866 0-.298-.059-.596-.189-.866-.108-.215-.396-.634-.936-.634zm4.314.634c.108-.215.396-.634.936-.634.54 0 .828.419.936.634.13.27.189.568.189.866 0 .298-.059.596-.189.866-.108.215-.396.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.596.189-.866zm2.023 6.828a.75.75 0 10-1.06-1.06 3.75 3.75 0 01-5.304 0 .75.75 0 00-1.06 1.06 5.25 5.25 0 007.424 0z"/></svg>
        </div>
        <h2 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white mb-2">Cookie Policy</h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400 font-light leading-relaxed">How we use cookies and similar tracking technologies.</p>
      </a>
    </div>

    <div class="mt-12 text-center">
      <a href="{{ route('landingpage') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-brand-500 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Back to Home
      </a>
    </div>
  </section>
</div>
@endsection
