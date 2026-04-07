{{-- resources/views/components/public/hero.blade.php --}}

<section class="atom-section atom-section-fixed bg-grid overflow-hidden">

  <!-- Background glows -->
  <div class="absolute inset-0 pointer-events-none">
    <div class="absolute top-0 right-0 w-[700px] h-[700px] rounded-full bg-acid opacity-[0.06] blur-[120px] translate-x-1/4 -translate-y-1/4"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-acid opacity-[0.04] blur-[80px]"></div>
  </div>

  <!-- Vertical accent line -->
  <div class="absolute left-0 top-0 bottom-0 w-px bg-gradient-to-b from-transparent via-acid to-transparent opacity-30"></div>

  <div class="atom-container grid lg:grid-cols-2 gap-12 items-center">

    <!-- Text -->
    <div class="reveal" style="transition-delay:.1s">
      <div class="inline-flex items-center gap-3 bg-mid border border-border rounded-full px-4 py-2 mb-8">
        <span class="w-2 h-2 rounded-full bg-acid animate-pulse"></span>
        <span class="font-cond text-xs tracking-widest uppercase text-gray-400">Elite Performance Coaching</span>
      </div>

      <h1 class="atom-h-hero mb-6">
        Build Your<br>
        Body Into A<br>
        <span class="atom-text-accent glitch" data-text="Champion.">Champion.</span>
      </h1>

      <p class="t-muted font-body text-lg max-w-md mb-10 leading-relaxed">
        Sport is the foundation of health. We design elite programs that transform your body, sharpen your mind, and make you unstoppable.
      </p>

      <div class="flex flex-wrap gap-4 items-center">
        <a href="#contact" class="atom-btn atom-btn-premium text-sm px-7 py-4">
          Get Started Free
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="#video" class="inline-flex items-center gap-3 text-sm font-cond font-semibold tracking-widest uppercase group">
          <span class="w-12 h-12 rounded-full border border-border flex items-center justify-center group-hover:border-acid group-hover:text-acid transition-colors">
            <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
          </span>
          Watch Intro
        </a>
      </div>

      <!-- Stats row -->
      <div class="flex gap-8 mt-12 pt-8 border-t t-border">
        <div>
          <div class="font-display text-3xl text-acid"><span x-text="heroStats.clients"></span>K+</div>
          <div class="atom-label t-muted mt-1">Clients Trained</div>
        </div>
        <div>
          <div class="font-display text-3xl text-acid"><span x-text="heroStats.years"></span>+</div>
          <div class="atom-label t-muted mt-1">Experience</div>
        </div>
        <div>
          <div class="font-display text-3xl text-acid"><span x-text="heroStats.rate"></span>%</div>
          <div class="atom-label t-muted mt-1">Success Rate</div>
        </div>
      </div>
    </div>

    <!-- Visual -->
    <div class="relative reveal-right flex justify-center" style="transition-delay:.3s">
      <div class="absolute inset-0 flex items-center justify-center">
        <div class="w-80 h-80 border border-border rotate-45 opacity-20"></div>
        <div class="absolute w-96 h-96 border border-acid/10 rotate-12"></div>
      </div>
      <div class="relative z-10 w-full max-w-sm">
        <div class="relative bg-gradient-to-b from-mid to-dark border border-border rounded-sm overflow-hidden aspect-[3/4]">
          <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/40 to-transparent z-10"></div>
          <div class="absolute inset-0 flex items-center justify-center">
           <img src="{{ asset('images/achraf.png') }}" alt="" class="w-full h-full object-cover">
          </div>
          <div class="absolute bottom-0 left-0 right-0 z-20 p-5">
            <div class="font-display text-2xl tracking-wider">Achraf Knf</div>
            <div class="text-acid atom-label mt-1">Head Performance Coach</div>
          </div>
          <div class="absolute top-0 right-0 w-16 h-16 bg-acid clip-corner z-20" style="clip-path:polygon(100% 0,0 0,100% 100%)"></div>
        </div>
        <div class="float-badge absolute -top-4 -left-4 bg-acid text-dark rounded-sm px-4 py-2">
          <div class="font-display text-xl leading-none">PRO</div>
          <div class="atom-label text-[10px] text-dark/70">Certified</div>
        </div>
        <div class="absolute -right-6 top-1/2 -translate-y-1/2 bg-mid border t-border rounded-sm p-3 text-center w-20">
          <div class="font-display text-2xl text-acid">241K</div>
          <div class="atom-label text-[9px] t-muted leading-tight mt-1">Online champions</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scroll indicator -->
  <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 t-muted">
    <span class="atom-label">Scroll</span>
    <div class="w-px h-10 bg-gradient-to-b from-gray-600 to-transparent animate-pulse"></div>
  </div>
</section>