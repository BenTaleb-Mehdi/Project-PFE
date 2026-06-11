<!-- Discovery Bar -->
<div class="ag-card p-4 bg-white mb-8 border border-zinc-200 flex flex-col md:flex-row gap-4 items-center">
    <!-- Search -->
    <div class="relative flex-1 w-full">
        <input type="text" 
               x-model="searchQuery"
               placeholder="Search Protocols (Name)..." 
               class="w-full bg-zinc-50 border border-zinc-200 px-10 py-2.5 text-[10px] font-mono uppercase tracking-widest focus:outline-none focus:border-cyan-600 transition-colors">
        <div class="absolute left-3.5 top-3 text-zinc-400">
            <i data-lucide="search" class="size-3.5"></i>
        </div>
    </div>

    <!-- Filter Status -->
    <div class="relative w-full md:w-64" x-data="{ filterOpen: false }">
        <button @click="filterOpen = !filterOpen" @click.away="filterOpen = false"
                class="w-full flex justify-between items-center bg-zinc-50 border border-zinc-200 px-4 py-2.5 text-[10px] font-mono uppercase tracking-widest text-zinc-500 hover:text-zinc-900 transition-colors">
            <span x-text="filterStatus.replace('_', ' ')"></span>
            <i data-lucide="chevron-down" class="size-3 transition-transform" :class="filterOpen ? 'rotate-180' : ''"></i>
        </button>
        <div x-show="filterOpen" x-cloak
             class="absolute top-full left-0 right-0 z-[100] bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] mt-0.5">
            <div class="py-1">
                <template x-for="opt in ['ALL_STATUSES', 'Active', 'Archive', 'Completed']">
                    <button @click="filterStatus = opt; filterOpen = false" 
                            class="w-full text-left px-4 py-2 text-[10px] font-mono uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 transition-all"
                            :class="filterStatus === opt ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500'">
                        <span x-text="opt.replace('_', ' ')"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>
