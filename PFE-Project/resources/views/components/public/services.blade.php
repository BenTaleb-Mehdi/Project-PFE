{{-- resources/views/components/public/services.blade.php --}}

<section id="services" class="atom-section">
  <div class="atom-container">

    <div class="mb-16 reveal">
      <div class="flex items-center gap-4 mb-4">
        <span class="atom-label">What We Offer</span>
      </div>
      <h2 class="atom-h-section">
        This Is Our <span class="atom-text-accent">Service</span><br>During Training
      </h2>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">

      @php
      $cards = [
        ['icon' => '<path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3"/>', 'title' => 'Free Food & Drinks', 'desc' => 'We provide varieties of snacks and drinking water to keep you fueled during every training session.'],
        ['icon' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>', 'title' => 'Choose Your Trainer', 'desc' => 'Select any fitness trainer you feel comfortable with or who matches your personal training style.'],
        ['icon' => '<path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>', 'title' => 'Fast Service', 'desc' => 'Every customer receives excellent service with minimal wait times, maximum attention, and zero hassle.'],
        ['icon' => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z M9 22V12h6v10"/>', 'title' => 'Cool & Clean Rest Room', 'desc' => 'We always maintain our premium facilities in perfect condition for your comfort and recovery.'],
      ];
      @endphp

      @foreach($cards as $i => $card)
      <div class="tilt-card reveal bg-mid border border-border rounded-sm p-6 group cursor-default" style="transition-delay:{{ $i * 0.1 }}s">
        <div class="w-12 h-12 rounded-sm bg-dark border border-border flex items-center justify-center mb-5 group-hover:border-acid group-hover:text-acid text-gray-500 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $card['icon'] !!}</svg>
        </div>
        <div class="h-0.5 w-8 bg-acid mb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <h3 class="font-display text-xl uppercase mb-3 group-hover:text-acid transition-colors">{{ $card['title'] }}</h3>
        <p class="text-gray-500 text-sm leading-relaxed">{{ $card['desc'] }}</p>
        <button class="mt-5 font-cond text-xs tracking-widest uppercase text-gray-500 group-hover:text-acid transition-colors flex items-center gap-2">
          Learn More
          <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </div>
      @endforeach

    </div>
  </div>
</section>