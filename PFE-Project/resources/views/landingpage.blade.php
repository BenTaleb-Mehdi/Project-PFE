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

@endsection