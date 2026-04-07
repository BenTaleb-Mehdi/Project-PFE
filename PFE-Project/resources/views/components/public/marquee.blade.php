{{-- resources/views/components/public/marquee.blade.php --}}
<div class="border-y t-border t-bg-mid py-4 overflow-hidden">
  <div class="marquee-wrap">
    <div class="marquee-inner gap-12 items-center">
      <template x-for="i in 2" :key="i">
        <div class="flex gap-12 items-center px-6">
          <template x-for="brand in brands" :key="brand">
            <span class="atom-label opacity-40 hover:opacity-100 hover:text-acid transition-all cursor-default whitespace-nowrap" x-text="brand"></span>
          </template>
          <span class="w-2 h-2 rounded-full bg-acid/40 shrink-0"></span>
        </div>
      </template>
    </div>
  </div>
</div>