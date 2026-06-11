<!-- ▌▌▌ ABOUT PAGE ▌▌▌ -->
<div x-show="currentPage === 'about'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
    <!-- timeline/certs of Alex Rivera -->
    <section class="pt-36 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid lg:grid-cols-2 gap-16 items-center">
        <div class="space-y-6">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase">About</div>
          <h1 class="font-display text-6xl sm:text-7xl tracking-wider leading-none text-neutral-900 dark:text-white">MEET YOUR<br/><span class="text-brand-500">COACH</span></h1>
          <p class="text-neutral-500 dark:text-neutral-400 leading-relaxed text-lg font-light">I'm Achraf kfit — a certified strength & conditioning specialist with a passion for making fitness accessible, sustainable, and actually enjoyable.</p>
          <p class="text-neutral-500 dark:text-neutral-400 leading-relaxed font-light">After struggling with my own fitness journey for years, I found a method that truly works: combining progressive overload with habit science and mindset coaching. Today I bring that same system to every single client.</p>
          <p class="text-neutral-500 dark:text-neutral-400 leading-relaxed font-light">I hold certifications from the NSCA (CSCS), NASM (CPT), and Precision Nutrition. My approach is rooted in research, but delivered with empathy and real-world practicality.</p>
          <div class="flex flex-wrap gap-3 pt-2">
            @foreach($certs as $cert)
              <span class="px-4 py-2 rounded-full border border-brand-500/30 bg-brand-500/5 text-brand-600 dark:text-brand-400 text-xs font-medium">{{ $cert }}</span>
            @endforeach
          </div>
        </div>
        <div class="relative font-light">
          <div class="aspect-[3/4] rounded-3xl bg-gradient-to-br from-brand-500/20 to-brand-700/20 border border-brand-500/20 flex items-end justify-center overflow-hidden">
            <img src="{{ asset('images/images-coach/coach-03.jpg') }}" alt="Professional Fitness Coach" class="w-full h-full object-cover object-top" />
          </div>
          <div class="absolute -bottom-6 -left-6 bg-white dark:bg-neutral-900 rounded-2xl shadow-xl p-5 space-y-1">
            <div class="font-display text-3xl text-brand-500">500+</div>
            <div class="text-xs text-neutral-500 uppercase tracking-widest">Clients Coached</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Timeline Journey -->
    <section class="py-20 bg-neutral-50 dark:bg-neutral-900/50">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-display text-4xl tracking-wider text-center mb-12 text-neutral-900 dark:text-white">MY <span class="text-brand-500">JOURNEY</span></h2>
        <div class="space-y-0">
          @foreach($timeline as $index => $t)
            <div class="flex gap-6">
              <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center shrink-0 text-white font-bold text-xs">{{ $t['year'] }}</div>
                @if($index < count($timeline) - 1)
                  <div class="flex-1 w-px bg-brand-500/20 my-2"></div>
                @endif
              </div>
              <div class="pb-8">
                <div class="font-semibold mb-1 text-neutral-900 dark:text-white">{{ $t['title'] }}</div>
                <div class="text-sm text-neutral-500 dark:text-neutral-400 font-light">{{ $t['desc'] }}</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <section class="py-20 text-center">
      <div class="max-w-xl mx-auto px-4 space-y-6">
        <h2 class="font-display text-5xl tracking-wider text-neutral-900 dark:text-white">TRAIN WITH<br/><span class="text-brand-500">ME</span></h2>
        <p class="text-neutral-500 dark:text-neutral-400 font-light">Ready to stop guessing and start progressing? Let's build your custom program today.</p>
        <button @click="goTo('contact')" class="px-8 py-4 rounded-full bg-brand-500 hover:bg-brand-600 text-white font-medium transition-colors">Book Your Free Call</button>
      </div>
    </section>
</div>
