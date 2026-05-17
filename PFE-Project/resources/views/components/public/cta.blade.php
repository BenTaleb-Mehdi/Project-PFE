<section class="py-24 bg-neutral-900 dark:bg-neutral-950 relative overflow-hidden border-t border-b border-neutral-200 dark:border-neutral-800">
  <div class="absolute inset-0 grain opacity-20 pointer-events-none"></div>
  <div class="absolute -right-20 top-1/2 -translate-y-1/2 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
  <div class="absolute -left-20 top-1/2 -translate-y-1/2 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="max-w-4xl mx-auto px-4 text-center relative z-10 space-y-6">
    <div class="reveal inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 text-brand-400 text-xs font-medium tracking-widest uppercase">Start Today</div>
    <h2 class="reveal delay-100 font-display text-5xl sm:text-6xl text-white tracking-wider">READY TO START<br/>YOUR <span class="text-brand-500">JOURNEY?</span></h2>
    <p class="reveal delay-200 text-white/70 text-lg max-w-xl mx-auto leading-relaxed">Your first consultation is completely free. Let's map out a plan built specifically for you.</p>
    <div class="reveal delay-300 flex flex-wrap gap-4 justify-center pt-4">
      <button @click="goTo('contact')" class="px-8 py-4 rounded-full bg-brand-500 text-neutral-950 font-semibold hover:bg-brand-600 transition-colors shadow-lg shadow-brand-500/25">Book Free Call</button>
      <button @click="goTo('blog')" class="px-8 py-4 rounded-full border border-neutral-700 text-neutral-300 font-semibold hover:border-brand-500 hover:text-brand-500 transition-colors">Read the Blog</button>
    </div>
  </div>
</section>
