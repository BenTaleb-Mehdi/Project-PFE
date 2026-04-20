{{-- resources/views/components/public/about.blade.php --}}

<section id="about" class="atom-section bg-mid border-y border-border overflow-hidden">
  <div class="atom-container grid lg:grid-cols-2 gap-16 items-center">

    <!-- Visual side -->
    <div class="reveal-left relative">
      <div class="bg-dark border border-border rounded-sm p-8 aspect-square relative overflow-hidden">
        <div class="absolute inset-0 bg-grid opacity-20"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 border border-border rounded-full"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 border border-acid/20 rounded-full animate-spin" style="animation-duration:20s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-acid/10 rounded-full blur-xl"></div>
        <div class="absolute inset-0 flex items-center justify-center">
          <img src="{{ asset('images/achraf-about.png') }}" alt="" class="w-full h-full object-cover">
        </div>
        <div class="absolute top-4 right-4 bg-acid text-dark font-display text-sm px-3 py-1 rounded-sm">ELITE</div>
        <div class="absolute bottom-4 left-4 font-cond text-xs tracking-widest uppercase text-gray-600">Est. 2018</div>
      </div>
    </div>

    <!-- Text side -->
    <div class="reveal-right">
      <div class="flex items-center gap-4 mb-4">
        <span class="atom-label">Why Choose Us</span>
      </div>
      <h2 class="atom-h-section mb-8">
        What Makes You <span class="atom-text-accent">Sure</span><br>To Choose Us?
      </h2>

      <div class="space-y-5">
        <template x-for="(reason, idx) in reasons" :key="reason.title">
          <div class="flex gap-5 group cursor-default p-4 rounded-sm border border-transparent hover:border-border hover:bg-dark transition-colors">
            <div class="flex-shrink-0 w-10 h-10 rounded-sm border border-border flex items-center justify-center text-acid font-display text-lg group-hover:bg-acid group-hover:text-dark transition-colors">
              <span x-text="(idx+1).toString().padStart(2,'0')"></span>
            </div>
            <div>
              <h4 class="font-cond font-bold tracking-wider uppercase text-sm mb-1 group-hover:text-acid transition-colors" x-text="reason.title"></h4>
              <p class="t-muted text-sm leading-relaxed" x-text="reason.desc"></p>
            </div>
          </div>
        </template>
      </div>
    </div>

  </div>
</section>