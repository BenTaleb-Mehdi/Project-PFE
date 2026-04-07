{{-- resources/views/components/public/footer.blade.php --}}

<footer class="py-12 max-w-7xl mx-auto px-6">
  <div class="neon-line mb-10"></div>
  <div class="grid md:grid-cols-4 gap-8 mb-10">

    <!-- Brand -->
    <div class="md:col-span-2">
      <div class="font-display text-3xl tracking-wider mb-3">IRON<span class="atom-text-accent">COACH</span></div>
      <p class="t-muted text-sm leading-relaxed max-w-xs">
        Empowering individuals to achieve peak physical performance through science-backed coaching and relentless dedication.
      </p>
      <div class="flex gap-3 mt-5">
        <template x-for="social in socials" :key="social.name">
          <a :href="social.url" class="w-9 h-9 border t-border rounded-sm flex items-center justify-center t-muted hover:border-acid hover:text-acid transition-colors" x-html="social.icon"></a>
        </template>
      </div>
    </div>

    <!-- Quick Links -->
    <div>
      <div class="atom-label opacity-60 mb-4">Quick Links</div>
      <ul class="space-y-2">
        @foreach(['Services', 'About', 'Gallery', 'Contact'] as $link)
        <li><a href="#{{ strtolower($link) }}" class="text-sm t-sub hover:text-acid transition-colors">{{ $link }}</a></li>
        @endforeach
      </ul>
    </div>

    <!-- Contact info -->
    <div>
      <div class="atom-label opacity-60 mb-4">Contact</div>
      <div class="space-y-2 text-sm t-sub">
        <div>coach@ironcoach.com</div>
        <div>+1 (555) 000-0000</div>
        <div>Los Angeles, California</div>
      </div>
    </div>

  </div>

  <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs t-muted atom-label pt-6 border-t t-border">
    <span>© 2025 IronCoach. All Rights Reserved.</span>
    <span>Built With Precision. Crafted For Champions.</span>
  </div>
</footer>