<!-- Action Bar -->
<div class="mb-6 sm:mb-10 flex sm:justify-end font-mono">
    <button @click="openModal()"
            class="w-full sm:w-auto px-6 py-3 bg-zinc-950 text-white text-[10px] uppercase font-bold tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center justify-center gap-x-2">
        <i data-lucide="plus" class="size-3"></i>
        Onboard New Pupil
    </button>
</div>

<!-- Discovery Bar -->
<div class="ag-card p-4 bg-white mb-6 border border-zinc-200 flex flex-col md:flex-row gap-4 items-center">
    <!-- Search Input -->
    <form action="{{ route('coach.clients.index') }}" method="GET" class="relative flex-1 w-full" x-ref="searchForm">
        <input type="text" name="search"
               x-model="searchQuery"
               x-on:input.debounce.500ms="$refs.searchForm.submit()"
               placeholder="Search Pupils (Name, ID)..."
               class="w-full bg-zinc-50 border border-zinc-200 px-10 py-2.5 text-[10px] font-mono uppercase tracking-widest focus:outline-none focus:border-cyan-600 rounded-none transition-colors">
        <div class="absolute left-3.5 top-3 text-zinc-400">
            <i data-lucide="search" class="size-3.5"></i>
        </div>
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
    </form>

    <!-- Filter Dropdown: Status -->
    <div class="relative w-full md:w-64" x-data="{ open: false }">
        <button @click="open = !open"
                @click.away="open = false"
                class="w-full flex justify-between items-center bg-zinc-50 border border-zinc-200 px-4 py-2.5 text-[10px] font-mono uppercase tracking-widest text-zinc-500 hover:text-zinc-900 transition-colors">
            <span x-text="filterStatus.replace('_', ' ')"></span>
            <i data-lucide="chevron-down" class="size-3 transition-transform" :class="open ? 'rotate-180' : ''"></i>
        </button>

        <div x-show="open" x-cloak
             class="absolute right-0 mt-1 z-[100] bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-[256px]">
            <div class="py-1">
                @foreach(['ALL STATUSES', 'active', 'pending', 'inactive'] as $opt)
                    <a href="{{ route('coach.clients.index', ['status' => $opt, 'search' => request('search')]) }}"
                       class="w-full text-left flex items-center px-4 py-2 text-[10px] font-mono uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 transition-all font-sans {{ request('status', 'ALL STATUSES') === $opt ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500' }}">
                        {{ strtoupper($opt) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
