/*
  FIX 1: Removed `import data from './data.json'` — unused bare import does nothing.
          Data is fetched at runtime inside app() init() via fetch('/data.json').

  FIX 2: Alpine must be imported AND started here, NOT also loaded via CDN in the layout.
          Two Alpine instances = "Alpine is already initialized" error.

  FIX 3: app() function registered as Alpine.data() so x-data="app()" works correctly.
*/

import Alpine from 'alpinejs'
import { appData, contactForm } from './landingpage.js'
window.contactForm = contactForm
import { coachHub } from './components/nutrition/coach-hub.js'
import { clientDashboard } from './components/nutrition/client-dashboard.js'
import { clientRegistry } from './components/admin/client-registry.js'
import { teamManagement } from './components/admin/team-management.js'
import { financeTracker } from './components/admin/finance-tracker.js'
import { evolutionSync } from './components/client/evolution-sync.js'
import { authController } from './components/auth-controller.js'
import { notificationHub } from './components/notification-hub.js'
import 'preline'
import { createIcons, icons } from 'lucide'
import Lenis from 'lenis'

// Initialize Lucide Icons
window.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

// Re-initialize for Alpine and dynamic content
Alpine.data('app', appData)
Alpine.data('coachHub', coachHub)
Alpine.data('clientDashboard', clientDashboard)
Alpine.data('clientRegistry', clientRegistry)
Alpine.data('teamManagement', teamManagement)
Alpine.data('financeTracker', financeTracker)
Alpine.data('evolutionSync', evolutionSync)
Alpine.data('authController', authController)
Alpine.data('notificationHub', notificationHub)

window.Alpine = Alpine
Alpine.start()

// Initialize Lenis Smooth Scroll
const lenis = new Lenis({
    autoRaf: true,
    smoothWheel: true,
    duration: 1.2,
});