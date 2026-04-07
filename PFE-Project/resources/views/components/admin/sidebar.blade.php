<!-- resources/views/components/admin/sidebar.blade.php -->
<aside id="application-sidebar" 
       :class="isSidebarOpen || isLargeScreen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-zinc-200 transition-all duration-300 transform lg:translate-x-0 font-sans"
       @click.away="isSidebarOpen = false">
    
    <!-- Mobile Close Trigger -->
    <div class="lg:hidden absolute top-4 right-4 z-50">
        <button type="button" 
                @click.stop="isSidebarOpen = false"
                class="h-10 w-10 flex items-center justify-center bg-white border border-zinc-200 text-zinc-500 hover:bg-zinc-50 transition-all font-mono">
            <span class="sr-only">Close Sidebar</span>
            <i data-lucide="x" class="size-4"></i>
        </button>
    </div>

    <div class="p-6">
        <div class="flex items-center mb-12">
            <img src="{{ asset('resources/images/logo.png') }}" alt="Coach Logo" class="h-14 w-auto object-contain">
        </div>

        <nav class="p-0 w-full flex flex-col flex-wrap">
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('coach.dashboard') ? 'bg-cyan-50 text-cyan-700 border-l-2 border-cyan-600' : 'text-zinc-500 hover:bg-zinc-50 border-l-2 border-transparent hover:border-cyan-600' }} text-[10px] font-bold uppercase tracking-widest transition-all focus:outline-none" 
                       href="{{ route('coach.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li x-data="{ open: {{ request()->is('coach/nutrition*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-cyan-600 transition-all focus:outline-none">
                        Nutrition_Engine
                        <i data-lucide="chevron-down" class="ms-auto size-3 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-cloak class="w-full overflow-hidden">
                        <ul class="pt-1 ps-4 space-y-1">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('coach.nutrition.categories') ? 'text-cyan-600 border-l-2 border-cyan-600' : 'text-zinc-500 hover:text-cyan-600 border-l-2 border-transparent hover:border-cyan-600' }} uppercase tracking-widest transition-all font-sans" 
                                   href="{{ route('coach.nutrition.categories') }}">
                                    Categories
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('coach.nutrition.*') ? 'text-cyan-600 border-l-2 border-cyan-600' : 'text-zinc-500 hover:text-cyan-600 border-l-2 border-transparent hover:border-cyan-600' }} uppercase tracking-widest transition-all font-sans" 
                                   href="{{ route('coach.nutrition.index') }}">
                                    Nutrition
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('coach.clients.*') ? 'bg-cyan-50 text-cyan-700 border-l-2 border-cyan-600' : 'text-zinc-500 hover:bg-zinc-50 border-l-2 border-transparent hover:border-cyan-600' }} text-[10px] font-bold uppercase tracking-widest transition-all font-sans" 
                       href="{{ route('coach.clients.index') }}">
                        Clients
                    </a>
                </li>

                <li x-data="{ open: {{ request()->is('coach/team*') || request()->is('coach/finance*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-cyan-600 transition-all focus:outline-none">
                        Strategic_Control
                        <i data-lucide="chevron-down" class="ms-auto size-3 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-cloak class="w-full overflow-hidden">
                        <ul class="pt-1 ps-4 space-y-1">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('coach.team') ? 'text-cyan-600 border-l-2 border-cyan-600' : 'text-zinc-500 hover:text-cyan-600 border-l-2 border-transparent hover:border-cyan-600' }} uppercase tracking-widest transition-all font-sans" 
                                   href="{{ route('coach.team') }}">
                                    Team
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('coach.finance') ? 'text-cyan-600 border-l-2 border-cyan-600' : 'text-zinc-500 hover:text-cyan-600 border-l-2 border-transparent hover:border-cyan-600' }} uppercase tracking-widest transition-all font-sans" 
                                   href="{{ route('coach.finance') }}">
                                    Finance
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>

    <div class="absolute bottom-0 w-full p-6 bg-zinc-50/50 border-t border-zinc-200">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="h-8 w-8 bg-white border border-zinc-200 flex items-center justify-center text-cyan-700 font-bold text-xs font-mono">A</div>
                <div>
                    <p class="text-[10px] font-bold text-zinc-900 uppercase font-sans">Achraf_Perf</p>
                    <p class="text-[8px] text-cyan-700 uppercase font-mono">Master_Admin</p>
                </div>
            </div>
        </div>
        <form method="POST" action="">
            @csrf
            <button type="submit" class="w-full flex items-center gap-x-2 py-2 text-[10px] font-bold text-red-600 uppercase tracking-widest hover:text-red-700 transition-colors font-sans">
                <i data-lucide="log-out" class="size-3"></i>
                Logout_Session
            </button>
        </form>
    </div>
</aside>
