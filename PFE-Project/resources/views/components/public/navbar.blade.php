@props(['whatsappNumber'])

<header
  class="fixed top-0 inset-x-0 z-[1000] transition-all duration-300"
  :class="scrolled ? 'bg-white/80 dark:bg-neutral-950/80 backdrop-blur-xl shadow-sm shadow-black/5' : 'bg-transparent'"
>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16 lg:h-20">

    <!-- Logo -->
    <a href="#" @click="goTo('home')" class="flex items-center gap-2 group">
      <span class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center">
        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29l-1.43-1.43z"/></svg>
      </span>
      <span class="font-display text-xl tracking-widest text-neutral-900 dark:text-white">COACH<span class="text-brand-500">PRO</span></span>
    </a>

    <!-- Desktop nav -->
    <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
      <template x-for="item in navItems" :key="item.id">
        <a
          href="#"
          @click.prevent="goTo(item.id)"
          class="nav-link text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-colors"
          :class="{ 'active text-brand-500 dark:text-brand-400': currentPage === item.id }"
          x-text="item.label"
        ></a>
      </template>
    </nav>

    <!-- Right actions -->
    <div class="flex items-center gap-3">
      <!-- Dark mode -->
      <button
        @click="toggleTheme()"
        class="w-9 h-9 rounded-full flex items-center justify-center bg-neutral-100 dark:bg-neutral-800 hover:bg-brand-100 dark:hover:bg-brand-900/40 transition-colors"
        :aria-label="lightMode ? 'Dark mode' : 'Light mode'"
      >
        <svg x-show="!lightMode" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
        <svg x-show="lightMode" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
      </button>

      <button
        @click="goTo('contact')"
        class="hidden sm:inline-flex items-center gap-2 px-5 py-2 rounded-full border border-neutral-300 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-900 text-sm font-medium transition-colors"
      >
        Start Now
      </button>

      @auth
        <a
          href="{{ route('home') }}"
          class="hidden sm:inline-flex items-center gap-2 px-5 py-2 rounded-full bg-brand-500 hover:bg-brand-600 text-neutral-950 text-sm font-medium transition-colors"
        >
          Dashboard
        </a>
      
      @endauth

      <!-- Hamburger -->
      <button @click="toggleMenu()" class="md:hidden w-9 h-9 flex flex-col items-center justify-center gap-1.5">
        <span class="block w-5 h-0.5 bg-current transition-all" :class="menuOpen ? 'rotate-45 translate-y-2' : ''"></span>
        <span class="block w-5 h-0.5 bg-current transition-all" :class="menuOpen ? 'opacity-0' : ''"></span>
        <span class="block w-5 h-0.5 bg-current transition-all" :class="menuOpen ? '-rotate-45 -translate-y-2' : ''"></span>
      </button>
    </div>
  </div>

  <!-- Mobile nav overlay -->
  <div
    x-show="menuOpen"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-neutral-900/80 z-[1001] md:hidden backdrop-blur-sm"
    @click="closeMenu()"
  ></div>

  <!-- Mobile nav panel -->
  <div
    x-show="menuOpen"
    x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed top-0 left-0 bottom-0 w-[80%] max-w-sm t-bg t-border border-r z-[1002] flex flex-col shadow-2xl md:hidden"
  >
    <div class="flex items-center justify-between p-6 t-border border-b">
      <span class="font-display text-xl tracking-widest t-text">COACH<span class="text-brand-500">PRO</span></span>
      <button @click="closeMenu()" class="text-neutral-500 hover:text-brand-500 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="px-6 py-8 flex flex-col gap-6 flex-1 overflow-y-auto">
      <template x-for="item in navItems" :key="item.id">
        <a
          href="#"
          @click.prevent="goTo(item.id); closeMenu()"
          class="text-lg font-medium t-text hover:text-brand-500 transition-colors"
          :class="{ 'text-brand-500': currentPage === item.id }"
          x-text="item.label"
        ></a>
      </template>
    </div>
    <div class="p-6 t-border border-t flex flex-col gap-2">
      @auth
        <a href="{{ route('home') }}" class="w-full py-4 bg-brand-500 hover:bg-brand-600 text-neutral-950 font-medium tracking-widest uppercase text-sm transition-colors text-center block">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="w-full py-4 bg-brand-500 hover:bg-brand-600 text-neutral-950 font-medium tracking-widest uppercase text-sm transition-colors text-center block">Login</a>
      @endauth
      <button @click="goTo('contact'); closeMenu()" class="w-full py-4 border t-border t-text hover:bg-neutral-100 dark:hover:bg-neutral-900/50 font-medium tracking-widest uppercase text-sm transition-colors">Start Now</button>
    </div>
  </div>
</header>
