@extends('layouts.auth')

@section('title', 'Recovery Protocol')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row"
     x-data="{ loading: false }">

    {{-- LEFT PANEL — Dark Brand Panel --}}
    <div class="md:w-5/12 bg-zinc-950 flex flex-col justify-between p-10 md:p-14 text-white relative overflow-hidden select-none">
        {{-- Decorative grid --}}
        <div class="absolute inset-0 opacity-[0.06] pointer-events-none">
            <div class="absolute top-1/4 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute top-1/2 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute top-3/4 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute left-1/3 top-0 h-full w-px bg-cyan-400"></div>
            <div class="absolute left-2/3 top-0 h-full w-px bg-cyan-400"></div>
        </div>

        <div class="relative z-10">
            <div class="inline-flex items-center gap-3 bg-white/5 border border-white/10 px-4 py-3 mb-14">
                <img src="{{ asset('images/logo.png') }}" alt="Coach Logo" class="h-8 w-auto object-contain">
            </div>

            <div class="relative">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight uppercase leading-tight max-w-xs text-white">
                    Access<br>
                    <span class="text-cyan-400">Recovery</span><br>
                    Sequence
                </h1>
                <p class="mt-5 text-zinc-500 text-xs font-mono uppercase tracking-widest">
                    Protocol: Password Reset v3.0
                </p>
                <div class="mt-10 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 bg-cyan-600"></div>
                        <p class="text-xs text-zinc-400">Identity verification required</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 bg-cyan-600"></div>
                        <p class="text-xs text-zinc-400">Secure link dispatch system</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative z-10 border-t border-zinc-800 pt-6">
            <p class="text-[10px] text-zinc-600 font-mono uppercase tracking-[0.2em]">Status // Waiting for Input</p>
        </div>
    </div>

    {{-- RIGHT PANEL — Request Form --}}
    <div class="md:w-7/12 relative bg-white flex items-center justify-center p-8 md:p-14" style="min-height: 100vh;">
        <div class="w-full max-w-md">
            <div class="mb-8">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-400 hover:text-cyan-600 transition-colors mb-6">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Back to Sign In
                </a>
                <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Forgot password?</h2>
                <p class="text-sm text-zinc-400 mt-1">Enter your email and we'll send you a recovery link</p>
            </div>

            @if (session('status'))
                <div class="mb-5 p-4 bg-cyan-50 border border-cyan-200 text-xs text-cyan-700">
                    {{ session('status') }}
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('password.email') }}" @submit="loading = true">
                @csrf
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-widest">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="you@example.com"
                           class="w-full h-11 bg-white border border-zinc-200 px-4 text-sm text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-all">
                    @error('email')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full h-11 bg-zinc-950 text-white text-xs font-bold uppercase tracking-widest hover:bg-zinc-800 transition-all flex items-center justify-center gap-2"
                        :disabled="loading">
                    <span x-show="!loading">Send Recovery Link</span>
                    <template x-if="loading">
                        <div class="flex items-center gap-2">
                            <div class="h-4 w-4 border-2 border-white/20 border-t-white animate-spin"></div>
                            <span>Processing...</span>
                        </div>
                    </template>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
