@extends('layouts.client')

@section('title', 'Biometric Sync')

@section('content')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div x-data='evolutionSync({ history: @json($history) })' class="max-w-4xl mx-auto relative">
    
    <!-- Background Accents -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-cyan-50/10 blur-[140px] rounded-full -mr-64 -mt-64"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-zinc-50/50 blur-[140px] rounded-full -ml-64 -mb-64"></div>
    </div>

    @include('client.evolution.partials.header')
    @include('client.evolution.partials.chart')
    @include('client.evolution.partials.upload-form')

    <!-- Archive History (Log Trace) -->
    <div class="pt-16 border-t border-zinc-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-6 mb-12">
            <div>
                <h4 class="text-[12px] font-mono font-bold uppercase tracking-[0.4em] text-zinc-900 underline decoration-cyan-100 underline-offset-8">Archive Trace</h4>
                <p class="text-[9px] font-mono text-zinc-400 uppercase mt-2">Chronological Biometric Ledger</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 flex-1 max-w-2xl justify-end">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 size-4 text-zinc-300"></i>
                    <input type="text" x-model="searchQuery" placeholder="Search By Weight Or Date..." 
                           class="w-full pl-12 pr-6 py-4 bg-white ag-border text-[10px] font-mono uppercase tracking-widest placeholder:text-zinc-200 focus:ring-1 focus:ring-cyan-600 outline-none shadow-sm transition-all focus:shadow-lg">
                </div>
                
                <!-- Sort / Filter -->
                <div class="relative w-full md:w-64" x-data="{ filterOpen: false }">
                    <button @click="filterOpen = !filterOpen" @click.away="filterOpen = false"
                            class="w-full flex justify-between items-center bg-white border border-zinc-200 px-6 py-4 text-[10px] font-mono uppercase tracking-widest text-zinc-500 hover:text-zinc-900 transition-colors shadow-sm">
                        <span x-text="'SORT: ' + filterOption.replace('_', ' ')"></span>
                        <i data-lucide="chevron-down" class="size-3 transition-transform" :class="filterOpen ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="filterOpen" x-cloak
                         class="absolute top-full left-0 right-0 z-[100] bg-white border border-zinc-200 shadow-[16px_16px_0px_0px_rgba(0,0,0,0.05)] mt-0.5">
                        <div class="py-1">
                            <template x-for="opt in [
                                {v: 'latest', l: 'LATEST ENTRY'},
                                {v: 'oldest', l: 'OLDEST ENTRY'},
                                {v: 'heaviest', l: 'MAX MASS'},
                                {v: 'lightest', l: 'MIN MASS'},
                                {v: 'photos', l: 'SNAPSHOTS ONLY'}
                            ]">
                                <button @click="filterOption = opt.v; filterOpen = false" 
                                        class="w-full text-left px-6 py-3 text-[10px] font-mono uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 transition-all"
                                        :class="filterOption === opt.v ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500'">
                                    <span x-text="opt.l"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
                
                <div class="h-[60px] w-[60px] bg-zinc-950 flex items-center justify-center text-white text-sm font-mono font-bold shadow-[8px_8px_0px_0px_rgba(0,0,0,0.05)]">
                    <span x-text="filteredHistory.length"></span>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <template x-for="entry in filteredHistory" :key="entry.id">
                <div @click="selectedSync = entry; syncModalOpen = true" 
                     class="group ag-card bg-white p-6 flex items-center space-x-6 cursor-pointer hover:border-cyan-600 transition-all relative overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-2 duration-300">
                    
                    <div class="absolute left-0 top-0 h-full w-1 bg-zinc-50 group-hover:bg-cyan-600 transition-colors"></div>

                    <div class="h-20 w-20 bg-zinc-50 ag-border flex items-center justify-center overflow-hidden grayscale group-hover:grayscale-0 transition-all duration-500 relative shadow-inner">
                        <template x-if="entry.images && entry.images.length > 0">
                            <div class="h-full w-full">
                                <img :src="'/storage/' + entry.images[0]" alt="Progress" class="w-full h-full object-cover">
                                <div class="absolute bottom-1 right-1 bg-zinc-950/90 text-[7px] font-mono text-white px-1.5 py-0.5 border border-zinc-800">
                                    +<span x-text="entry.images.length"></span>
                                </div>
                            </div>
                        </template>
                        <template x-if="!entry.images || entry.images.length === 0">
                            <i data-lucide="image" class="h-8 w-8 text-zinc-100"></i>
                        </template>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="text-xs font-mono font-bold text-zinc-900 tracking-tighter" x-text="formatDate(entry.recorded_at)"></span>
                            <span class="h-[1px] w-4 bg-zinc-200"></span>
                            <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">LOG_ENTRY</span>
                        </div>
                        <p class="text-[13px] font-mono font-bold text-cyan-700 uppercase tracking-tight"><span x-text="entry.weight"></span> KG // METRIC MASS</p>
                    </div>

                    <div class="h-12 w-12 flex items-center justify-center text-zinc-100 group-hover:text-cyan-700 transition-all group-hover:bg-cyan-50 group-hover:border-cyan-200 ag-border rotate-0 group-hover:rotate-45 duration-500">
                        <i data-lucide="maximize-2" class="size-5"></i>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State (Alpine) -->
        <template x-if="filteredHistory.length === 0">
            <div class="p-32 text-center ag-border bg-white border-dashed border-zinc-100 mt-10">
                <div class="h-24 w-24 bg-zinc-50 ag-border mx-auto mb-10 flex items-center justify-center text-zinc-100 shadow-inner">
                    <i data-lucide="database-zap" class="size-12"></i>
                </div>
                <p class="text-[11px] text-zinc-400 uppercase font-mono tracking-[0.5em] mb-4">No Sync Records Detected</p>
                <p class="text-[9px] text-zinc-300 uppercase font-mono mt-3 italic underline decoration-zinc-50 underline-offset-8">Awaiting Initial System Deployment</p>
            </div>
        </template>
    </div>

    @include('client.evolution.partials.modal')
</div>
@endsection
