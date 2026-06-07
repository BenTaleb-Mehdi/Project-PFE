@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">

    {{-- ====================================================
         LEFT PANEL — Brand / Identity
    ===================================================== --}}
    <div class="md:w-5/12 bg-zinc-950 flex flex-col justify-between p-6 sm:p-10 md:p-14 text-white relative overflow-hidden">

        {{-- Decorative grid lines --}}
        <div class="absolute inset-0 opacity-[0.06] pointer-events-none">
            <div class="absolute top-1/4 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute top-1/2 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute top-3/4 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute left-1/3 top-0 h-full w-px bg-cyan-400"></div>
            <div class="absolute left-2/3 top-0 h-full w-px bg-cyan-400"></div>
        </div>

        {{-- Top: Logo + Brand --}}
        <div class="relative z-10">
            {{-- Logo in a styled container --}}
            <div class="inline-flex items-center gap-3 bg-white/5 border border-white/10 px-4 py-3 mb-14">
                <img src="{{ asset('images/logo.png') }}" alt="Coach Logo" class="h-8 w-auto object-contain">
            </div>

            {{-- Main heading --}}
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight uppercase leading-tight max-w-xs text-white">
                Optimize Your<br>
                <span class="text-cyan-400">Performance</span><br>
                Matrix
            </h1>
            <p class="mt-5 text-zinc-500 text-xs font-mono uppercase tracking-widest">
                Protocol: User Authentication v3.0
            </p>
        </div>

        {{-- Bottom: System status --}}
        <div class="relative z-10 border-t border-zinc-800 pt-6">
            <p class="text-[10px] text-zinc-600 font-mono uppercase tracking-[0.2em]">Build // 00X-ALPHA-26</p>
            <p class="text-[10px] text-zinc-600 font-mono uppercase tracking-[0.2em] mt-1">Status // System Ready</p>
        </div>
    </div>

    {{-- ====================================================
         RIGHT PANEL — Auth Form
    ===================================================== --}}
    <div class="md:w-7/12 flex items-center justify-center p-8 md:p-14 bg-white"
         x-data="{ remember: {{ old('remember') ? 'true' : 'false' }}, loading: false }">

        <div class="w-full max-w-md">

            {{-- Header --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Welcome back</h2>
                <p class="text-sm text-zinc-400 mt-1 font-sans">Sign in to access your coaching dashboard</p>
            </div>

            <form class="space-y-5" method="POST" action="{{ route('login') }}" @submit="loading = true">
                @csrf

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-widest">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="you@example.com"
                           class="w-full h-11 bg-white border @error('email') border-red-400 @else border-zinc-200 @enderror px-4 text-sm text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-all">
                    @error('email')
                        <p class="text-[11px] text-red-500 font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-widest">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-[11px] text-zinc-400 hover:text-cyan-600 transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full h-11 bg-white border @error('password') border-red-400 @else border-zinc-200 @enderror px-4 text-sm text-zinc-900 focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-all">
                    @error('password')
                        <p class="text-[11px] text-red-500 font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center gap-3 py-1 cursor-pointer select-none" @click="remember = !remember">
                    <input type="checkbox" name="remember" x-model="remember" class="hidden">
                    <div class="h-4 w-4 border flex items-center justify-center transition-all"
                         :class="remember ? 'bg-cyan-600 border-cyan-600' : 'bg-white border-zinc-300'">
                        <i x-show="remember" data-lucide="check" class="h-3 w-3 text-white"></i>
                    </div>
                    <span class="text-sm text-zinc-500">Keep me signed in</span>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full h-11 bg-zinc-950 text-white text-xs font-bold uppercase tracking-widest hover:bg-zinc-800 transition-all flex items-center justify-center gap-2 mt-2"
                        :disabled="loading">
                    <div x-show="!loading" class="flex items-center gap-2">
                        <span>Sign In</span>
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </div>
                    <template x-if="loading">
                        <div class="flex items-center gap-2">
                            <div class="h-4 w-4 border-2 border-white/20 border-t-white animate-spin"></div>
                            <span>Signing in...</span>
                        </div>
                    </template>
                </button>
            </form>

            {{-- Footer link --}}
            <div class="mt-8 pt-6 border-t border-zinc-100 flex items-center justify-between gap-4">
                <p class="text-sm text-zinc-400">Don't have an account?</p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 border border-zinc-200 text-xs font-semibold text-zinc-700 uppercase tracking-widest hover:border-cyan-600 hover:text-cyan-600 transition-all">
                        Create Account
                    </a>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
