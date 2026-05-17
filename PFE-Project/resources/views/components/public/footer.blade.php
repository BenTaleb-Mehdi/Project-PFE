@props(['socials' => []])

<footer class="bg-neutral-950 text-neutral-400 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
      <div class="space-y-4 lg:col-span-2">
        <a href="#" @click="goTo('home')" class="flex items-center gap-2">
          <span class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29l-1.43-1.43z"/></svg>
          </span>
          <span class="font-display text-xl tracking-widest text-white">COACH<span class="text-brand-500">PRO</span></span>
        </a>
        <p class="text-sm leading-relaxed max-w-xs">Science-backed coaching for those serious about transforming their body and mind. No gimmicks — just results.</p>
      </div>
      <div>
        <div class="text-xs uppercase tracking-widest text-neutral-500 mb-4">Navigate</div>
        <ul class="space-y-2 text-sm">
          <template x-for="item in navItems" :key="item.id">
            <li><a href="#" @click.prevent="goTo(item.id)" class="hover:text-white hover:text-brand-400 transition-colors" x-text="item.label"></a></li>
          </template>
        </ul>
      </div>
      <div>
        <div class="text-xs uppercase tracking-widest text-neutral-500 mb-4">Legal</div>
        <ul class="space-y-2 text-sm">
          <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Cookie Policy</a></li>
        </ul>
      </div>
    </div>
    <div class="pt-8 border-t border-neutral-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
      <span>&copy; 2025 CoachPro. All rights reserved.</span>
      <div class="flex gap-4">
        @foreach($socials as $s)
          <a href="{{ $s['url'] ?? '#' }}" target="_blank" class="hover:text-white transition-colors">{!! $s['icon'] !!}</a>
        @endforeach
      </div>
    </div>
  </div>
</footer>
