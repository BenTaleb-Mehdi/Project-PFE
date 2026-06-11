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
