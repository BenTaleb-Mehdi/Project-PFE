@props(['whatsappNumber'])

<div class="fixed bottom-6 right-6 z-[99] flex flex-col items-end gap-4 pointer-events-none">
  <!-- Scroll to Top -->
  <button 
    x-show="scrolled" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    @click="window.scrollTo({top: 0, behavior: 'smooth'})"
    class="w-12 h-12 rounded-full bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-300 flex items-center justify-center shadow-lg hover:text-brand-500 transition-colors pointer-events-auto"
    aria-label="Scroll to top"
    style="display: none;"
  >
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
  </button>

  <!-- FAB Speed Dial -->
  <div x-data="{ fabOpen: false }" class="relative pointer-events-auto">
    
    <!-- Flower Items (Quarter Circle) -->
    <!-- Instagram (Top) -->
    <a 
      href="https://www.instagram.com/achraf_knfit/"
      target="_blank"
      class="absolute w-12 h-12 rounded-full bg-[#E1306C] text-white flex items-center justify-center shadow-lg transition-all duration-300 ease-out"
      :class="fabOpen ? '-translate-y-[80px] scale-100 opacity-100' : 'translate-y-0 scale-50 opacity-0 pointer-events-none'"
      aria-label="Instagram"
    >
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
    </a>

    <!-- Contact Page (Top-Left Diagonal) -->
    <button 
      @click="goTo('contact'); fabOpen = false"
      class="absolute w-12 h-12 rounded-full bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 flex items-center justify-center shadow-lg transition-all duration-300 ease-out delay-75"
      :class="fabOpen ? '-translate-x-[56px] -translate-y-[56px] scale-100 opacity-100' : 'translate-x-0 translate-y-0 scale-50 opacity-0 pointer-events-none'"
      aria-label="Contact"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
    </button>

    <!-- WhatsApp (Left) -->
    <a 
      href="https://wa.me/{{ $whatsappNumber }}"
      target="_blank"
      class="absolute w-12 h-12 rounded-full bg-[#25D366] text-white flex items-center justify-center shadow-lg transition-all duration-300 ease-out delay-150"
      :class="fabOpen ? '-translate-x-[80px] scale-100 opacity-100' : 'translate-x-0 scale-50 opacity-0 pointer-events-none'"
      aria-label="WhatsApp"
    >
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 .002 5.385.002 12.033c0 2.127.553 4.2 1.603 6.03L.044 24l6.096-1.597c1.782.955 3.791 1.458 5.889 1.458 6.645 0 12.028-5.386 12.028-12.033S18.677 0 12.031 0zm0 21.841c-1.802 0-3.568-.485-5.116-1.403l-.367-.218-3.799.996.996-3.702-.239-.38A9.972 9.972 0 012.023 12.03c0-5.521 4.494-10.015 10.01-10.015 5.518 0 10.014 4.494 10.014 10.015s-4.496 10.015-10.014 10.015h-.002l-.001-.004zm5.494-7.514c-.301-.151-1.781-.88-2.057-.98-.276-.1-.476-.151-.677.15-.2.302-.777.98-.952 1.182-.176.201-.352.226-.653.075-1.58-.752-2.73-1.63-3.805-3.393-.203-.334.204-.312.639-.933.15-.226.076-.426-.001-.577-.075-.15-.676-1.63-.926-2.23-.245-.588-.495-.508-.677-.517-.176-.01-.376-.012-.577-.012-.2 0-.526.076-.801.377-.276.3-1.053 1.03-1.053 2.511 0 1.481 1.078 2.912 1.228 3.113.15.201 2.125 3.242 5.147 4.545.719.31 1.28.496 1.716.635.722.23 1.38.197 1.898.12.576-.086 1.781-.728 2.032-1.431.25-.703.25-1.306.175-1.431-.076-.126-.276-.202-.577-.353z"/></svg>
    </a>

    <!-- Main FAB Button -->
    <button 
      @click="fabOpen = !fabOpen"
      @click.outside="fabOpen = false"
      class="w-14 h-14 rounded-full bg-brand-700 text-white flex items-center justify-center shadow-xl hover:bg-brand-600 transition-colors z-10 relative"
    >
      <svg class="w-6 h-6 transition-transform duration-300" :class="fabOpen ? 'rotate-45' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    </button>
  </div>
</div>
