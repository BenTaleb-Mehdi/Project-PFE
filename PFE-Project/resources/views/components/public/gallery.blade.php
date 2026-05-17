@props(['gallery' => []])

<section id="gallery" class="py-24 lg:py-32">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
      <div class="space-y-4">
        <div class="reveal inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase">Gallery</div>
        <h2 class="reveal delay-100 font-display text-5xl sm:text-6xl tracking-wider text-neutral-900 dark:text-white">CLIENT <span class="text-brand-500">RESULTS</span></h2>
      </div>
      <button @click="goTo('gallery')" class="reveal self-start sm:self-auto inline-flex items-center gap-2 text-brand-500 font-medium hover:underline">
        View Full Gallery
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </button>
    </div>

    <!-- Client-side / Alpine dynamic grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6" x-show="(gallery && gallery.length > 0) || (galleryItems && galleryItems.length > 0)">
      <template x-for="(img, i) in (galleryItems || gallery || []).slice(0, 6)" :key="i">
        <div
          class="reveal group relative aspect-[4/5] rounded-2xl overflow-hidden bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 cursor-pointer"
          :class="'delay-' + (i * 100 + 100)"
          @click="selectedGalleryItem = img"
        >
          <img :src="img.url" :alt="img.alt" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
            <span class="text-white font-medium text-sm tracking-wider uppercase" x-text="img.alt"></span>
            <span class="text-brand-400 text-xs font-medium mt-1">Click to view details</span>
          </div>
        </div>
      </template>
    </div>

    <!-- Server-side fallback list (displays while Javascript is loading or if it's disabled) -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6" x-show="!gallery || gallery.length === 0">
      @foreach(array_slice($gallery, 0, 6) as $index => $item)
        <div
          class="reveal group relative aspect-[4/5] rounded-2xl overflow-hidden bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 cursor-pointer delay-{{ ($index * 100 + 100) }}"
          @click="selectedGalleryItem = { url: '{{ $item['url'] }}', alt: '{{ $item['alt'] }}', duration: '{{ $item['duration'] }}', goal: '{{ $item['goal'] }}', details: '{{ addslashes($item['details']) }}' }"
        >
          <img src="{{ $item['url'] }}" alt="{{ $item['alt'] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
            <span class="text-white font-medium text-sm tracking-wider uppercase">{{ $item['alt'] }}</span>
            <span class="text-brand-400 text-xs font-medium mt-1">Click to view details</span>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
