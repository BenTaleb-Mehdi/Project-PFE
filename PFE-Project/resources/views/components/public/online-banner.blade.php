{{-- resources/views/components/public/online-banner.blade.php --}}

<section class="atom-section t-bg-mid border-y t-border overflow-hidden">
  <div class="absolute right-0 top-0 w-[500px] h-[500px] bg-acid opacity-[0.07] blur-[100px] rounded-full"></div>

  <div class="atom-container grid lg:grid-cols-2 gap-12 items-center">

    <div class="reveal-left">
      <div class="flex items-center gap-4 mb-4">
        <div class="neon-line w-12"></div>
        <span class="font-cond text-xs tracking-widest uppercase text-acid">Online Program</span>
      </div>
      <h2 class="font-display text-[clamp(32px,5vw,64px)] leading-none uppercase mb-6">
        Get Training <span class="text-acid">Online</span> With<br>E-Books &amp; Videos
      </h2>
      <p class="t-muted mb-8 max-w-md leading-relaxed">
        Practice regular sessions with our online material for several weeks. You can challenge your power to be stronger — we've helped thousands of people achieve their ideal body.
      </p>
      <div class="flex gap-4 flex-wrap">
        <a href="#" class="mag-btn inline-flex items-center gap-2 bg-acid text-dark font-cond font-bold tracking-widest uppercase text-xs px-6 py-3.5 rounded-sm">Download E-Book</a>
        <a href="#" class="mag-btn inline-flex items-center gap-2 border border-acid text-acid font-cond font-bold tracking-widest uppercase text-xs px-6 py-3.5 rounded-sm hover:bg-acid hover:text-dark transition-colors">Download Videos</a>
      </div>
    </div>

    <!-- Skill bars -->
    <div class="reveal-right space-y-6" id="skillsSection">
      <template x-for="(skill, skillIdx) in skills" :key="skill.name">
        <div>
          <div class="flex justify-between items-center mb-2">
            <span class="font-cond text-sm font-semibold tracking-widest uppercase" x-text="skill.name"></span>
            <span class="font-display text-acid" x-text="skill.pct + '%'"></span>
          </div>
          <div class="h-1 bg-border rounded-full overflow-hidden">
            <div class="skill-bar-fill h-full bg-acid rounded-full" :id="'bar-' + skillIdx" :data-pct="skill.pct"></div>
          </div>
        </div>
      </template>
    </div>

  </div>
</section>