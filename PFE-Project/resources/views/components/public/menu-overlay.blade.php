{{-- resources/views/components/public/menu-overlay.blade.php --}}

<div id="stagger-overlay" :class="menuOpen ? 'open' : ''">

  <!-- Two curtain panels -->
  <div class="curtain-top"></div>
  <div class="curtain-bottom"></div>

  <!-- Inner content -->
  <div class="stagger-inner">

    <!-- Left: big nav links -->
    <div class="flex-1 flex flex-col justify-center px-10 md:px-20 pt-20 pb-10 relative overflow-hidden">

      <div class="absolute inset-0 bg-grid opacity-30 pointer-events-none"></div>

      <!-- Eyebrow -->
      <div class="smenu-item mb-8">
        <span class="smenu-item-inner atom-label t-muted">Navigation</span>
      </div>

      <!-- Links -->
      <nav class="flex flex-col gap-1">
        <div class="smenu-item">
          <a href="#services" class="smenu-link" @click="closeMenu()" @mouseenter="setPreview(0)" @mouseleave="setPreview(-1)">
            <span class="link-num">01</span>Services
            <svg class="link-arrow w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div class="smenu-item">
          <a href="#about" class="smenu-link" @click="closeMenu()" @mouseenter="setPreview(1)" @mouseleave="setPreview(-1)">
            <span class="link-num">02</span>About
            <svg class="link-arrow w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div class="smenu-item">
          <a href="#gallery" class="smenu-link" @click="closeMenu()" @mouseenter="setPreview(5)" @mouseleave="setPreview(-1)">
            <span class="link-num">03</span>Gallery
            <svg class="link-arrow w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div class="smenu-item">
          <a href="#contact" class="smenu-link" @click="closeMenu()" @mouseenter="setPreview(3)" @mouseleave="setPreview(-1)">
            <span class="link-num">04</span>Contact
            <svg class="link-arrow w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div class="smenu-item">
          <a href="#contact" class="smenu-link" @click="closeMenu()" @mouseenter="setPreview(4)" @mouseleave="setPreview(-1)">
            <span class="link-num">05</span>
            <span class="atom-text-accent">Start Now</span>
            <svg class="link-arrow w-10 h-10 text-acid" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </nav>

      <!-- Footer row -->
      <div class="mt-auto pt-10 border-t t-border flex flex-wrap items-center gap-x-10 gap-y-4">
        <div class="smenu-foot-item">
          <span class="smenu-foot-inner atom-label t-muted block">© 2025 IronCoach</span>
        </div>
        <div class="smenu-foot-item flex gap-6">
          <a href="#" class="smenu-foot-inner atom-label t-sub hover:text-acid transition-colors block">Instagram</a>
        </div>
        <div class="smenu-foot-item">
          <a href="#" class="smenu-foot-inner atom-label t-sub hover:text-acid transition-colors block">Twitter</a>
        </div>
        <div class="smenu-foot-item">
          <a href="#" class="smenu-foot-inner atom-label t-sub hover:text-acid transition-colors block">YouTube</a>
        </div>
      </div>
    </div>

    <!-- Right: image preview (desktop only) -->
    <div class="hidden lg:flex items-center justify-center w-[380px] flex-shrink-0 pr-20 relative">
      <div class="menu-preview" style="position:relative;right:auto;top:auto;transform:none;">
        <div class="menu-preview-inner relative w-full h-full">

          <div class="preview-img" :class="activePreview === 0 ? 'active' : ''">
            <div class="absolute inset-0 bg-gradient-to-br from-mid to-dark flex items-center justify-center">
              <div class="text-center">
                <div class="w-20 h-20 rounded-sm border border-acid/40 flex items-center justify-center mx-auto mb-4">
                  <svg class="w-8 h-8 text-acid" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </div>
                <div class="font-display text-2xl text-acid">Services</div>
                <div class="atom-label t-muted mt-1">4 Programs</div>
              </div>
            </div>
          </div>

          <div class="preview-img" :class="activePreview === 1 ? 'active' : ''">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0d1a0d] to-dark flex items-center justify-center">
              <div class="text-center px-6">
                <div class="font-display text-5xl text-acid leading-none mb-2">12+</div>
                <div class="atom-label t-muted">Years Of Coaching</div>
              </div>
            </div>
          </div>

          <div class="preview-img" :class="activePreview === 3 ? 'active' : ''">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0d0d1a] to-dark flex items-center justify-center">
              <div class="text-center px-6">
                <div class="font-display text-2xl mb-3 t-text">Get In Touch</div>
                <div class="atom-label text-acid">coach@ironcoach.com</div>
              </div>
            </div>
          </div>

          <div class="preview-img" :class="activePreview === 4 ? 'active' : ''">
            <div class="absolute inset-0 bg-acid flex items-center justify-center">
              <div class="font-display text-4xl text-dark leading-none text-center">START<br>YOUR<br>JOURNEY</div>
            </div>
          </div>

          <div class="preview-img" :class="activePreview === 5 ? 'active' : ''">
            <div class="absolute inset-0 grid grid-cols-2 gap-1 p-1">
              <div class="bg-gradient-to-br from-[#1a2a0a] to-[#0a0a0a] rounded-sm flex items-center justify-center"><span class="font-display text-acid text-lg">POWER</span></div>
              <div class="bg-gradient-to-br from-[#0a1a2a] to-[#0a0a0a] rounded-sm flex items-center justify-center"><span class="font-display text-white text-lg">CARDIO</span></div>
              <div class="bg-acid rounded-sm flex items-center justify-center"><span class="font-display text-dark text-lg">YOGA</span></div>
              <div class="bg-gradient-to-br from-[#1a1400] to-[#0a0a0a] rounded-sm flex items-center justify-center"><span class="font-display text-acid text-lg">ONLINE</span></div>
            </div>
          </div>

          <div class="preview-img" :class="activePreview === -1 ? 'active' : ''">
            <div class="absolute inset-0 bg-gradient-to-b from-mid to-dark flex items-center justify-center">
              <div class="font-display text-6xl text-white/5 text-center leading-none select-none">IRON<br>COACH</div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>