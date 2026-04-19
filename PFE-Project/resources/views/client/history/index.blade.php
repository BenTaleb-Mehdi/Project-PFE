@extends('layouts.client')

@section('title', 'Program History')

@section('content')
<div x-data="{ 
    searchQuery: '',
    filterStatus: 'ALL_STATUSES',
    expandedIds: [],
    toggleExpand(id) {
        if (this.expandedIds.includes(id)) {
            this.expandedIds = this.expandedIds.filter(i => i !== id);
        } else {
            this.expandedIds.push(id);
        }
    }
}">

    <header class="mb-10 lg:flex lg:justify-between lg:items-end">
        <div>
            <h1 class="text-3xl font-mono font-bold tracking-tight uppercase text-zinc-900">Program_History</h1>
            <p class="text-[10px] font-mono text-zinc-400 mt-2 uppercase tracking-[0.2em]">Historical_Intelligence // Protocol_Archive</p>
        </div>
    </header>

    <!-- Discovery Bar -->
    <div class="ag-card p-4 bg-white mb-8 border border-zinc-200 flex flex-col md:flex-row gap-4 items-center">
        <!-- Search -->
        <div class="relative flex-1 w-full">
            <input type="text" 
                   x-model="searchQuery"
                   placeholder="Search_Protocols (Name)..." 
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

    <!-- History Table -->
    <div class="ag-card bg-white border border-zinc-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse font-mono">
                <thead class="bg-zinc-50 border-b border-zinc-200 text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                    <tr>
                        <th class="px-6 py-4">Protocol_ID</th>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Meal_Nodes</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 uppercase text-[10px]">
                    @forelse($programData['all_programs'] as $program)
                        @php
                            $statusClasses = match($program->status ?? 'Archive') {
                                'Active'    => 'border-emerald-200 bg-emerald-50 text-emerald-600',
                                'Completed' => 'border-cyan-200 bg-cyan-50 text-cyan-600',
                                default     => 'border-zinc-200 bg-zinc-100 text-zinc-400',
                            };
                        @endphp

                        <!-- Main Row -->
                        <tr @click="toggleExpand({{ $program->id }})" 
                            class="group hover:bg-zinc-50 transition-colors cursor-pointer border-b border-zinc-100 last:border-0">
                            <td class="px-6 py-4 text-zinc-400">#{{ $program->id }}</td>
                            <td class="px-6 py-4 font-bold text-zinc-900">{{ $program->title }}</td>
                            <td class="px-6 py-4 text-zinc-500">{{ $program->items_count }} Slots</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 border text-[9px] font-bold uppercase tracking-widest {{ $statusClasses }}">
                                    {{ $program->status ?? 'Archive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="text-zinc-300 transition-all duration-300 transform"
                                     :class="expandedIds.includes({{ $program->id }}) ? 'rotate-180 text-cyan-600' : 'group-hover:text-zinc-950'">
                                    <i data-lucide="chevron-down" class="h-4 w-4 ml-auto"></i>
                                </div>
                            </td>
                        </tr>

                        <!-- Expanded Detail Row -->
                        <tr x-show="expandedIds.includes({{ $program->id }})" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="bg-zinc-50/50 border-b border-zinc-100">
                            <td colspan="5" class="px-0 py-0">
                                <div class="p-8 border-t border-dashed border-zinc-200">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 text-left">
                                        <!-- Meal Matrix -->
                                        <div>
                                            <div class="flex justify-between items-center mb-4">
                                                <h5 class="text-[8px] font-bold text-zinc-400 uppercase tracking-[0.2em]">Meal_Matrix_Sequence</h5>
                                                <span class="text-[8px] font-mono text-cyan-600 uppercase">{{ $program->items_count }} Sequences_Logged</span>
                                            </div>
                                            <div class="ag-card bg-white border border-zinc-200 overflow-hidden shadow-sm">
                                                @if($program->items_count > 0)
                                                    <table class="w-full text-left text-[9px]">
                                                        <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-400 uppercase font-bold">
                                                            <tr>
                                                                <th class="px-4 py-3 font-mono">Seq</th>
                                                                <th class="px-4 py-3">Item_Label</th>
                                                                <th class="px-4 py-3 text-right">Kcal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-zinc-100">
                                                            @foreach($program->items as $item)
                                                                <tr class="hover:bg-cyan-50/30 transition-colors">
                                                                    <td class="px-4 py-2.5 font-bold text-zinc-400 font-mono">{{ $item->meal->category->name ?? 'Meal' }}</td>
                                                                    <td class="px-4 py-2.5 text-zinc-900 font-medium">{{ $item->meal->name ?? 'N/A' }}</td>
                                                                    <td class="px-4 py-2.5 text-right font-bold text-cyan-700 font-mono">{{ $item->meal->calories ?? 0 }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <div class="p-8 text-center bg-zinc-50/50">
                                                        <p class="text-[10px] font-mono text-zinc-400 uppercase italic">No_Meal_Data_Sequenced</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Macro Distribution -->
                                        <div>
                                            <h5 class="text-[8px] font-bold text-zinc-400 uppercase tracking-[0.2em] mb-4">Macro_Distribution_Archive</h5>
                                            @php
                                                $totalP = $program->items->sum(fn($i) => $i->meal->protein ?? 0);
                                                $totalC = $program->items->sum(fn($i) => $i->meal->carbs ?? 0);
                                                $totalF = $program->items->sum(fn($i) => $i->meal->fats ?? 0);
                                            @endphp
                                            <div class="grid grid-cols-3 gap-4">
                                                <div class="ag-card bg-white p-4 border border-zinc-200 text-center hover:border-emerald-200 transition-colors">
                                                    <p class="text-[8px] text-zinc-400 uppercase tracking-widest mb-1">Protein</p>
                                                    <p class="text-xl font-mono font-bold text-emerald-600">{{ $totalP }}<span class="text-[8px] ml-0.5">G</span></p>
                                                </div>
                                                <div class="ag-card bg-white p-4 border border-zinc-200 text-center hover:border-cyan-200 transition-colors">
                                                    <p class="text-[8px] text-zinc-400 uppercase tracking-widest mb-1">Carbs</p>
                                                    <p class="text-xl font-mono font-bold text-cyan-600">{{ $totalC }}<span class="text-[8px] ml-0.5">G</span></p>
                                                </div>
                                                <div class="ag-card bg-white p-4 border border-zinc-200 text-center hover:border-orange-200 transition-colors">
                                                    <p class="text-[8px] text-zinc-400 uppercase tracking-widest mb-1">Fats</p>
                                                    <p class="text-xl font-mono font-bold text-orange-500">{{ $totalF }}<span class="text-[8px] ml-0.5">G</span></p>
                                                </div>
                                            </div>

                                            <div class="mt-6 p-5 ag-card bg-white border border-zinc-200 shadow-sm">
                                                <div class="flex justify-between items-center mb-3">
                                                    <div class="flex items-center gap-2">
                                                        <div class="h-1.5 w-1.5 bg-emerald-500"></div>
                                                        <span class="text-[9px] font-bold text-zinc-900 uppercase tracking-widest">Protocol_Efficiency</span>
                                                    </div>
                                                    <span class="text-[10px] font-mono font-bold text-emerald-600">92%</span>
                                                </div>
                                                <div class="w-full h-1.5 bg-zinc-100 overflow-hidden">
                                                    <div class="h-full bg-emerald-500" style="width: 92%"></div>
                                                </div>
                                                <p class="text-[7px] text-zinc-400 uppercase mt-3 font-mono">Archive_Ref: AG-HIS-{{ $program->id }}-B</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-zinc-300 uppercase tracking-[0.3em] text-[8px] font-mono">
                                NODES_NULL // NO_HISTORY_DETECTED
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($programData['all_programs']) && method_exists($programData['all_programs'], 'links'))
        <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-[10px] text-zinc-500 font-mono uppercase tracking-widest">
                Showing {{ $programData['all_programs']->firstItem() }} to {{ $programData['all_programs']->lastItem() }} of {{ $programData['all_programs']->total() }}
            </span>
            {{ $programData['all_programs']->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
