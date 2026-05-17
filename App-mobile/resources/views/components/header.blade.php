<!-- Mobile Top App Bar -->
<header class="absolute top-0 left-0 right-0 bg-white z-40 border-b border-zinc-200 shrink-0" x-data="{ showLogoutConfirm: false }">
    <div class="flex items-center justify-between px-5 h-16">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('icon.png') }}" alt="App Logo" class="h-8 w-auto object-contain">
        </div>
        
        <div class="flex items-center space-x-2">
            @if(request()->is('client/*/dashboard'))
                <button class="h-8 w-8 flex items-center justify-center text-zinc-400 relative hover:text-zinc-600 transition-colors">
                    @if(session('has_new_program'))
                        <div class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white z-10 animate-pulse"></div>
                    @endif
                    <x-lucide-bell class="h-5 w-5" />
                </button>
            @else
                <button class="h-8 w-8 flex items-center justify-center text-zinc-400 hover:text-zinc-900 transition-colors">
                    <x-lucide-settings class="h-5 w-5" />
                </button>
            @endif

            <button @click="showLogoutConfirm = true" class="h-8 w-8 flex items-center justify-center text-red-500/70 hover:text-red-600 transition-colors">
                <x-lucide-log-out class="h-5 w-5" />
            </button>
        </div>
    </div>

    <!-- Logout Confirmation Sheet (UX Enhancement) -->
    <template x-teleport="body">
        <div x-show="showLogoutConfirm" 
             class="fixed inset-0 z-[100] flex items-end justify-center"
             x-cloak>
            
            <!-- Backdrop -->
            <div x-show="showLogoutConfirm"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showLogoutConfirm = false"
                 class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

            <!-- Sheet Content -->
            <div x-show="showLogoutConfirm"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="translate-y-full"
                 class="relative w-full max-w-[430px] bg-white rounded-t-[2rem] p-8 shadow-2xl z-10 font-sans">
                
                <div class="w-12 h-1.5 bg-zinc-200 rounded-full mx-auto mb-8"></div>
                
                <div class="text-center space-y-4 mb-10">
                    <div class="h-16 w-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <x-lucide-log-out class="h-8 w-8" />
                    </div>
                    <h3 class="text-xl font-bold text-zinc-950 uppercase tracking-tight">Confirm Logout</h3>
                    <p class="text-sm text-zinc-500 max-w-[240px] mx-auto">Are you sure you want to exit your current session?</p>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('logout') }}" 
                       class="w-full h-14 bg-red-500 text-white font-bold rounded-xl flex items-center justify-center uppercase tracking-widest text-xs hover:bg-red-600 transition-all active:scale-[0.98]">
                        Confirm & Logout
                    </a>
                    <button @click="showLogoutConfirm = false"
                            class="w-full h-14 bg-zinc-100 text-zinc-500 font-bold rounded-xl flex items-center justify-center uppercase tracking-widest text-xs hover:bg-zinc-200 transition-all active:scale-[0.98]">
                        Stay Logged In
                    </button>
                </div>
                
                <div class="mt-8 text-center">
                    <p class="text-[9px] text-zinc-300 font-mono uppercase tracking-[0.2em]">Build // 00X-MOBILE-26</p>
                </div>
            </div>
        </div>
    </template>
</header>
