{{-- resources/views/components/public/testimonial.blade.php --}}

<section class="atom-section t-bg-mid border-y t-border">
  <div class="atom-container grid lg:grid-cols-2 gap-12 items-center">

    <div class="reveal">
      <div class="flex items-center gap-4 mb-4">
        <span class="atom-label">Client Reviews</span>
      </div>
      <h2 class="atom-h-section t-text">
        What Our <span class="atom-text-accent">Champions</span><br>Are Saying
      </h2>

      <div class="t-bg t-border border rounded-sm p-6 relative">
        <div class="font-display text-[80px] text-acid/20 leading-none absolute top-2 right-6">"</div>
        <p class="text-gray-300 leading-relaxed mb-6 relative z-10" x-text="testimonials[activeTestimonial]?.text"></p>
        <div class="flex items-center gap-4">
          <div class="w-10 h-10 rounded-full bg-acid/20 border border-acid/40 flex items-center justify-center font-display text-acid" x-text="testimonials[activeTestimonial]?.name.charAt(0)"></div>
          <div>
            <div class="font-cond font-bold tracking-wider uppercase text-sm" x-text="testimonials[activeTestimonial]?.name"></div>
            <div class="atom-label opacity-60 text-[10px]" x-text="testimonials[activeTestimonial]?.role"></div>
          </div>
          <div class="ml-auto flex gap-1">
            <template x-for="s in 5" :key="s">
              <svg class="w-4 h-4 text-acid" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </template>
          </div>
        </div>
        <div class="flex gap-2 mt-5">
          <template x-for="(t, i) in testimonials" :key="i">
            <button @click="activeTestimonial = i"
                    class="h-1 rounded-full transition-all duration-300"
                    :class="activeTestimonial === i ? 'bg-acid w-6' : 'bg-border w-3 hover:bg-gray-500'"></button>
          </template>
        </div>
      </div>
    </div>

    <div class="reveal-right">
      <div class="aspect-square bg-acid/5 rounded-sm border border-acid/20 flex items-center justify-center relative overflow-hidden group">
        <div class="absolute inset-0 bg-grid opacity-20 group-hover:scale-150 transition-transform duration-[2s]"></div>
        <div class="text-acid/20 font-display text-[12vw] leading-none select-none">REVIEWS</div>
      </div>
    </div>

  </div>
</section>