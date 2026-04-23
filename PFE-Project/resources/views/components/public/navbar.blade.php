{{-- resources/views/components/public/navbar.blade.php --}}

<!-- Scroll Progress Bar -->
<div id="scroll-progress"></div>

<!-- Custom Cursor -->
<div id="cursor"></div>
<div id="cursor-ring"></div>

<nav class="fixed top-0 left-0 right-0 z-[1001] transition-all duration-300"
     :class="scrolled && !menuOpen ? 'bg-dark/95 backdrop-blur-md border-b border-border' : ''">
  <div class="px-6 md:px-10 flex items-center justify-between h-16">

    <!-- Logo -->
    <a href="#" class="font-display text-2xl tracking-wider relative z-[1002]"
       :class="menuOpen ? 'text-white' : ''">
      IRON<span class="text-acid">COACH</span>
    </a>

    <!-- Right side -->
    <div class="flex items-center gap-4">

      <!-- Theme Toggle -->
      <button @click="toggleTheme()" class="theme-toggle" title="Toggle light/dark mode"></button>


      <a href="#contact"
         x-show="!menuOpen"
         class="hidden md:inline-flex text-xs font-cond tracking-widest uppercase hover:text-acid transition-colors">
        Start Now
      </a>

      <!-- Hamburger -->
      <button id="ham-btn"
              @click="toggleMenu()"
              class="relative z-[1002] flex flex-col gap-[6px] items-end p-2 group"
              :class="menuOpen ? 'ham-open' : ''">
        <span class="ham-bar"></span>
        <span class="ham-bar w-[16px]"></span>
        <span class="ham-bar"></span>
        <span class="absolute -inset-2 rounded-full border border-transparent group-hover:border-acid/40 transition-colors duration-300"></span>
      </button>
    </div>
  </div>
</nav>