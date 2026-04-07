{{-- resources/views/components/public/contact.blade.php --}}

<section id="contact" class="atom-section t-bg border-t t-border">
  <div class="atom-container max-w-5xl">

    <div class="text-center mb-14 reveal">
      <div class="flex items-center justify-center gap-4 mb-4">
        <span class="atom-label">Get In Touch</span>
      </div>
      <h2 class="atom-h-section t-text">
        Start Your <span class="atom-text-accent">Journey</span><br>With Us Today
      </h2>
    </div>

    <div class="reveal t-card t-border border rounded-sm p-8 md:p-12">
      <div class="grid md:grid-cols-2 gap-10 items-start">

        <!-- Info -->
        <div>
          <h3 class="font-display text-2xl uppercase t-text mb-6">Contact <span class="atom-text-accent">Info</span></h3>
          <div class="space-y-5">

            @foreach([
              ['icon' => '<path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'label' => 'Email', 'value' => 'coach@ironcoach.com'],
              ['icon' => '<path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>', 'label' => 'Phone', 'value' => '+1 (555) 000-0000'],
              ['icon' => '<path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>', 'label' => 'Location', 'value' => 'Los Angeles, California'],
            ] as $item)
            <div class="flex items-center gap-4">
              <div class="w-10 h-10 rounded-sm border t-border flex items-center justify-center text-acid flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
              </div>
              <div>
                <div class="atom-label opacity-60">{{ $item['label'] }}</div>
                <div class="font-body text-sm t-sub mt-0.5">{{ $item['value'] }}</div>
              </div>
            </div>
            @endforeach

          </div>
          <div class="neon-line my-8"></div>
          <p class="t-muted text-sm leading-relaxed">Ready to transform your body and mind? Fill out the form and our team will reach out within 24 hours.</p>
        </div>

        <!-- Form -->
        <div class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <input type="text" placeholder="First Name" class="t-input w-full rounded-sm px-4 py-3 text-sm placeholder-gray-500 focus:outline-none focus:border-acid transition-colors font-body border">
            <input type="text" placeholder="Last Name"  class="t-input w-full rounded-sm px-4 py-3 text-sm placeholder-gray-500 focus:outline-none focus:border-acid transition-colors font-body border">
          </div>
          <input type="email" placeholder="Email Address" class="t-input w-full rounded-sm px-4 py-3 text-sm placeholder-gray-500 focus:outline-none focus:border-acid transition-colors font-body border">
          <select class="t-input w-full rounded-sm px-4 py-3 text-sm focus:outline-none focus:border-acid transition-colors font-body appearance-none border">
            <option>Select a Program</option>
            <option>Personal Coaching</option>
            <option>Online Training</option>
            <option>Group Sessions</option>
            <option>Nutrition Consultation</option>
          </select>
          <textarea rows="4" placeholder="Your Message" class="t-input w-full rounded-sm px-4 py-3 text-sm placeholder-gray-500 focus:outline-none focus:border-acid transition-colors resize-none font-body border"></textarea>
          <button class="atom-btn atom-btn-premium w-full py-4">
            Send Message
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </button>
        </div>

      </div>
    </div>

  </div>
</section>