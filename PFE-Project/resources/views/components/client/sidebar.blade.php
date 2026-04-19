<!-- resources/views/components/client/sidebar.blade.php -->
<aside id="client-sidebar"
       class="fixed top-0 left-0 h-screen w-64 bg-white z-50 flex flex-col"
       style="border-right: 1px solid #E4E4E7; transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       @click.away="sidebarOpen = false">

    <!-- Logo Block -->
    <div class="p-6 border-b border-zinc-100">
        <div class="flex items-center gap-x-2">
            <div class="h-5 w-5 bg-zinc-950"></div>
            <span class="font-mono text-xs font-bold tracking-widest uppercase text-zinc-900">Coach_Portal</span>
        </div>
        <p class="font-mono text-[8px] text-cyan-600 uppercase tracking-[0.3em] mt-1">Pupil_Access_V3.0</p>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-0.5 overflow-y-auto">
        <a href="{{ route('client.dashboard') }}"
           class="flex items-center gap-x-3 px-3 py-2.5 font-mono text-[10px] font-bold uppercase tracking-widest transition-all
                  {{ request()->routeIs('client.dashboard')
                     ? 'bg-cyan-50 text-cyan-700 border-r-2 border-cyan-600'
                     : 'text-zinc-500 hover:bg-zinc-50 hover:text-zinc-900 border-r-2 border-transparent hover:border-cyan-600' }}">
            <i data-lucide="layout-dashboard" class="size-3.5 flex-shrink-0"></i>
            Dashboard
        </a>
        <a href="{{ route('client.evolution.index') }}"
           class="flex items-center gap-x-3 px-3 py-2.5 font-mono text-[10px] font-bold uppercase tracking-widest transition-all
                  {{ request()->routeIs('client.evolution.*')
                     ? 'bg-cyan-50 text-cyan-700 border-r-2 border-cyan-600'
                     : 'text-zinc-500 hover:bg-zinc-50 hover:text-zinc-900 border-r-2 border-transparent hover:border-cyan-600' }}">
            <i data-lucide="activity" class="size-3.5 flex-shrink-0"></i>
            Evolution
        </a>
        <a href="{{ route('client.programs.index') }}"
           class="flex items-center gap-x-3 px-3 py-2.5 font-mono text-[10px] font-bold uppercase tracking-widest transition-all
                  {{ request()->routeIs('client.programs.*')
                     ? 'bg-cyan-50 text-cyan-700 border-r-2 border-cyan-600'
                     : 'text-zinc-500 hover:bg-zinc-50 hover:text-zinc-900 border-r-2 border-transparent hover:border-cyan-600' }}">
            <i data-lucide="zap" class="size-3.5 flex-shrink-0"></i>
            My_Programs
        </a>
        <a href="{{ route('client.history.index') }}"
           class="flex items-center gap-x-3 px-3 py-2.5 font-mono text-[10px] font-bold uppercase tracking-widest transition-all
                  {{ request()->routeIs('client.history.*')
                     ? 'bg-cyan-50 text-cyan-700 border-r-2 border-cyan-600'
                     : 'text-zinc-500 hover:bg-zinc-50 hover:text-zinc-900 border-r-2 border-transparent hover:border-cyan-600' }}">
            <i data-lucide="archive" class="size-3.5 flex-shrink-0"></i>
            Program_History
        </a>
    </nav>

    <!-- Pupil Identity Footer -->
    <div class="p-4 border-t border-zinc-100 bg-zinc-50/50">
        <div class="flex items-center gap-x-3 mb-3">
            <div class="h-8 w-8 bg-cyan-600 flex items-center justify-center text-white font-mono text-[10px] font-bold flex-shrink-0">
                {{ strtoupper(substr(Auth::user()?->name ?? 'G', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="font-mono text-[10px] font-bold text-zinc-900 uppercase truncate">
                    {{ Auth::user()?->name ?? 'Guest_User' }}
                </p>
                <p class="font-mono text-[8px] text-cyan-600 uppercase tracking-[0.2em]">_Active_Pupil</p>
            </div>
        </div>
        <a href="#" class="flex items-center gap-x-2 font-mono text-[8px] font-bold text-red-500 uppercase tracking-widest hover:text-red-600 transition-colors">
            <i data-lucide="log-out" class="size-3"></i>
            Terminate_Session
        </a>
    </div>
</aside>
