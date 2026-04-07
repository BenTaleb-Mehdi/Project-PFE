{{-- resources/views/components/public/video.blade.php --}}

<section id="video" class="atom-section">
  <div class="atom-container text-center mb-16 reveal">
    <div class="flex items-center justify-center gap-4 mb-4">
      <div class="neon-line w-12"></div>
      <span class="font-cond text-xs tracking-widest uppercase text-acid">Success Stories</span>
      <div class="neon-line w-12"></div>
    </div>
    <h2 class="font-display text-[clamp(32px,5vw,64px)] leading-none uppercase">
      See How You Turn Yourself Into A<br><span class="text-acid">Champion</span>
    </h2>
  </div>

  <div class="atom-container grid lg:grid-cols-2 gap-8 items-center">

    <!-- Video placeholder -->
    <div class="reveal-left relative aspect-video t-bg-mid t-border border rounded-sm overflow-hidden group cursor-pointer">
      <div class="absolute inset-0 bg-grid opacity-40"></div>
      <div class="absolute inset-0 bg-gradient-to-br from-acid/5 to-transparent"></div>
      <div class="absolute inset-0 flex items-center justify-center">
        <div class="play-ring w-20 h-20 rounded-full bg-acid flex items-center justify-center group-hover:scale-110 transition-transform">
          <svg class="w-8 h-8 text-dark ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
        </div>
      </div>
      <div class="absolute bottom-4 left-4">
        <div class="font-display text-lg opacity-40">TRAINING HIGHLIGHTS 2025</div>
      </div>
    </div>

    <!-- Stats grid -->
    <div class="reveal-right grid grid-cols-2 gap-5">
      <template x-for="(stat, idx) in stats" :key="stat.label">
        <div class="bg-mid border border-border rounded-sm p-6 tilt-card group" :style="`transition-delay:${idx * .1}s`">
          <div class="font-display text-[clamp(32px,4vw,52px)] text-acid" x-text="countersStarted ? stat.display : '0'"></div>
          <div class="font-cond text-xs tracking-widest uppercase t-muted mt-2" x-text="stat.label"></div>
          <div class="h-px t-border mt-4 group-hover:bg-acid transition-colors duration-500"></div>
        </div>
      </template>

      <div class="col-span-2 t-bg t-border border rounded-sm p-5 flex items-center justify-between group cursor-pointer hover:border-acid transition-colors">
        <p class="text-sm t-muted leading-relaxed max-w-xs">Thousands of members have named fitness to be their most transformative journey.</p>
        <div class="flex-shrink-0 w-10 h-10 border t-border rounded-full flex items-center justify-center group-hover:border-acid group-hover:text-acid t-muted transition-colors ml-4">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </div>
      </div>
    </div>

  </div>
</section>