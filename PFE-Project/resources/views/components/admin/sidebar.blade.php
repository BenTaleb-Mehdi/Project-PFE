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
        <div class="flex items-center mb-10">
            <x-logo />
        </div>

        <nav class="hs-accordion-group p-0 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
            <ul class="space-y-1.5">
                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-xs font-bold {{ request()->routeIs('coach.dashboard') ? 'text-cyan-700 uppercase tracking-widest' : 'text-zinc-500 uppercase tracking-widest hover:bg-zinc-50 focus:outline-none' }}" 
                       href="{{ route('coach.dashboard') }}">
                        <i data-lucide="layout-dashboard" class="size-4"></i>
                        Dashboard
                    </a>
                </li>

                <li x-data="{ open: {{ request()->is('coach/nutrition*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold uppercase tracking-widest transition-all focus:outline-none {{ request()->is('coach/nutrition*') ? 'bg-cyan-50 text-cyan-700 border-l-2 border-cyan-600' : 'text-zinc-500 hover:bg-zinc-50 border-l-2 border-transparent hover:border-cyan-600' }}">
                        <i data-lucide="utensils" class="size-3.5"></i>
                        Nutrition Engine
                        <i data-lucide="chevron-down" class="ms-auto size-3 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-cloak class="w-full overflow-hidden">
                        <ul class="pt-1 ps-4 space-y-1">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('coach.nutrition.categories') ? 'text-cyan-600 border-l-2 border-cyan-600' : 'text-zinc-500 hover:text-cyan-600 border-l-2 border-transparent hover:border-cyan-600' }} uppercase tracking-widest transition-all font-sans" 
                                   href="{{ route('coach.nutrition.categories') }}">
                                    <i data-lucide="layers" class="size-3.5"></i>
                                    Categories
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('coach.nutrition.index') ? 'text-cyan-600 border-l-2 border-cyan-600' : 'text-zinc-500 hover:text-cyan-600 border-l-2 border-transparent hover:border-cyan-600' }} uppercase tracking-widest transition-all font-sans" 
                                   href="{{ route('coach.nutrition.index') }}">
                                    <i data-lucide="apple" class="size-3.5"></i>
                                    Nutrition
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('coach.clients.*') ? 'text-cyan-700 border-l-2 border-cyan-600 bg-cyan-50' : 'text-zinc-500 uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-cyan-600 transition-all font-sans' }}" 
                       href="{{ route('coach.clients.index') }}">
                        <i data-lucide="users" class="size-3.5"></i>
                        Clients
                    </a>
                </li>

                @role('admin')
                <li x-data="{ open: {{ request()->is('coach/team*') || request()->is('coach/finance*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-cyan-600 transition-all focus:outline-none">
                        <i data-lucide="shield" class="size-3.5"></i>
                        Strategic Control
                        <i data-lucide="chevron-down" class="ms-auto size-3 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-cloak class="w-full overflow-hidden">
                        <ul class="pt-1 ps-4 space-y-1">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('coach.team') ? 'text-cyan-600 border-l-2 border-cyan-600' : 'text-zinc-500 hover:text-cyan-600 border-l-2 border-transparent hover:border-cyan-600' }} uppercase tracking-widest transition-all font-sans" 
                                   href="{{ route('coach.team') }}">
                                    <i data-lucide="user-cog" class="size-3.5"></i>
                                    Team
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('coach.finance') ? 'text-cyan-600 border-l-2 border-cyan-600' : 'text-zinc-500 hover:text-cyan-600 border-l-2 border-transparent hover:border-cyan-600' }} uppercase tracking-widest transition-all font-sans" 
                                   href="{{ route('coach.finance') }}">
                                    <i data-lucide="circle-dollar-sign" class="size-3.5"></i>
                                    Finance
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endrole

                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('coach.chat.*') ? 'text-cyan-700 border-l-2 border-cyan-600 bg-cyan-50' : 'text-zinc-500 uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-cyan-600 transition-all font-sans' }}" 
                       href="{{ route('coach.chat.index') }}">
                        <i data-lucide="message-square" class="size-3.5"></i>
                        Messages
                    </a>
                </li>

                <li class="pt-4 border-t border-zinc-100 mt-4">
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-[10px] font-bold {{ request()->routeIs('profile.settings') ? 'text-cyan-700 border-l-2 border-cyan-600 bg-cyan-50' : 'text-zinc-500 uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-cyan-600 transition-all font-sans' }}" 
                       href="{{ route('profile.settings') }}">
                        <i data-lucide="settings" class="size-3.5"></i>
                        Settings
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="absolute bottom-0 w-full p-6 bg-zinc-50/50 border-t border-zinc-200 font-sans">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="h-8 w-8 bg-cyan-600 border border-cyan-700 flex items-center justify-center text-white font-bold text-xs font-mono">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <p class="text-[10px] font-bold text-zinc-950 uppercase tracking-widest">{{ auth()->user()->name ?? 'Coach Admin' }}</p>
                    <p class="text-[8px] text-cyan-700 uppercase font-mono">Master System</p>
                </div>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="flex items-center justify-center gap-x-2 py-3 w-full bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-widest border border-red-100 hover:bg-red-600 hover:text-white transition-all shadow-[2px_2px_0px_0px_rgba(220,38,38,0.1)] group">
            <i data-lucide="log-out" class="size-3.5 group-hover:rotate-12 transition-transform"></i>
            Terminate Session
        </a>
    </div>
</aside>
