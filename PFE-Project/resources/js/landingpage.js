/*
  Consolidated landingpage.js
  All data from data.json is fully merged inline. No runtime fetch is required.
*/
import landingData from './landingpageData.json'
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
    ...landingData,

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
    suggestedQuestions: [
      'What is progressive overload?',
      'How much protein do I need?',
      'Best workout split for beginners?',
      'Tips for better sleep?',
      'How to stay motivated?'
    ],

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
        if (e.key === 'Escape') {
          if (this.menuOpen) this.closeMenu()
          if (this.chatOpen) this.chatOpen = false
        }
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
        console.error('Chatbot error:', error);
        this.chatMessages.push({ role: 'ai', text: 'Sorry, I could not connect to the AI service. Check the browser console (F12) for details, or verify your Gemini API key in the .env file.' });
      } finally {
        this.chatLoading = false;
        this.$nextTick(() => {
          this.scrollToBottom();
        });
      }
    },
    askSuggested(question) {
      this.chatInput = question;
      this.sendChatMessage();
    }

  } /* end return */
}
/* end appData */

export function contactForm() {
  return {
    form: { firstName: '', lastName: '', email: '', phone: '', goal: '', message: '' },
    errors: { firstName: '', lastName: '', email: '', phone: '', goal: '', message: '' },
    loading: false,
    submitted: false,

    validateField(field) {
      if (field === 'firstName') {
        if (!this.form.firstName || !this.form.firstName.trim()) {
          this.errors.firstName = 'First name is required.';
        } else if (this.form.firstName.trim().length < 2) {
          this.errors.firstName = 'Must be at least 2 characters.';
        } else {
          this.errors.firstName = '';
        }
      }
      if (field === 'lastName') {
        if (!this.form.lastName || !this.form.lastName.trim()) {
          this.errors.lastName = 'Last name is required.';
        } else if (this.form.lastName.trim().length < 2) {
          this.errors.lastName = 'Must be at least 2 characters.';
        } else {
          this.errors.lastName = '';
        }
      }
      if (field === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!this.form.email || !this.form.email.trim()) {
          this.errors.email = 'Email address is required.';
        } else if (!emailRegex.test(this.form.email.trim())) {
          this.errors.email = 'Please enter a valid email address.';
        } else {
          this.errors.email = '';
        }
      }
      if (field === 'phone') {
        const phoneRegex = /^\+?[0-9\s\-]{8,15}$/;
        if (!this.form.phone || !this.form.phone.trim()) {
          this.errors.phone = 'Phone number is required.';
        } else if (!phoneRegex.test(this.form.phone.trim())) {
          this.errors.phone = 'Please enter a valid phone number (e.g. +212600000000).';
        } else {
          this.errors.phone = '';
        }
      }
      if (field === 'goal') {
        if (!this.form.goal) {
          this.errors.goal = 'Please select a training goal.';
        } else {
          this.errors.goal = '';
        }
      }
      if (field === 'message') {
        if (!this.form.message || !this.form.message.trim()) {
          this.errors.message = 'Message is required.';
        } else if (this.form.message.trim().length < 10) {
          this.errors.message = 'Must be at least 10 characters.';
        } else {
          this.errors.message = '';
        }
      }
    },

    validateAll() {
      this.validateField('firstName');
      this.validateField('lastName');
      this.validateField('email');
      this.validateField('phone');
      this.validateField('goal');
      this.validateField('message');
      return !Object.values(this.errors).some(err => err !== '');
    },

    async submit() {
      if (!this.validateAll()) {
        return;
      }
      this.loading = true;
      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const response = await fetch('/contact', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken || '',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            name: `${this.form.firstName} ${this.form.lastName}`.trim(),
            email: this.form.email,
            phone: this.form.phone,
            goal: this.form.goal,
            message: this.form.message
          })
        });
        const data = await response.json();
        if (response.ok && data.success) {
          this.submitted = true;
          this.form = { firstName: '', lastName: '', email: '', phone: '', goal: '', message: '' };
          this.errors = { firstName: '', lastName: '', email: '', phone: '', goal: '', message: '' };
        } else {
          alert(data.message || 'Error sending message. Please try again.');
        }
      } catch (err) {
        console.error(err);
        alert('Connection error. Please try again later.');
      } finally {
        this.loading = false;
      }
    }
  }
}