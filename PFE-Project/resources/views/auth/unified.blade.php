@extends('layouts.auth')

@section('title', 'Login Portal')

@section('content')
<style>
    /* Smooth panel transition helpers */
    .panel-enter  { opacity: 1;  transform: translateY(0);   pointer-events: auto;   transition: opacity .45s cubic-bezier(.4,0,.2,1), transform .45s cubic-bezier(.4,0,.2,1); }
</style>

<div class="min-h-screen flex flex-col md:flex-row"
     x-data="{
         loading: false,
         remember: {{ old('remember') ? 'true' : 'false' }}
     }">

    {{-- ================================================================
         LEFT PANEL — Dark Brand Panel
    ================================================================= --}}
    <div class="md:w-5/12 bg-zinc-950 flex flex-col justify-between p-10 md:p-14 text-white relative overflow-hidden select-none">

        {{-- Decorative grid --}}
        <div class="absolute inset-0 opacity-[0.06] pointer-events-none">
            <div class="absolute top-1/4 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute top-1/2 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute top-3/4 left-0 w-full h-px bg-cyan-400"></div>
            <div class="absolute left-1/3 top-0 h-full w-px bg-cyan-400"></div>
            <div class="absolute left-2/3 top-0 h-full w-px bg-cyan-400"></div>
        </div>

        {{-- Top: Logo (always visible) --}}
        <div class="relative z-10">
            <div class="inline-flex items-center gap-3 bg-white/5 border border-white/10 px-4 py-3 mb-14">
                <img src="{{ asset('images/logo.png') }}" alt="Coach Logo" class="h-8 w-auto object-contain">
            </div>

            {{-- Heading container --}}
            <div class="relative">
                <div class="panel-enter">
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight uppercase leading-tight max-w-xs text-white">
                        Optimize Your<br>
                        <span class="text-cyan-400">Performance</span><br>
                        Matrix
                    </h1>
                    <p class="mt-5 text-zinc-500 text-xs font-mono uppercase tracking-widest">
                        Protocol: User Authentication v3.0
                    </p>
                    <div class="mt-10 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-5 bg-cyan-600"></div>
                            <p class="text-xs text-zinc-400">Real-time performance tracking</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-5 bg-cyan-600"></div>
                            <p class="text-xs text-zinc-400">Elite coaching protocols</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-5 bg-cyan-600"></div>
                            <p class="text-xs text-zinc-400">Precision nutrition engine</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom: status --}}
        <div class="relative z-10 border-t border-zinc-800 pt-6">
            <div>
                <p class="text-[10px] text-zinc-600 font-mono uppercase tracking-[0.2em]">Build // 00X-ALPHA-26</p>
                <p class="text-[10px] text-zinc-600 font-mono uppercase tracking-[0.2em] mt-1">Status // System Ready</p>
            </div>
        </div>
    </div>

    {{-- ================================================================
         RIGHT PANEL — Login Form
    ================================================================= --}}
    <div class="md:w-7/12 relative bg-white overflow-hidden flex items-center justify-center p-8 md:p-14" style="min-height: 100vh;">
        <div class="w-full max-w-md">
            <div class="mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Welcome back</h2>
                <p class="text-sm text-zinc-400 mt-1">Sign in to access your coaching dashboard</p>
            </div>

            @if($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 text-xs text-red-600 space-y-1">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="space-y-5" method="POST" action="{{ route('login') }}" @submit="loading = true">
                @csrf
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-widest">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="you@example.com"
                           class="w-full h-11 bg-white border border-zinc-200 px-4 text-sm text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-all">
                </div>
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-widest">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[11px] text-zinc-400 hover:text-cyan-600 transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full h-11 bg-white border border-zinc-200 px-4 text-sm text-zinc-900 focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-all">
                </div>
                <div class="flex items-center gap-3 py-1 cursor-pointer select-none" @click="remember = !remember">
                    <input type="checkbox" name="remember" x-model="remember" class="hidden">
                    <div class="h-4 w-4 border flex items-center justify-center transition-all"
                         :class="remember ? 'bg-cyan-600 border-cyan-600' : 'bg-white border-zinc-300'">
                        <i x-show="remember" data-lucide="check" class="h-3 w-3 text-white"></i>
                    </div>
                    <span class="text-sm text-zinc-500">Keep me signed in</span>
                </div>
                <button type="submit"
                        class="w-full h-11 bg-zinc-950 text-white text-xs font-bold uppercase tracking-widest hover:bg-zinc-800 transition-all flex items-center justify-center gap-2 mt-2"
                        :disabled="loading">
                    <span x-show="!loading">Sign In</span>
                    <template x-if="loading">
                        <div class="flex items-center gap-2">
                            <div class="h-4 w-4 border-2 border-white/20 border-t-white animate-spin"></div>
                            <span>Signing in...</span>
                        </div>
                    </template>
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
