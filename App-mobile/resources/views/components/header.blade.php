<!-- Mobile Top App Bar -->
<header class="absolute top-0 left-0 right-0 bg-white z-40 border-b border-zinc-200 shrink-0">
    <div class="flex items-center justify-between px-5 h-16">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('icon.png') }}" alt="App Logo" class="h-8 w-auto object-contain">
        </div>
        
        @if(request()->is('client/*/dashboard'))
            <button class="h-8 w-8 flex items-center justify-end text-zinc-400 relative hover:text-zinc-600 transition-colors">
                <div class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border border-white z-10"></div>
                <x-lucide-bell class="h-5 w-5" />
            </button>
        @else
            <button class="h-8 w-8 flex items-center justify-center text-zinc-400 hover:text-zinc-900 transition-colors">
                <x-lucide-settings class="h-5 w-5" />
            </button>
        @endif
    </div>
</header>
