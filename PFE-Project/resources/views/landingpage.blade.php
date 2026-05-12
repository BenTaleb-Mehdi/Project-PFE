{{-- resources/views/landingpage.blade.php --}}
@extends('layouts.public')

@section('content')

  <x-public.navbar />
  <x-public.menu-overlay />

  {{-- Sections --}}
  <x-public.hero />
  <x-public.marquee />
  <x-public.services />
  <x-public.about />
  <x-public.video />
  <x-public.online-banner />
  <x-public.testimonial />
  <x-public.gallery />
  <x-public.contact />
  <x-public.footer />

  {{-- Floating WhatsApp Button --}}
  <a href="https://wa.me/{{ $whatsappNumber }}" 
     target="_blank" 
     class="fixed bottom-8 right-8 z-[100] group"
     aria-label="Contact on WhatsApp">
    <div class="relative flex items-center justify-center">
      <!-- Outer Glow -->
      <div class="absolute inset-0 bg-emerald-500/30 rounded-full blur-xl group-hover:bg-emerald-500/50 transition-all duration-500 animate-pulse"></div>
      
      <!-- Button Body -->
      <div class="relative bg-emerald-500 hover:bg-emerald-600 text-white p-4 rounded-full shadow-[0_10px_25px_-5px_rgba(16,185,129,0.4)] hover:shadow-[0_20px_35px_-5px_rgba(16,185,129,0.5)] transition-all duration-300 hover:scale-110 active:scale-95 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
        
        <!-- Hover Tooltip -->
        <span class="absolute right-full mr-4 px-3 py-1.5 bg-zinc-900 text-white text-[10px] font-bold uppercase tracking-widest rounded-sm opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-300 pointer-events-none whitespace-nowrap">
          Contact us
        </span>
      </div>
    </div>
  </a>

@endsection