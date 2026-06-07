@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row-reverse">

    {{-- ====================================================
         RIGHT PANEL — Brand / Identity (mirrored)
    ===================================================== --}}
    <div class="md:w-5/12 bg-zinc-950 flex flex-col justify-between p-6 sm:p-10 md:p-14 text-white relative overflow-hidden">

        {{-- Decorative grid lines --}}
        <div class="absolute inset-0 opacity-[0.06] pointer-events-none">
            <div class="absolute top-1/4 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute top-1/2 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute top-3/4 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute right-1/3 top-0 h-full w-px bg-cyan-400"></div>
            <div class="absolute right-2/3 top-0 h-full w-px bg-cyan-400"></div>
        </div>

        {{-- Top: Logo + Brand --}}
        <div class="relative z-10">
            {{-- Logo in a styled container --}}
            <div class="inline-flex items-center gap-3 bg-white/5 border border-white/10 px-4 py-3 mb-14">
                <img src="{{ asset('images/logo.png') }}" alt="Coach Logo" class="h-8 w-auto object-contain">
            </div>

            {{-- Main heading --}}
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight uppercase leading-tight max-w-xs text-white">
                Initialize Your<br>
                <span class="text-cyan-400">Metabolic</span><br>
                Profile
            </h1>
            <p class="mt-5 text-zinc-500 text-xs font-mono uppercase tracking-widest">
                Protocol: Account Provisioning v3.0
            </p>
        </div>

        {{-- Bottom: System status --}}
        <div class="relative z-10 border-t border-zinc-800 pt-6 text-right">
            <p class="text-[10px] text-zinc-600 font-mono uppercase tracking-[0.2em]">Build // 00X-ALPHA-26</p>
            <p class="text-[10px] text-zinc-600 font-mono uppercase tracking-[0.2em] mt-1">Status // System Ready</p>
        </div>
    </div>

    {{-- ====================================================
         LEFT PANEL — Registration Form
    ===================================================== --}}
    <div class="md:w-7/12 flex items-center justify-center p-8 md:p-14 bg-white"
         x-data="{ terms: false, loading: false }">

        <div class="w-full max-w-md">

            {{-- Header --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Create your account</h2>
                <p class="text-sm text-zinc-400 mt-1 font-sans">Start your elite performance journey today</p>
            </div>

            <form class="space-y-5" method="POST" action="{{ route('register') }}" @submit="loading = true">
                @csrf

                {{-- Full Name --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-widest">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           placeholder="John Doe"
                           class="w-full h-11 bg-white border @error('name') border-red-400 @else border-zinc-200 @enderror px-4 text-sm text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-all">
                    @error('name')
                        <p class="text-[11px] text-red-500 font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-widest">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="you@example.com"
                           class="w-full h-11 bg-white border @error('email') border-red-400 @else border-zinc-200 @enderror px-4 text-sm text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-all">
                    @error('email')
                        <p class="text-[11px] text-red-500 font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Group --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-widest">Password</label>
                        <input type="password" name="password" required placeholder="••••••••"
                               class="w-full h-11 bg-white border @error('password') border-red-400 @else border-zinc-200 @enderror px-4 text-sm text-zinc-900 focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-all">
                        @error('password')
                            <p class="text-[11px] text-red-500 font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-widest">Confirm</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••"
                               class="w-full h-11 bg-white border border-zinc-200 px-4 text-sm text-zinc-900 focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-all">
                    </div>
                </div>

                {{-- Terms --}}
                <div class="flex items-center gap-3 py-1 cursor-pointer select-none" @click="terms = !terms">
                    <input type="checkbox" name="terms" x-model="terms" class="hidden">
                    <div class="h-4 w-4 border flex items-center justify-center transition-all flex-shrink-0"
                         :class="terms ? 'bg-cyan-600 border-cyan-600' : 'bg-white border-zinc-300'">
                        <i x-show="terms" data-lucide="check" class="h-3 w-3 text-white"></i>
                    </div>
                    <span class="text-sm text-zinc-500">I accept the terms and conditions</span>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full h-11 bg-zinc-950 text-white text-xs font-bold uppercase tracking-widest hover:bg-zinc-800 transition-all flex items-center justify-center gap-2 mt-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="loading || !terms">
                    <div x-show="!loading" class="flex items-center gap-2">
                        <span>Create Account</span>
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </div>
                    <template x-if="loading">
                        <div class="flex items-center gap-2">
                            <div class="h-4 w-4 border-2 border-white/20 border-t-white animate-spin"></div>
                            <span>Creating account...</span>
                        </div>
                    </template>
                </button>
            </form>

            {{-- Footer link --}}
            <div class="mt-8 pt-6 border-t border-zinc-100 flex items-center justify-between gap-4">
                <p class="text-sm text-zinc-400">Already have an account?</p>
                <a href="{{ route('login') }}"
                   class="px-4 py-2 border border-zinc-200 text-xs font-semibold text-zinc-700 uppercase tracking-widest hover:border-cyan-600 hover:text-cyan-600 transition-all">
                    Sign In
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
