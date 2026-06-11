@extends('layouts.public')

@section('content')
<div class="relative min-h-screen bg-white dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100 overflow-x-hidden grain " > 
  @include('partials.landingpage.progress-bar')

  <!-- Navigation Bar -->
  <x-public.navbar :whatsappNumber="$whatsappNumber" />

  @include('partials.landingpage.home-page')
  @include('partials.landingpage.about-page')
  @include('partials.landingpage.gallery-page')

  <!-- ▌▌▌ BLOG PAGES & DETAIL ▌▌▌ -->
  <x-public.blog :posts="$posts" />

  <!-- ▌▌▌ CONTACT PAGE ▌▌▌ -->
  <x-public.contact :contactInfo="$contactInfo" :socials="$socials" :whatsappNumber="$whatsappNumber" />

  <!-- Footer -->
  <x-public.footer :socials="$socials" />

  @include('partials.landingpage.gallery-lightbox')

  <!-- FLOATING ACTIONS (FAB cluster) -->
  <x-public.fab :whatsappNumber="$whatsappNumber" />

  @include('partials.landingpage.chatbot')
</div>
@endsection
