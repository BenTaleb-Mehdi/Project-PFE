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

<!-- ▌▌▌ GALLERY PAGE ▌▌▌ -->
<section
    class="pt-36 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
    x-show="currentPage === 'gallery' && gallery && gallery.length > 0"
    x-transition:enter="transition ease-out duration-400"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
>
    <!-- heading -->
    <div class="text-center max-w-3xl mx-auto mb-16">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase mb-4">Transformations</div>
        <h1 class="font-display text-5xl sm:text-6xl tracking-wider text-neutral-900 dark:text-white">OUR <span class="text-brand-500">GALLERY</span></h1>
        <p class="text-neutral-500 dark:text-neutral-400 font-light text-lg">Here are some examples of transformations our clients have achieved with our program.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <template x-for="(img, i) in (galleryItems || gallery || [])" :key="i">
            <div
                class="reveal overflow-hidden rounded-[2rem] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 shadow-xl transition-all duration-300 hover:shadow-2xl"
                :class="'delay-' + (i * 100 + 100)"
            >
                <!-- BEFORE / AFTER -->
                <div
                    class="relative h-[500px]"
                    x-data="{ position: 50 }"
                >
                    <!-- BEFORE IMAGE -->
                    <img
                        :src="img.before"
                        :alt="img.alt"
                        class="absolute inset-0 w-full h-full object-cover"
                        loading="lazy"
                    >

                    <!-- AFTER IMAGE -->
                    <div
                        class="absolute inset-0 overflow-hidden"
                        :style="`clip-path: inset(0 0 0 ${position}%)`"
                    >
                        <img
                            :src="img.after"
                            :alt="img.alt"
                            class="absolute inset-0 w-full h-full object-cover"
                            loading="lazy"
                        >
                    </div>

                    <!-- CENTER LINE -->
                    <div
                        class="absolute top-0 bottom-0 z-30"
                        :style="`left:${position}%`"
                    >
                        <!-- LINE -->
                        <div class="absolute top-0 bottom-0 w-[2px] bg-white"></div>

                        <!-- SLIDER BUTTON -->
                        <div class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2">
                            <div class="w-14 h-14 rounded-full bg-white shadow-2xl flex items-center justify-center border-4 border-brand-500">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-black"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8 9l-4 3m0 0l4 3m-4-3h16m-4-3l4 3m0 0l-4 3"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- RANGE -->
                    <input
                        type="range"
                        min="0"
                        max="100"
                        x-model="position"
                        class="absolute inset-0 z-40 opacity-0 cursor-ew-resize w-full h-full"
                    >

                    <!-- LABELS -->
                    <div class="absolute top-5 left-5 z-40">
                        <div class="px-4 py-2 rounded-full bg-black/40 backdrop-blur-md text-white text-[10px] uppercase tracking-[0.25em]">
                            Before
                        </div>
                    </div>

                    <div class="absolute top-5 right-5 z-40">
                        <div class="px-4 py-2 rounded-full bg-brand-500 text-white text-[10px] uppercase tracking-[0.25em] shadow-lg">
                            After
                        </div>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3
                            class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white"
                            x-text="img.alt"
                        ></h3>
                        <span
                            class="text-brand-500 text-sm font-medium"
                            x-text="img.duration"
                        ></span>
                    </div>

                    <p
                        class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed mb-5"
                        x-text="img.details"
                    ></p>

                    <span
                        class="inline-flex px-4 py-2 rounded-full bg-brand-500/10 text-brand-500 text-xs uppercase tracking-widest font-semibold"
                        x-text="img.goal"
                    ></span>
                </div>
            </div>
        </template>
    </div>
</section>

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

  <!-- CHATBOT BUTTON -->
  <button
    x-show="!chatOpen"
    @click="toggleChat()"
    class="fixed bottom-6 left-6 z-[99] w-14 h-14 rounded-full bg-brand-700 text-white flex items-center justify-center shadow-xl hover:bg-brand-600 transition-all hover:scale-105"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-50"
    x-transition:enter-end="opacity-100 scale-100"
    style="display: none;"
    aria-label="Open chat"
  >
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
  </button>

  <!-- CHATBOT WINDOW -->
  <div
    x-show="chatOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-8 scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-8 scale-95"
    class="fixed bottom-6 left-6 z-[99] w-[380px] bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl border border-neutral-200 dark:border-neutral-700 flex flex-col overflow-hidden"
    style="height: 560px; display: none;"
  >
    <!-- Header -->
    <div class="bg-brand-700 text-white px-5 py-4 flex items-center justify-between shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-lg font-bold">A</div>
        <div>
          <h3 class="font-semibold text-sm">Coach Achraf</h3>
          <p class="text-white/70 text-[11px] flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
            Online
          </p>
        </div>
      </div>
      <button @click="toggleChat()" class="text-white/70 hover:text-white transition-colors p-1">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <!-- Messages -->
    <div class="flex-1 overflow-y-auto p-5 space-y-4 bg-neutral-50 dark:bg-neutral-950/50" id="chat-scroll-container">
      <template x-for="(msg, i) in chatMessages" :key="i">
        <div class="flex" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
          <div
            class="max-w-[85%] px-4 py-3 text-sm leading-relaxed rounded-2xl"
            :class="msg.role === 'user'
              ? 'bg-brand-700 text-white rounded-br-none'
              : 'bg-white dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 border border-neutral-200 dark:border-neutral-700 rounded-bl-none'"
          >
            <p x-text="msg.text"></p>
          </div>
        </div>
      </template>

      <!-- Loading -->
      <div x-show="chatLoading" class="flex justify-start">
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 px-4 py-3 rounded-2xl rounded-bl-none">
          <div class="flex gap-1">
            <div class="w-2 h-2 bg-neutral-300 dark:bg-neutral-600 rounded-full animate-bounce" style="animation-delay:0ms"></div>
            <div class="w-2 h-2 bg-neutral-300 dark:bg-neutral-600 rounded-full animate-bounce" style="animation-delay:150ms"></div>
            <div class="w-2 h-2 bg-neutral-300 dark:bg-neutral-600 rounded-full animate-bounce" style="animation-delay:300ms"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Input -->
    <div class="p-4 border-t border-neutral-200 dark:border-neutral-700 shrink-0 bg-white dark:bg-neutral-900">
      <form @submit.prevent="sendChatMessage()" class="flex items-center gap-2">
        <input
          type="text"
          x-model="chatInput"
          placeholder="Ask me anything..."
          class="flex-1 px-4 py-2.5 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-sm focus:outline-none focus:border-brand-500 placeholder-neutral-400 text-neutral-900 dark:text-white"
          :disabled="chatLoading"
        >
        <button
          type="submit"
          class="w-10 h-10 rounded-xl bg-brand-700 text-white flex items-center justify-center disabled:opacity-50 hover:bg-brand-600 transition-colors shrink-0"
          :disabled="chatLoading || chatInput.trim() === ''"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7l7 7-7 7"/></svg>
        </button>
      </form>
    </div>
  </div>
</div>
@endsection