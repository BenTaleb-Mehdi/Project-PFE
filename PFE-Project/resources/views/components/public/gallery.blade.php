{{-- resources/views/components/public/gallery.blade.php --}}

<section id="gallery" class="atom-section t-bg">
  <div class="atom-container">

    <div class="mb-12 reveal">
      <div class="flex items-center gap-4 mb-4">
        <span class="atom-label">Behind The Scenes</span>
      </div>
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <h2 class="atom-h-section t-text">Training <span class="atom-text-accent">Gallery</span></h2>
        <p class="t-muted text-sm max-w-xs leading-relaxed">Real sessions, real results. A look inside the IronCoach experience.</p>
      </div>
    </div>

    <!-- Grid -->
    <div class="gallery-grid reveal">
      <template x-for="(item, idx) in galleryItems" :key="idx">
        <div class="gallery-item rounded-sm overflow-hidden"
             x-show="galleryFilter === 'all' || item.category === galleryFilter"
             @click="openLightbox(idx)">
          <div class="w-full h-full flex items-center justify-center p-6 transition-transform duration-700 hover:scale-110"
               :style="'background:' + item.bg">
            <div class="text-center">
              <div class="font-display text-2xl md:text-3xl leading-none mb-1"
                   :class="item.category === 'mindset' ? 'text-dark' : 'text-acid'"
                   x-text="item.title"></div>
              <div class="atom-label opacity-60"
                   :class="item.category === 'mindset' ? 'text-dark/70' : 't-muted'"
                   x-text="item.sub"></div>
            </div>
          </div>
          <div class="gallery-overlay">
            <span class="atom-label text-white/80" x-text="item.title"></span>
          </div>
        </div>
      </template>
    </div>

    <!-- Filter pills -->
    <div class="flex flex-wrap gap-3 mt-8 reveal">
      @foreach(['all' => 'All', 'strength' => 'Strength', 'cardio' => 'Cardio', 'online' => 'Online', 'mindset' => 'Mindset'] as $key => $label)
      <button @click="galleryFilter='{{ $key }}'"
              :class="galleryFilter==='{{ $key }}' ? 'bg-acid text-dark' : 't-card t-border t-muted border'"
              class="atom-label px-4 py-2 rounded-sm transition-all">
        {{ $label }}
      </button>
      @endforeach
    </div>

  </div>
</section>

<!-- Lightbox -->
<div id="lightbox" @click="closeLightbox()" @keydown.escape.window="closeLightbox()">
  <button class="absolute top-6 right-8 text-white/60 hover:text-acid transition-colors font-display text-3xl z-10" @click.stop="closeLightbox()">✕</button>
  <div class="relative flex items-center justify-center w-full h-full">
    <button class="absolute left-6 w-12 h-12 border border-white/20 rounded-full flex items-center justify-center text-white hover:border-acid hover:text-acid transition-colors z-10" @click.stop="lightboxPrev()">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    </button>
    <template x-if="galleryItems.length > 0">
      <div class="max-w-3xl w-full mx-20 t-card t-border border rounded-sm overflow-hidden" @click.stop>
        <div class="aspect-video flex items-center justify-center" :style="'background:' + galleryItems[lightboxIdx].bg">
          <div class="text-center px-8">
            <div class="font-display text-5xl text-acid mb-2" x-text="galleryItems[lightboxIdx].title"></div>
            <div class="font-cond text-xs tracking-widest uppercase t-muted" x-text="galleryItems[lightboxIdx].sub"></div>
          </div>
        </div>
        <div class="p-5 t-bg-mid flex items-center justify-between">
          <div>
            <div class="font-cond font-bold tracking-wider uppercase text-sm t-text" x-text="galleryItems[lightboxIdx].title"></div>
            <div class="font-cond text-xs t-muted mt-1" x-text="galleryItems[lightboxIdx].sub"></div>
          </div>
          <div class="font-display text-acid text-lg" x-text="(lightboxIdx+1) + ' / ' + galleryItems.length"></div>
        </div>
      </div>
    </template>
    <button class="absolute right-6 w-12 h-12 border border-white/20 rounded-full flex items-center justify-center text-white hover:border-acid hover:text-acid transition-colors z-10" @click.stop="lightboxNext()">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </button>
  </div>
</div>