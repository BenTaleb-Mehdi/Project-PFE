<section id="hero" class="relative min-h-screen flex items-center hero-bg grain overflow-hidden pt-20">
  <!-- Decorative circles -->
  <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full border border-brand-500/10 pointer-events-none"></div>
  <div class="absolute right-12 top-1/2 -translate-y-1/2 w-[420px] h-[420px] rounded-full border border-brand-500/20 pointer-events-none"></div>
  <div class="absolute right-28 top-1/2 -translate-y-1/2 w-[240px] h-[240px] rounded-full bg-brand-500/5 pointer-events-none"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full grid lg:grid-cols-2 gap-12 items-center py-20">
    <!-- Text -->
    <div class="space-y-8 relative z-10">
      <div class="reveal inline-flex items-center gap-3 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-[0.2em] uppercase">
        <span class="w-8 h-px bg-brand-500/50"></span>
        The Future of Coaching
      </div>
      <h1 class="reveal delay-100 font-display text-5xl sm:text-6xl lg:text-7xl leading-[1.1] tracking-tight text-neutral-900 dark:text-white uppercase font-light">
        MASTER YOUR<br/>BODY WITH<br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-brand-600 font-semibold">PRECISION DATA</span>
      </h1>
      <p class="reveal delay-200 text-neutral-500 dark:text-neutral-400 text-lg sm:text-xl leading-relaxed max-w-lg font-light">
        Elite personal training driven by a seamless digital companion app. No more PDFs or guesswork. Just pure, measurable results.
      </p>
      <div class="reveal delay-300 flex flex-wrap gap-6 pt-4">
        <button
          @click="goTo('contact')"
          class="group px-8 py-4 bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 hover:bg-brand-500 dark:hover:bg-brand-500 hover:text-neutral-950 dark:hover:text-neutral-950 font-medium text-sm tracking-widest uppercase transition-all duration-300 flex items-center gap-3"
        >
          Apply Now
          <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </button>
        <button
          @click="goTo('about')"
          class="group px-8 py-4 border border-neutral-300 dark:border-neutral-700 hover:border-neutral-900 dark:hover:border-white text-neutral-600 dark:text-neutral-300 hover:text-neutral-900 dark:hover:text-white font-medium text-sm tracking-widest uppercase transition-all duration-300"
        >
          Discover More
        </button>
      </div>

      <!-- Stats row -->
      <div class="reveal delay-400 flex flex-wrap gap-12 pt-8 border-t border-neutral-200 dark:border-neutral-800 mt-4">
        <div>
          <div class="font-display text-3xl font-light text-neutral-900 dark:text-white" x-text="(heroStats?.clients || 500) + '+'">500+</div>
          <div class="text-[10px] text-brand-500 uppercase tracking-widest mt-2 font-medium">Transformations</div>
        </div>
        <div>
          <div class="font-display text-3xl font-light text-neutral-900 dark:text-white" x-text="(heroStats?.years || 8) + '+'">8+</div>
          <div class="text-[10px] text-brand-500 uppercase tracking-widest mt-2 font-medium">Years Expertise</div>
        </div>
        <div>
          <div class="font-display text-3xl font-light text-neutral-900 dark:text-white" x-text="(heroStats?.rate || 97) + '%'">97%</div>
          <div class="text-[10px] text-brand-500 uppercase tracking-widest mt-2 font-medium">Success Rate</div>
        </div>
      </div>
    </div>

    <!-- Coach Image -->
    <div class="reveal-right flex lg:justify-end justify-center relative lg:h-[650px] w-full items-center mt-12 lg:mt-0">
      <div class="relative w-full max-w-[320px] xs:max-w-[360px] sm:max-w-[420px] aspect-[4/5] sm:aspect-auto sm:h-[580px]">
        <!-- Background Accent -->
        <div class="absolute -top-4 -right-4 w-full h-full border-2 border-brand-500 rounded-3xl opacity-30"></div>
        <div class="absolute -bottom-4 -left-4 w-full h-full bg-brand-500/10 rounded-3xl blur-xl"></div>
        
        <!-- Image Container -->
        <div class="absolute inset-0 rounded-3xl overflow-hidden shadow-2xl border border-neutral-200 dark:border-neutral-800 bg-neutral-100 dark:bg-neutral-900">
          <img src="{{ asset('images/images-coach/coach-02.jpg') }}" alt="Professional Fitness Coach" class="w-full h-full object-cover object-top" />
          <!-- Luxury gradient overlay -->
          <div class="absolute inset-0 bg-gradient-to-t from-neutral-950/80 via-transparent to-transparent"></div>
        </div>
        
        <!-- Floating Badge -->
        <div class="absolute -left-4 xs:-left-8 sm:-left-12 bottom-12 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md border border-neutral-200 dark:border-neutral-800 p-4 sm:p-5 rounded-2xl shadow-2xl flex items-center gap-3 sm:gap-4 max-w-[180px] sm:max-w-[220px]">
          <div class="w-10 h-10 sm:w-12 sm:h-12 border border-brand-500 flex items-center justify-center shrink-0 rounded-xl bg-brand-500/10">
            <svg class="w-5 sm:w-6 h-5 sm:h-6 text-brand-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          </div>
          <div>
            <div class="font-display tracking-widest text-xs sm:text-sm uppercase text-neutral-900 dark:text-white">Elite</div>
            <div class="text-[9px] sm:text-[10px] text-neutral-500 dark:text-neutral-400 tracking-wider">Certified Pro</div>
          </div>
        </div>

        <!-- Secondary Badge -->
        <div class="absolute -right-4 xs:-right-6 sm:-right-8 top-12 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md border border-neutral-200 dark:border-neutral-800 p-4 sm:p-5 rounded-2xl shadow-xl">
          <div class="text-[9px] sm:text-[10px] text-neutral-500 dark:text-neutral-400 uppercase tracking-widest mb-1">Availability</div>
          <div class="font-display text-xl sm:text-2xl text-neutral-900 dark:text-white font-light">3 <span class="text-brand-500 text-xs sm:text-sm">Spots</span></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scroll indicator -->
  <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce opacity-60">
    <span class="text-xs tracking-widest uppercase">Scroll</span>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
  </div>
</section>
