@extends('layouts.app')

@php
    $noMenu = true;
@endphp

@section('content')
<div class="fixed inset-0 bg-zinc-950 flex flex-col font-mono selection:bg-cyan-100 selection:text-cyan-900 overflow-hidden">
    <!-- Decorative system lines (Background) -->
    <div class="absolute inset-0 opacity-10 pointer-events-none z-0">
        <div class="absolute top-1/4 left-0 w-full h-[1px] bg-cyan-500"></div>
        <div class="absolute top-1/2 left-0 w-full h-[1px] bg-cyan-500"></div>
        <div class="absolute top-3/4 left-0 w-full h-[1px] bg-cyan-500"></div>
        <div class="absolute left-1/4 top-0 h-full w-[1px] bg-cyan-500"></div>
        <div class="absolute left-1/2 top-0 h-full w-[1px] bg-cyan-500"></div>
        <div class="absolute left-3/4 top-0 h-full w-[1px] bg-cyan-500"></div>
    </div>

    <main class="flex-1 flex flex-col justify-center px-8 relative z-10 w-full max-w-md mx-auto">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('icon.png') }}" alt="Logo" class="h-16 w-auto object-contain drop-shadow-xl bg-white rounded-full">
            </div>
            <h1 class="text-white text-2xl font-bold tracking-tight uppercase mb-2">My Coach</h1>
            <p class="text-zinc-500 text-[10px] uppercase tracking-[0.2em]">Welcome Back</p>
        </div>

        <!-- Auth Form Container -->
        <div class="bg-white p-8 border border-zinc-200 shadow-2xl rounded-2xl" x-data="{ loading: false }">
            <div class="space-y-6">
                <!-- User Identifier -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">User ID / Email</label>
                    <div class="relative">
                        <x-lucide-user class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-zinc-400" />
                        <input type="text" placeholder="email.exmple@gmail.com" 
                               class="w-full h-14 bg-zinc-50 border border-zinc-100 pl-12 pr-4 text-sm font-sans text-zinc-900 focus:outline-none focus:border-cyan-600 focus:bg-white transition-all rounded-xl">
                    </div>
                </div>

                <!-- Access Key -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Security Key</label>
                        <a href="#" class="text-[9px] text-zinc-400 hover:text-cyan-600 uppercase tracking-widest transition-colors">Reset?</a>
                    </div>
                    <div class="relative">
                        <x-lucide-lock class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-zinc-400" />
                        <input type="password" placeholder="••••••••" 
                               class="w-full h-14 bg-zinc-50 border border-zinc-100 pl-12 pr-4 text-sm font-sans text-zinc-900 focus:outline-none focus:border-cyan-600 focus:bg-white transition-all rounded-xl">
                    </div>
                </div>

                <!-- Action Button -->
                <a href="/client/1/dashboard" 
                   @click="loading = true"
                   class="w-full h-14 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-black transition-all flex items-center justify-center gap-3 active:scale-[0.98] rounded-xl shadow-xl shadow-zinc-950/20">
                    <span x-show="!loading">Login</span>
                    <div x-show="loading" class="h-4 w-4 border-2 border-white/20 border-t-white animate-spin rounded-full"></div>
                    <x-lucide-chevron-right x-show="!loading" class="h-4 w-4" />
                </a>

                
            </div>
        </div>

        <!-- System Status -->
        <div class="mt-12 text-center opacity-40">
            <p class="text-[9px] text-zinc-400 uppercase tracking-[0.2em] mb-1">Status // Ready</p>
            <p class="text-[9px] text-zinc-500 uppercase tracking-[0.2em]">Build // SOL-MOBILE-2.6</p>
        </div>
    </main>
</div>
@endsection
