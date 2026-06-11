@extends('layouts.client')

@section('title', 'Coaching Communication System')

@section('content')
@include('client.chat.partials.page-header')

<div x-data="chatSystem()" class="h-[calc(100vh-240px)] flex bg-white border border-zinc-200 overflow-hidden shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] relative" x-cloak>
    
    <!-- Mobile Contact Toggle -->
    <button @click="showContacts = !showContacts" class="lg:hidden absolute top-2 left-2 z-50 h-9 w-9 bg-white border border-zinc-200 flex items-center justify-center text-zinc-600 hover:bg-zinc-50 shadow-sm">
        <i data-lucide="message-square" class="size-4"></i>
    </button>

    <!-- Mobile Overlay Backdrop -->
    <div x-show="showContacts" @click="showContacts = false" x-cloak x-transition.opacity class="lg:hidden fixed inset-0 bg-zinc-950/20 backdrop-blur-sm z-30"></div>

    @include('client.chat.partials.contact-sidebar')
    @include('client.chat.partials.chat-window')
</div>

@include('client.chat.partials.chat-script')
@endsection
