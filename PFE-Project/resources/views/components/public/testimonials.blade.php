@props(['testimonials' => []])

<section class="py-24 lg:py-32">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 space-y-4">
      <div class="reveal inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase">Results</div>
      <h2 class="reveal delay-100 font-display text-5xl sm:text-6xl tracking-wider text-neutral-900 dark:text-white">REAL PEOPLE,<br/><span class="text-brand-500">REAL RESULTS</span></h2>
    </div>

    <!-- Client-side Alpine list -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" x-show="testimonials && testimonials.length > 0">
      <template x-for="(t, i) in testimonials" :key="i">
        <div class="reveal card-hover rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 p-8 space-y-5" :class="'delay-' + (i * 100 + 100)">
          <div class="flex gap-0.5">
            <template x-for="n in 5"><span class="text-brand-500">★</span></template>
          </div>
          <p class="text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed italic" x-text="'&quot;' + t.quote + '&quot;'"></p>
          <div class="flex items-center gap-3 pt-2 border-t border-neutral-200 dark:border-neutral-800">
            <div class="w-10 h-10 rounded-full bg-brand-500/20 flex items-center justify-center font-display text-brand-500 text-lg" x-text="t.name[0]"></div>
            <div>
              <div class="font-semibold text-sm" x-text="t.name"></div>
              <div class="text-xs text-neutral-500 dark:text-neutral-400" x-text="t.result"></div>
            </div>
          </div>
        </div>
      </template>
    </div>

    <!-- Server-side Blade fallback list -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" x-show="!testimonials || testimonials.length === 0">
      @foreach($testimonials as $index => $t)
        <div class="reveal card-hover rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 p-8 space-y-5 delay-{{ ($index * 100 + 100) }}">
          <div class="flex gap-0.5">
            @for($n = 0; $n < 5; $n++)
              <span class="text-brand-500">★</span>
            @endfor
          </div>
          <p class="text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed italic">"{{ $t['quote'] }}"</p>
          <div class="flex items-center gap-3 pt-2 border-t border-neutral-200 dark:border-neutral-800">
            <div class="w-10 h-10 rounded-full bg-brand-500/20 flex items-center justify-center font-display text-brand-500 text-lg">{{ $t['name'][0] }}</div>
            <div>
              <div class="font-semibold text-sm">{{ $t['name'] }}</div>
              <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $t['result'] }}</div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
