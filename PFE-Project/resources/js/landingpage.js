/*
  Consolidated landingpage.js
  All data from data.json is fully merged inline. No runtime fetch is required.
*/
import chatData from './data.json'
import { askGemini } from './gemini.js'

export function appData() {
  return {

    /* ── Core State ── */
    currentPage:        'home',
    scrolled:           false,
    menuOpen:           false,
    activePreview:      -1,
    countersStarted:    false,
    activeTestimonial:  0,
    lightMode:          (typeof localStorage !== 'undefined') ? localStorage.getItem('ironcoach-theme') === 'light' : false,
    selectedPost:       null,
    selectedGalleryItem: null,
    activeCategory:     'All',

    navItems: [
      { id: 'home',     label: 'Home' },
      { id: 'about',    label: 'About' },
      { id: 'gallery',  label: 'Gallery' },
      { id: 'blog',     label: 'Blog' },
      { id: 'contact',  label: 'Contact' },
    ],

    /* ── Inline Data (previously loaded from data.json via fetch) ── */
    heroStats: {
      clients: 500,
      years: 8,
      rate: 97
    },
    
    features: [
      "Personalized programs — not templates",
      "24/7 WhatsApp support",
      "Weekly progress reviews",
      "Science-backed, no-BS approach"
    ],
    
    reasons: [
      { "title": "Personalized programs", "desc": "Not templates. Built exactly for your unique goals and baseline." },
      { "title": "24/7 WhatsApp support", "desc": "Direct line to your coach for form checks, adjustments, and motivation." },
      { "title": "Weekly progress reviews", "desc": "Data-driven adjustments to keep you progressing past plateaus." },
      { "title": "Science-backed approach", "desc": "No-BS exercise science and habit coaching." }
    ],
    
    stats: [
      { "value": "500+", "label": "Clients coached" },
      { "value": "8+", "label": "Years experience" },
      { "value": "97%", "label": "Client retention" },
      { "value": "3x", "label": "Avg strength gain" }
    ],
    
    testimonials: [
      {
        "name": "Sarah K.",
        "quote": "Alex transformed not just my body but my entire relationship with fitness. Down 28 lbs in 16 weeks and I actually enjoy working out now.",
        "result": "–28 lbs in 16 weeks"
      },
      {
        "name": "Marcus T.",
        "quote": "Best investment I've ever made. The online program is incredibly detailed and the check-ins keep me accountable even when motivation dips.",
        "result": "+18 lbs muscle in 6 months"
      },
      {
        "name": "Priya M.",
        "quote": "I was skeptical about online coaching but the app and daily support made it feel like Alex was right there with me every session.",
        "result": "First 5K in 28 minutes"
      }
    ],
    
    certs: [
      "NSCA-CSCS",
      "NASM-CPT",
      "Precision Nutrition L2",
      "FMS Level 2"
    ],
    
    timeline: [
      {
        "year": "2016",
        "title": "Started Fitness Journey",
        "desc": "Began personal training after struggling with weight and energy for years."
      },
      {
        "year": "2017",
        "title": "NASM Certification",
        "desc": "Obtained CPT certification and began coaching clients at a local gym."
      },
      {
        "year": "2019",
        "title": "NSCA-CSCS",
        "desc": "Earned the Certified Strength & Conditioning Specialist credential."
      },
      {
        "year": "2021",
        "title": "Launched Online Coaching",
        "desc": "Scaled to 100+ online clients worldwide using app-based programming."
      },
      {
        "year": "2024",
        "title": "500 Clients Milestone",
        "desc": "Reached 500 transformed clients with a 97% retention rate."
      }
    ],
    
    posts: [
      {
        "id": 1,
        "category": "Training",
        "date": "May 8, 2025",
        "readTime": "6 min read",
        "emoji": "🏋️",
        "color": "linear-gradient(135deg,#1a1a2e,#16213e)",
        "title": "Progressive Overload: The Only Muscle-Building Principle You Need",
        "excerpt": "If you're not getting stronger over time, you're not growing. Here's exactly how to implement progressive overload systematically.",
        "tags": ["training", "hypertrophy", "strength"],
        "body": "<h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin-bottom:1rem\">What Is Progressive Overload?</h2><p>Progressive overload is the gradual increase of stress placed upon the musculoskeletal and nervous system. In plain terms: you must challenge your muscles <em>more</em> over time for them to keep adapting (growing and strengthening).</p><h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin:1.5rem 0 1rem\">The 5 Ways to Overload</h2><ul style=\"list-style:disc;padding-left:1.5rem;space-y:0.5rem\"><li><strong>Load</strong> — add weight to the bar</li><li><strong>Volume</strong> — more sets or reps at the same weight</li><li><strong>Density</strong> — same work in less time</li><li><strong>Range of motion</strong> — deeper, more complete movements</li><li><strong>Technique</strong> — better motor unit recruitment</li></ul><h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin:1.5rem 0 1rem\">A Simple Weekly Template</h2><p>Start by adding <strong>2.5 kg</strong> to compound lifts each week. Once you can no longer add weight, increase reps (8 → 10 → 12), then deload and start the cycle heavier. This double-progression model works for 90% of trainees.</p><p style=\"margin-top:1rem\">Track every single session. What gets measured, gets improved.</p>"
      },
      {
        "id": 2,
        "category": "Nutrition",
        "date": "Apr 22, 2025",
        "readTime": "5 min read",
        "emoji": "🥗",
        "color": "linear-gradient(135deg,#0f4c35,#1a6b3a)",
        "title": "How Much Protein Do You Actually Need? The Science Explained",
        "excerpt": "Forget the bro-science. Here's what the research actually says about protein requirements for muscle gain and fat loss.",
        "tags": ["nutrition", "protein", "science"],
        "body": "<h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin-bottom:1rem\">The Research Consensus</h2><p>Meta-analyses consistently show that <strong>1.6–2.2g of protein per kg of bodyweight</strong> maximizes muscle protein synthesis for most people. Going above 2.2g has minimal additional benefit but no harm either.</p><h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin:1.5rem 0 1rem\">Practical Targets</h2><ul style=\"list-style:disc;padding-left:1.5rem\"><li><strong>Muscle gain:</strong> 1.8–2.2g/kg</li><li><strong>Fat loss:</strong> 2.0–2.4g/kg (higher to preserve muscle in deficit)</li><li><strong>General health:</strong> 1.2–1.6g/kg</li></ul><p style=\"margin-top:1rem\">For a 75kg person aiming to build muscle, that's roughly 135–165g protein daily. Spread across 4–5 meals for optimal synthesis.</p>"
      },
      {
        "id": 3,
        "category": "Recovery",
        "date": "Apr 10, 2025",
        "readTime": "4 min read",
        "emoji": "😴",
        "color": "linear-gradient(135deg,#2d1b69,#4a2c8a)",
        "title": "Why Sleep Is Your Most Powerful Performance Drug",
        "excerpt": "Every supplement in your stack combined won't come close to what 8 hours of quality sleep does for body composition.",
        "tags": ["recovery", "sleep", "performance"],
        "body": "<h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin-bottom:1rem\">Sleep & Hormones</h2><p>During deep sleep stages (N3 and REM), your body releases the majority of its daily <strong>growth hormone</strong>. Cutting sleep short doesn't just make you tired — it actively reduces anabolic signaling and increases cortisol, the primary catabolic (muscle-breaking) hormone.</p><h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin:1.5rem 0 1rem\">5 Sleep Hygiene Hacks That Actually Work</h2><ol style=\"list-style:decimal;padding-left:1.5rem;space-y:0.5rem\"><li>Set a consistent wake time — even weekends</li><li>No screens 60 minutes before bed (or use blue-light glasses)</li><li>Keep your room at 18°C / 65°F</li><li>Limit caffeine after 2 PM</li><li>10 minutes of box breathing before sleep</li></ol>"
      },
      {
        "id": 4,
        "category": "Mindset",
        "date": "Mar 28, 2025",
        "readTime": "7 min read",
        "emoji": "🧠",
        "color": "linear-gradient(135deg,#7c1d1d,#b91c1c)",
        "title": "Identity-Based Habit Change: Become the Person Who Never Misses",
        "excerpt": "Motivation is unreliable. Identity is bulletproof. How to rewire your self-concept for permanent fitness habits.",
        "tags": ["mindset", "habits", "psychology"],
        "body": "<h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin-bottom:1rem\">Outcome vs. Identity</h2><p>Most people set <em>outcome-based goals</em>: \"I want to lose 20 pounds.\" The problem? Once achieved, the motivation disappears. <strong>Identity-based goals</strong> work differently: \"I am a person who trains 4x per week.\" The behavior becomes the proof you tell yourself about who you are.</p><p style=\"margin-top:1rem\">Every time you follow through on a workout, you cast a vote for that identity. Miss one? You still have hundreds of votes saying you're a trainer.</p><h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin:1.5rem 0 1rem\">How to Start</h2><p>Write down: <em>\"I am the type of person who…\"</em> and complete it with your target behavior. Read it daily. Act accordingly.</p>"
      },
      {
        "id": 5,
        "category": "Training",
        "date": "Mar 14, 2025",
        "readTime": "8 min read",
        "emoji": "⚡",
        "color": "linear-gradient(135deg,#1c1c00,#4a4a00)",
        "title": "The 4-Day Upper/Lower Split: Best Program for Natural Lifters",
        "excerpt": "Four days per week, alternating upper and lower body. It's been around forever because it works — here's how to optimize it.",
        "tags": ["training", "program", "split"],
        "body": "<h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin-bottom:1rem\">Why Upper/Lower Works</h2><p>The upper/lower split hits each muscle group <strong>twice per week</strong> — the research-optimal training frequency for natural lifters. It also allows full recovery between same-muscle sessions while keeping you active 4 days a week.</p><h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin:1.5rem 0 1rem\">Sample Week</h2><ul style=\"list-style:none;padding-left:0;space-y:0.5rem\"><li><strong>Monday — Upper (Strength):</strong> Bench Press, Row, OHP, Pull-ups</li><li><strong>Tuesday — Lower (Strength):</strong> Squat, Romanian DL, Leg Press</li><li><strong>Thursday — Upper (Hypertrophy):</strong> Incline DB, Cable Row, Lateral Raises</li><li><strong>Friday — Lower (Hypertrophy):</strong> Deadlift, Leg Curl, Calf Raises</li></ul>"
      },
      {
        "id": 6,
        "category": "Nutrition",
        "date": "Feb 28, 2025",
        "readTime": "5 min read",
        "emoji": "🔥",
        "color": "linear-gradient(135deg,#431407,#7c2d12)",
        "title": "Calorie Cycling: Eat More on Training Days, Less on Rest Days",
        "excerpt": "A simple nutrient timing strategy that supports muscle growth and fat loss simultaneously — with full explanations.",
        "tags": ["nutrition", "calories", "strategy"],
        "body": "<h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin-bottom:1rem\">The Concept</h2><p>Calorie cycling means eating at or above maintenance on training days (fueling performance and recovery) and eating in a moderate deficit on rest days (encouraging fat oxidation).</p><h2 style=\"font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.05em;margin:1.5rem 0 1rem\">A Simple Formula</h2><p>If your maintenance is <strong>2400 kcal</strong>:</p><ul style=\"list-style:disc;padding-left:1.5rem\"><li><strong>Training days:</strong> 2600 kcal (+200)</li><li><strong>Rest days:</strong> 2000 kcal (–400)</li></ul><p style=\"margin-top:1rem\">Over a week with 4 training days and 3 rest days: <em>4×2600 + 3×2000 = 16,400 kcal</em> vs maintenance of <em>7×2400 = 16,800</em>. A 400 kcal weekly deficit — sustainable and muscle-preserving.</p>"
      }
    ],
    
    gallery: [
      {
        "before": "/images/clients/client-01/before.jpg",
        "after": "/images/clients/client-01/after.jpg",
        "alt": "Client Transformation",
        "duration": "12 Weeks",
        "goal": "Fat Loss",
        "details": "Lost 14kg with personalized nutrition and strength coaching."
      },
      {
        "before": "/images/clients/client-02/before.jpg",
        "after": "/images/clients/client-02/after.jpg",
        "alt": "Body Recomposition",
        "duration": "16 Weeks",
        "goal": "Muscle Gain",
        "details": "Built lean muscle mass while reducing body fat percentage."
      },
      {
        "before": "/images/clients/client-03/before.jpg",
        "after": "/images/clients/client-03/after.jpg",
        "alt": "Strength Transformation",
        "duration": "10 Weeks",
        "goal": "Strength",
        "details": "Improved overall strength and athletic performance."
      }
    ],

    galleryItems: [
      {
        "before": "/images/clients/client-01/before.jpg",
        "after": "/images/clients/client-01/after.jpg",
        "alt": "Client Transformation",
        "duration": "12 Weeks",
        "goal": "Fat Loss",
        "details": "Lost 14kg with personalized nutrition and strength coaching."
      },
      {
        "before": "/images/clients/client-02/before.jpg",
        "after": "/images/clients/client-02/after.jpg",
        "alt": "Body Recomposition",
        "duration": "16 Weeks",
        "goal": "Muscle Gain",
        "details": "Built lean muscle mass while reducing body fat percentage."
      },
      {
        "before": "/images/clients/client-03/before.jpg",
        "after": "/images/clients/client-03/after.jpg",
        "alt": "Strength Transformation",
        "duration": "10 Weeks",
        "goal": "Strength",
        "details": "Improved overall strength and athletic performance."
      }
    ],

    socials: [
      { "name": "Instagram", "url": "#", "icon": "<svg class=\"w-4 h-4\" fill=\"currentColor\" viewBox=\"0 0 24 24\"><path d=\"M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z\"/></svg>" },
      { "name": "Twitter", "url": "#", "icon": "<svg class=\"w-4 h-4\" fill=\"currentColor\" viewBox=\"0 0 24 24\"><path d=\"M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z\"/></svg>" },
      { "name": "YouTube", "url": "#", "icon": "<svg class=\"w-4 h-4\" fill=\"currentColor\" viewBox=\"0 0 24 24\"><path d=\"M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z\"/></svg>" }
    ],

    contactInfo: [
      { "label": "Email", "value": "alex@coachfitnesspro.com", "icon": "<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z\"/></svg>" },
      { "label": "Location", "value": "Los Angeles, CA (& online)", "icon": "<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z\"/><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M15 11a3 3 0 11-6 0 3 3 0 016 0z\"/></svg>" }
    ],

    /* ── Gallery / Lightbox State ── */
    galleryFilter: 'all',
    lightboxOpen:  false,
    lightboxIdx:   0,

    /* ── Chatbot State ── */
    chatOpen: false,
    chatLoading: false,
    chatInput: '',
    chatMessages: [
      { role: 'ai', text: 'Hello! I am Achraf, your Elite Fitness Coach at IRONCOACH. Ask me anything about strength training, custom nutrition plans, or how to get started on your champion body transformation!' }
    ],
    chatHistory: [],

    /* ════════════════════════════════════
       INIT
       No runtime fetch of data.json required!
    ════════════════════════════════════ */
    async init() {
      /* Theme (initialized reactive state directly on load, synchronized to HTML) */
      document.documentElement.classList.toggle('light', this.lightMode)
      document.documentElement.classList.toggle('dark', !this.lightMode)

      /* Global key events */
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && this.menuOpen) this.closeMenu()
      })

      /* Scroll flag */
      window.addEventListener('scroll', () => {
        this.scrolled = window.scrollY > 20
      }, { passive: true })

      /* Reveal animations */
      const revealObs = new IntersectionObserver((entries) => {
        entries.forEach(el => {
          if (el.isIntersecting) {
            el.target.classList.add('in')
            revealObs.unobserve(el.target)
          }
        })
      }, { threshold: 0.12 })
      
      // Observe static elements currently in the DOM
      document.querySelectorAll('.reveal, .reveal-left, .reveal-right')
        .forEach(el => revealObs.observe(el))

      // Wait for Alpine to render dynamic elements, then observe them!
      this.$nextTick(() => {
        document.querySelectorAll('.reveal, .reveal-left, .reveal-right')
          .forEach(el => revealObs.observe(el))
      })

      /* Skill bars */
      const skillObs = new IntersectionObserver((entries) => {
        entries.forEach(el => {
          if (el.isIntersecting) {
            document.querySelectorAll('.skill-bar-fill').forEach(bar => {
              setTimeout(() => { bar.style.width = bar.dataset.pct + '%' }, 200)
            })
            skillObs.disconnect()
          }
        })
      }, { threshold: 0.3 })
      const skillsSection = document.getElementById('skillsSection')
      if (skillsSection) skillObs.observe(skillsSection)

      /* Counters */
      const counterObs = new IntersectionObserver((entries) => {
        entries.forEach(el => {
          if (el.isIntersecting) {
            this.countersStarted = true
            counterObs.disconnect()
          }
        })
      }, { threshold: 0.4 })
      const videoSec = document.getElementById('video')
      if (videoSec) counterObs.observe(videoSec)

      /* Hero stat animation */
      setTimeout(() => {
        this.animateNum('clients', this.heroStats.clients || 500,  1800)
        this.animateNum('years',   this.heroStats.years   || 8,  1500)
        this.animateNum('rate',    this.heroStats.rate    || 97,  2000)
      }, 300)

      /* Testimonial auto-rotate */
      setInterval(() => {
        if (this.testimonials.length) {
          this.activeTestimonial = (this.activeTestimonial + 1) % this.testimonials.length
        }
      }, 5000)

      /* Custom cursor */
      const cursor     = document.getElementById('cursor')
      const cursorRing = document.getElementById('cursor-ring')
      let rx = 0, ry = 0
      document.addEventListener('mousemove', e => {
        if (cursor) { cursor.style.left = e.clientX + 'px'; cursor.style.top = e.clientY + 'px' }
        rx += (e.clientX - rx) * 0.12
        ry += (e.clientY - ry) * 0.12
        if (cursorRing) { cursorRing.style.left = rx + 'px'; cursorRing.style.top = ry + 'px' }
      })
      document.body.addEventListener('mouseenter', (e) => {
        if (!e.target.closest('a, button, .tilt-card, .gallery-item')) return
        if (cursor)     { cursor.style.width = '16px'; cursor.style.height = '16px' }
        if (cursorRing) { cursorRing.style.width = '52px'; cursorRing.style.height = '52px'; cursorRing.style.borderColor = 'rgba(181,255,45,.8)' }
      }, true)
      document.body.addEventListener('mouseleave', (e) => {
        if (!e.target.closest('a, button, .tilt-card, .gallery-item')) return
        if (cursor)     { cursor.style.width = '10px'; cursor.style.height = '10px' }
        if (cursorRing) { cursorRing.style.width = '36px'; cursorRing.style.height = '36px'; cursorRing.style.borderColor = 'rgba(181,255,45,.5)' }
      }, true)

      /* Lenis smooth scroll + progress bar */
      if (typeof Lenis !== 'undefined') {
        const lenis = new Lenis({ duration: 1.2, easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)), smoothWheel: true })
        const raf = (time) => { lenis.raf(time); requestAnimationFrame(raf) }
        requestAnimationFrame(raf)
        const bar = document.getElementById('scroll-progress')
        lenis.on('scroll', ({ progress }) => { if (bar) bar.style.width = (progress * 100) + '%' })
        document.querySelectorAll('a[href^="#"]').forEach(link => {
          link.addEventListener('click', e => {
            const target = document.getElementById(link.getAttribute('href').slice(1))
            if (target) { e.preventDefault(); lenis.scrollTo(target, { offset: -80, duration: 1.4 }) }
          })
        })
      }
    },

    /* ════════════════════════════════════
       HELPERS
       All interactive routines preserved!
    ════════════════════════════════════ */
    animateNum(key, target, duration) {
      const steps = 60
      const step  = target / steps
      let   cur   = 0
      const iv = setInterval(() => {
        cur = Math.min(cur + step, target)
        this.heroStats[key] = Math.round(cur)
        if (cur >= target) clearInterval(iv)
      }, duration / steps)
    },

    /* ── Theme ── */
    toggleTheme() {
      this.lightMode = !this.lightMode
      localStorage.setItem('ironcoach-theme', this.lightMode ? 'light' : 'dark')
      document.documentElement.classList.toggle('light', this.lightMode)
      document.documentElement.classList.toggle('dark', !this.lightMode)
    },

    /* ── Menu ── */
    toggleMenu() { this.menuOpen ? this.closeMenu() : this.openMenu() },
    openMenu()  { this.menuOpen = true;  document.body.style.overflow = 'hidden' },
    closeMenu() { this.menuOpen = false; this.activePreview = -1; document.body.style.overflow = '' },
    setPreview(idx) { this.activePreview = idx },

    /* ── Lightbox ── */
    openLightbox(idx) {
      this.lightboxIdx  = idx
      this.lightboxOpen = true
      document.getElementById('lightbox')?.classList.add('open')
      document.body.style.overflow = 'hidden'
    },
    closeLightbox() {
      this.lightboxOpen = false
      document.getElementById('lightbox')?.classList.remove('open')
      document.body.style.overflow = ''
    },
    lightboxNext() { this.lightboxIdx = (this.lightboxIdx + 1) % this.galleryItems.length },
    lightboxPrev() { this.lightboxIdx = (this.lightboxIdx - 1 + this.galleryItems.length) % this.galleryItems.length },

    /* ── Blog Getters & Actions ── */
    get filteredPosts() {
      if (this.activeCategory === 'All') return this.posts || []
      return (this.posts || []).filter(p => p.category === this.activeCategory)
    },
    goTo(page) {
      this.currentPage = page
      this.selectedPost = null
      window.scrollTo({ top: 0, behavior: 'smooth' })
      setTimeout(() => {
        // Observer for reveal trigger
        const revealObs = new IntersectionObserver((entries) => {
          entries.forEach(el => {
            if (el.isIntersecting) {
              el.target.classList.add('in')
              revealObs.unobserve(el.target)
            }
          })
        }, { threshold: 0.12 })
        document.querySelectorAll('.reveal, .reveal-left, .reveal-right')
          .forEach(el => revealObs.observe(el))
      }, 200)
    },
    openPost(post) {
      if (!post) return
      this.currentPage = 'blog'
      this.selectedPost = post
      window.scrollTo({ top: 0, behavior: 'smooth' })
    },

    /* ── Chatbot Functions ── */
    toggleChat() {
      this.chatOpen = !this.chatOpen;
      if (this.chatOpen) {
        this.$nextTick(() => {
          this.scrollToBottom();
        });
      }
    },
    scrollToBottom() {
      const container = document.getElementById('chat-scroll-container');
      if (container) {
        container.scrollTop = container.scrollHeight;
      }
    },
    async sendChatMessage() {
      if (this.chatInput.trim() === '' || this.chatLoading) return;

      const userText = this.chatInput.trim();
      this.chatMessages.push({ role: 'user', text: userText });
      this.chatInput = '';
      this.chatLoading = true;
      
      this.$nextTick(() => {
        this.scrollToBottom();
      });

      try {
        const aiResponse = await askGemini(userText, this.chatHistory);
        this.chatMessages.push({ role: 'ai', text: aiResponse });
        this.chatHistory.push({ role: 'user', text: userText });
        this.chatHistory.push({ role: 'ai', text: aiResponse });
      } catch (error) {
        this.chatMessages.push({ role: 'ai', text: 'Connection issue. Check your internet and try again.' });
      } finally {
        this.chatLoading = false;
        this.$nextTick(() => {
          this.scrollToBottom();
        });
      }
    }

  } /* end return */
}
/* end appData */

export function contactForm() {
  return {
    form: { firstName: '', lastName: '', email: '', goal: '', message: '' },
    loading: false,
    submitted: false,
    submit() {
      this.loading = true;
      setTimeout(() => {
        this.loading = false;
        this.submitted = true;
      }, 1500);
    }
  }
}