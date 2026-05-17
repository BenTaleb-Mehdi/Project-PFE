@extends('layouts.public')

@section('content')
<div class="relative min-h-screen bg-white dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100 overflow-x-hidden grain " > 
  <!-- Reading Progress Bar -->
  <div class="fixed top-0 left-0 z-[100] h-[3px] bg-brand-500" id="progress-bar" style="width:0%"></div>

  <!-- Navigation Bar -->
  <x-public.navbar :whatsappNumber="$whatsappNumber" />

  <!-- ▌▌▌ HOME PAGE ▌▌▌ -->
  <div x-show="currentPage === 'home'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
    <x-public.hero />
    <x-public.gallery :gallery="$gallery" />
    <x-public.about :features="$features" :stats="$stats" :certs="$certs" :timeline="$timeline" />
    <x-public.digital-app :whatsappNumber="$whatsappNumber" />
    <x-public.testimonials :testimonials="$testimonials" />
    <x-public.cta />
  </div>

  <!-- ▌▌▌ ABOUT PAGE ▌▌▌ -->
  <div x-show="currentPage === 'about'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
    <!-- timeline/certs of Alex Rivera -->
    <section class="pt-36 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid lg:grid-cols-2 gap-16 items-center">
        <div class="space-y-6">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase">About</div>
          <h1 class="font-display text-6xl sm:text-7xl tracking-wider leading-none text-neutral-900 dark:text-white">MEET YOUR<br/><span class="text-brand-500">COACH</span></h1>
          <p class="text-neutral-500 dark:text-neutral-400 leading-relaxed text-lg font-light">I'm Alex Rivera — a certified strength & conditioning specialist with a passion for making fitness accessible, sustainable, and actually enjoyable.</p>
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
            <img src="{{ asset('images/achraf-about.png') }}" alt="Professional Fitness Coach" class="w-full h-full object-cover object-top" />
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

  <!-- ▌▌▌ GALLERY PAGE ▌▌▌ -->
  <div x-show="currentPage === 'gallery'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
    <section class="pt-36 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16 space-y-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase">Gallery</div>
        <h1 class="font-display text-6xl sm:text-7xl tracking-wider text-neutral-900 dark:text-white">CLIENT<br/><span class="text-brand-500">RESULTS</span></h1>
        <p class="text-neutral-500 dark:text-neutral-400 max-w-md mx-auto font-light">Real transformations from individuals who committed to the process.</p>
      </div>

      <!-- Full Gallery Grid (Alpine with Blade fallback) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-20" x-show="gallery && gallery.length > 0">
        <template x-for="(img, i) in (galleryItems || gallery || [])" :key="i">
          <div class="reveal group relative aspect-[4/5] rounded-3xl overflow-hidden bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 cursor-pointer" :class="'delay-' + (i * 100 + 100)" @click="selectedGalleryItem = img">
            <img :src="img.url" :alt="img.alt" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-8">
              <span class="text-white font-display text-2xl tracking-wider" x-text="img.alt"></span>
              <span class="text-brand-400 text-sm font-medium mt-1">Click to view details</span>
            </div>
          </div>
        </template>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-20" x-show="!gallery || gallery.length === 0">
        @foreach($gallery as $index => $item)
          <div class="reveal group relative aspect-[4/5] rounded-3xl overflow-hidden bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 cursor-pointer delay-{{ ($index * 100 + 100) }}" @click="selectedGalleryItem = { url: '{{ $item['url'] }}', alt: '{{ $item['alt'] }}', duration: '{{ $item['duration'] }}', goal: '{{ $item['goal'] }}', details: '{{ addslashes($item['details']) }}' }">
            <img src="{{ $item['url'] }}" alt="{{ $item['alt'] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-8">
              <span class="text-white font-display text-2xl tracking-wider">{{ $item['alt'] }}</span>
              <span class="text-brand-400 text-sm font-medium mt-1">Click to view details</span>
            </div>
          </div>
        @endforeach
      </div>

      <!-- CTA -->
      <div class="max-w-2xl mx-auto text-center p-10 rounded-3xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
        <h2 class="font-display text-4xl tracking-wider mb-4 text-neutral-900 dark:text-white">READY FOR YOUR OWN <span class="text-brand-500">BEFORE & AFTER</span>?</h2>
        <p class="text-neutral-500 dark:text-neutral-400 mb-8 font-light">Stop waiting for the perfect time. The perfect time is right now.</p>
        <button @click="goTo('contact')" class="px-8 py-4 rounded-full bg-brand-500 hover:bg-brand-600 text-white font-medium transition-colors inline-block">Start Your Journey</button>
      </div>
    </section>
  </div>

  <!-- ▌▌▌ BLOG PAGES & DETAIL ▌▌▌ -->
  <x-public.blog :posts="$posts" />

  <!-- ▌▌▌ CONTACT PAGE ▌▌▌ -->
  <x-public.contact :contactInfo="$contactInfo" :socials="$socials" :whatsappNumber="$whatsappNumber" />

  <!-- Footer -->
  <x-public.footer :socials="$socials" />

  <!-- Dynamic Gallery Lightbox Modal -->
  <div
    x-show="selectedGalleryItem"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
    style="display: none;"
  >
    <!-- Backdrop -->
    <div
      x-show="selectedGalleryItem"
      x-transition:enter="transition-opacity ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition-opacity ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="absolute inset-0 bg-neutral-950/90 backdrop-blur-md"
      @click="selectedGalleryItem = null"
    ></div>

    <!-- Modal Content -->
    <div
      x-show="selectedGalleryItem"
      x-transition:enter="transition ease-out duration-300 transform"
      x-transition:enter-start="opacity-0 scale-95 translate-y-4"
      x-transition:enter-end="opacity-100 scale-100 translate-y-0"
      x-transition:leave="transition ease-in duration-200 transform"
      x-transition:leave-start="opacity-100 scale-100 translate-y-0"
      x-transition:leave-end="opacity-0 scale-95 translate-y-4"
      class="relative w-full max-w-5xl bg-white dark:bg-neutral-900 rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row z-10 max-h-[90vh]"
    >
      <button @click="selectedGalleryItem = null" class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-black/70 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>

      <!-- Image Side -->
      <div class="w-full md:w-3/5 aspect-square md:aspect-auto md:min-h-[600px] bg-neutral-100 dark:bg-neutral-950 relative overflow-hidden">
        <img :src="selectedGalleryItem?.url" :alt="selectedGalleryItem?.alt" class="absolute inset-0 w-full h-full object-cover" />
      </div>

      <!-- Details Side -->
      <div class="w-full md:w-2/5 p-8 md:p-10 flex flex-col justify-center border-l border-neutral-200 dark:border-neutral-800 overflow-y-auto">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase mb-4 w-max">Transformation</div>
        <h3 class="font-display text-4xl tracking-wider mb-2 text-neutral-900 dark:text-white" x-text="selectedGalleryItem?.alt"></h3>
        
        <p class="text-neutral-500 dark:text-neutral-400 mb-8 leading-relaxed text-sm" x-text="selectedGalleryItem?.details || 'A dedicated approach to training and nutrition yielded these fantastic results. Consistency and following the tailored protocol made all the difference.'"></p>

        <!-- Stats -->
        <div class="grid grid-cols-2 gap-4 mb-8 pt-6 border-t border-neutral-200 dark:border-neutral-800">
          <div>
            <div class="text-[10px] uppercase tracking-widest text-neutral-400 mb-1">Duration</div>
            <div class="font-display text-2xl text-neutral-900 dark:text-white" x-text="selectedGalleryItem?.duration || '12 Weeks'"></div>
          </div>
          <div>
            <div class="text-[10px] uppercase tracking-widest text-neutral-400 mb-1">Goal</div>
            <div class="font-display text-2xl text-neutral-900 dark:text-white" x-text="selectedGalleryItem?.goal || 'Fat Loss'"></div>
          </div>
        </div>

        <button @click="selectedGalleryItem = null; goTo('contact')" class="w-full py-4 rounded-full bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm tracking-widest uppercase transition-colors mt-auto">Start Your Journey</button>
      </div>
    </div>
  </div>

  <!-- FLOATING ACTIONS (FAB cluster) -->
  <x-public.fab :whatsappNumber="$whatsappNumber" />
</div>
@endsection