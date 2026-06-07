@props(['whatsappNumber'])

<header
  class="fixed top-0 inset-x-0 z-[1000] transition-all duration-500"
  :class="scrolled ? 'bg-white/70 dark:bg-neutral-950/70 backdrop-blur-xl border-b border-neutral-200/30 dark:border-neutral-800/30 shadow-md shadow-black/5' : 'bg-transparent'"
>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16 lg:h-20 transition-all duration-300">

    <!-- Logo -->
    <a href="#" @click="goTo('home')" class="flex items-center gap-2 group relative z-50">
      <span class="font-display text-xl font-light tracking-[0.15em] text-neutral-900 dark:text-white uppercase transition-transform duration-300 group-hover:scale-105">
        Achraf<span class="text-brand-500 font-semibold">Kfit</span>
      </span>
    </a>

    <!-- Modern Desktop Navigation Loop -->
    <nav class="hidden md:flex items-center gap-10 text-xs tracking-widest uppercase font-medium">
      <template x-for="item in navItems" :key="item.id">
        <a
          href="#"
          @click.prevent="goTo(item.id)"
          class="relative py-2 text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-all duration-300"
          :class="{ 'text-neutral-900 dark:text-white font-semibold': currentPage === item.id }"
        >
          <span x-text="item.label"></span>
          <!-- Minimalist Dot Active Indicator beneath text -->
          <span 
            class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1 h-1 bg-brand-500 rounded-full transition-all duration-300"
            :class="currentPage === item.id ? 'opacity-100 scale-100' : 'opacity-0 scale-50'"
          ></span>
        </a>
      </template>
    </nav>

    <!-- Right Side Actions Counterparts -->
    <div class="flex items-center gap-4 relative z-50">
      
      <!-- Theme Switcher -->
      <button
        @click="toggleTheme()"
        class="w-9 h-9 rounded-full flex items-center justify-center border border-neutral-200/40 dark:border-neutral-800/40 bg-neutral-50/50 dark:bg-neutral-900/50 hover:border-brand-500/50 dark:hover:border-brand-500/50 transition-all duration-300"
        :aria-label="lightMode ? 'Dark mode' : 'Light mode'"
      >
        <svg x-show="!lightMode" class="w-4 h-4 text-neutral-700 dark:text-neutral-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
        <svg x-show="lightMode" class="w-4 h-4 text-neutral-700 dark:text-neutral-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
      </button>

      <!-- Action Button: Start Now -->
      <button
        @click="goTo('contact')"
        class="hidden sm:inline-flex items-center justify-center px-6 py-2.5 rounded-full border border-neutral-900 dark:border-white bg-neutral-900 dark:bg-white text-white dark:text-neutral-950 hover:bg-brand-500 dark:hover:bg-brand-500 hover:text-neutral-950 dark:hover:text-neutral-950 text-xs tracking-widest uppercase font-semibold transition-all duration-300 shadow-sm"
      >
        Start Now
      </button>

      @auth
        <a
          href="{{ route('home') }}"
          class="hidden sm:inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-brand-500 hover:bg-brand-600 text-neutral-950 text-xs tracking-widest uppercase font-semibold transition-all duration-300 shadow-sm shadow-brand-500/10"
        >
          Dashboard
        </a>
      @endauth

      <!-- Minimalist Hamburger Menu Button -->
      <button 
        @click="toggleMenu()" 
        class="md:hidden w-10 h-10 flex flex-col items-center justify-center gap-1.5 rounded-full border border-neutral-200/40 dark:border-neutral-800/40 bg-neutral-50/50 dark:bg-neutral-900/50 transition-all duration-300"
        aria-label="Menu"
      >
        <span class="block w-5 h-0.5 bg-neutral-900 dark:bg-white transition-all duration-300" :class="menuOpen ? 'rotate-45 translate-y-2' : ''"></span>
        <span class="block w-4 h-0.5 bg-neutral-900 dark:bg-white transition-all duration-300" :class="menuOpen ? 'opacity-0' : ''"></span>
        <span class="block w-5 h-0.5 bg-neutral-900 dark:bg-white transition-all duration-300" :class="menuOpen ? '-rotate-45 -translate-y-1' : ''"></span>
      </button>
    </div>
  </div>

  <!-- Mobile Nav Overlay -->
  <div
    x-show="menuOpen"
    x-transition:enter="transition-opacity ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-neutral-950/60 z-[1001] md:hidden backdrop-blur-md"
    @click="closeMenu()"
  ></div>

  <!-- Mobile Nav Panel (Preserving theme utilities exactly) -->
  <div
    x-show="menuOpen"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed top-0 left-0 bottom-0 w-[85%] max-w-sm t-bg t-border border-r z-[1002] flex flex-col shadow-2xl md:hidden"
  >
    <!-- Mobile Top Header -->
    <div class="flex items-center justify-between p-6 t-border border-b">
      <span class="font-display text-lg font-light tracking-[0.15em] t-text uppercase">
        Achraf<span class="text-brand-500 font-semibold">Kfit</span>
      </span>
      <button @click="closeMenu()" class="text-neutral-400 hover:text-brand-500 transition-colors p-1.5 rounded-full bg-neutral-100 dark:bg-neutral-900">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <!-- Mobile Nav Links -->
    <div class="px-6 py-8 flex flex-col gap-5 flex-1 overflow-y-auto">
      <template x-for="item in navItems" :key="item.id">
        <a
          href="#"
          @click.prevent="goTo(item.id); closeMenu()"
          class="text-base font-medium tracking-wide uppercase t-text hover:text-brand-500 transition-colors py-1 flex items-center justify-between group"
          :class="{ 'text-brand-500 font-semibold': currentPage === item.id }"
        >
          <span x-text="item.label"></span>
          <svg class="w-4 h-4 opacity-0 -translate-x-2 transition-all group-hover:opacity-100 group-hover:translate-x-0 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
      </template>
    </div>

    <!-- Mobile Bottom Panel Actions -->
    <div class="p-6 t-border border-t flex flex-col gap-3 bg-neutral-50/50 dark:bg-neutral-950/20">
      @auth
        <a href="{{ route('home') }}" class="w-full py-3.5 bg-brand-500 hover:bg-brand-600 text-neutral-950 font-semibold tracking-widest uppercase text-xs transition-all duration-300 text-center rounded-xl block shadow-sm">Dashboard</a>
      @endauth
       
      
      <button @click="goTo('contact'); closeMenu()" class="w-full py-3.5 bg-neutral-900 dark:bg-white hover:bg-brand-500 dark:hover:bg-brand-500 text-white dark:text-neutral-950 hover:text-neutral-950 dark:hover:text-neutral-950 font-semibold tracking-widest uppercase text-xs transition-all duration-300 rounded-xl">
        Start Now
      </button>
    </div>
  </div>
</header>