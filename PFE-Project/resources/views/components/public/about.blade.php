@props(['features' => [], 'stats' => [], 'certs' => [], 'timeline' => []])

<section id="about-section" class="py-24 bg-neutral-50 dark:bg-neutral-900/50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-16 items-center">
    <div class="reveal-left space-y-6">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase">About Me</div>
      <h2 class="font-display text-5xl sm:text-6xl tracking-wider text-neutral-900 dark:text-white">YOUR COACH,<br/><span class="text-brand-500">YOUR ALLY</span></h2>
      <p class="text-neutral-500 dark:text-neutral-400 leading-relaxed">With over 8 years coaching athletes and everyday people, I blend evidence-based exercise science with real-world psychology. I've helped 500+ clients lose fat, build muscle, and — most importantly — build lasting habits.</p>
      
      <!-- Features list -->
      <ul class="space-y-3">
        @foreach($features as $f)
          <li class="flex items-center gap-3 text-sm font-medium">
            <span class="w-5 h-5 rounded-full bg-brand-500 flex items-center justify-center shrink-0">
              <svg class="w-3 h-3 text-neutral-950" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </span>
            <span>{{ $f }}</span>
          </li>
        @endforeach
      </ul>
      
      <button @click="goTo('about')" class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-brand-500 hover:bg-brand-600 text-neutral-950 font-medium text-sm transition-colors">
        Full Story
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </button>
    </div>
    
    <div class="reveal-right grid grid-cols-2 gap-4">
      @foreach($stats as $index => $stat)
        <div
          class="rounded-2xl p-6 flex flex-col gap-2"
          :class="currentPage === 'home' && {{ $index }} === 0 ? 'bg-brand-500 text-neutral-950' : 'bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800'"
        >
          <div class="stat-number text-4xl" :class="currentPage === 'home' && {{ $index }} === 0 ? 'text-neutral-950' : 'text-brand-500'">{{ $stat['value'] }}</div>
          <div class="text-xs uppercase tracking-widest opacity-80">{{ $stat['label'] }}</div>
        </div>
      @endforeach
    </div>
  </div>
</section>
