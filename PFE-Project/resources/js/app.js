/*
  FIX 1: Removed `import data from './data.json'` — unused bare import does nothing.
          Data is fetched at runtime inside app() init() via fetch('/data.json').

  FIX 2: Alpine must be imported AND started here, NOT also loaded via CDN in the layout.
          Two Alpine instances = "Alpine is already initialized" error.

  FIX 3: app() function registered as Alpine.data() so x-data="app()" works correctly.
*/

import Alpine from 'alpinejs'
import { appData } from './landingpage.js'
import 'preline'
import { createIcons, icons } from 'lucide'

// Initialize Lucide Icons
window.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

// Re-initialize for Alpine and dynamic content
Alpine.data('app', appData)
Alpine.effect(() => {
    createIcons({ icons });
});

window.Alpine = Alpine
Alpine.start()