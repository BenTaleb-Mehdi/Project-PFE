    <!-- Bottom Nav -->
    <nav class="absolute bottom-0 left-0 right-0 bg-white border-t border-zinc-200 z-40 shrink-0">
        <div class="flex justify-around items-center h-16 px-2">
           <a href="/client/{{ $clientId }}/dashboard" class="flex flex-col items-center justify-center w-full h-full text-zinc-400 hover:text-zinc-900 transition-colors relative group">
                <i data-lucide="layout-dashboard" class="h-[22px] w-[22px] sm:h-5 sm:w-5 mb-1 sm:mb-2"></i>
                <span class="text-[8px] font-mono uppercase tracking-widest font-bold">Dashboard</span>
            </a>

            <!-- Program Tab (Active) -->
            <a href="/client/{{ $clientId }}/program" class="flex flex-col items-center justify-center w-full h-full text-cyan-700 relative group">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-8 sm:w-10 h-0.5 sm:h-[3px] bg-cyan-600"></div>
                <i data-lucide="utensils" class="h-[22px] w-[22px] sm:h-5 sm:w-5 mb-1 sm:mb-2"></i>
                <span class="text-[8px] font-mono uppercase tracking-widest font-bold">Program</span>
            </a>
        </div>
    </nav>