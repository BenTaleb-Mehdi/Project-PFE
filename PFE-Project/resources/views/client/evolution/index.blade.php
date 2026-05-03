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

    <!-- Header Section -->
    <header class="mb-12">
        <div class="flex items-center space-x-3 mb-4">
            <span class="h-[1px] w-12 bg-cyan-700"></span>
            <span class="text-[10px] font-mono font-bold text-cyan-700 uppercase tracking-[0.4em]">Current Status: Biometric Active</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-mono font-bold tracking-tighter uppercase text-zinc-900">Evolution Sync</h1>
        <p class="text-[11px] font-mono text-zinc-400 mt-5 uppercase tracking-[0.2em] flex items-center">
            <i data-lucide="zap" class="size-4 mr-3 text-cyan-600"></i>
            Module: Physical Trace Capture // V3.0 PRO SYNC
        </p>
    </header>
    
    <!-- Progression Analytics -->
    <div class="mb-12 ag-card p-10 bg-white relative overflow-hidden group shadow-sm">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h4 class="text-[10px] font-mono font-bold uppercase tracking-[0.4em] text-zinc-900">Bio-Metric Analytics</h4>
                <p class="text-[8px] font-mono text-zinc-400 uppercase mt-1">Real-time Mass Trajectory</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="h-2 w-2 rounded-full bg-cyan-600 animate-pulse"></span>
                <span class="text-[8px] font-mono font-bold text-zinc-900 uppercase tracking-widest">Live Sync</span>
            </div>
        </div>
        <div class="h-[250px] w-full">
            <canvas id="weightChart"></canvas>
        </div>
    </div>

    <form action="{{ route('client.evolution.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-20">
        @csrf
        
        <!-- Left Side: Upload Zone -->
        <div class="space-y-6">
            <div class="relative group h-full min-h-[300px]">
                <input type="file" name="photos[]" multiple @change="handleFileChange" class="absolute inset-0 opacity-0 cursor-pointer z-10" id="photo_input">
                <div class="ag-card h-full p-10 bg-white border-dashed border-2 border-zinc-200 flex flex-col items-center justify-center text-center group-hover:border-cyan-600 transition-all shadow-sm">
                    <div class="h-20 w-20 bg-zinc-50 flex items-center justify-center mb-8 group-hover:bg-cyan-50 transition-colors">
                        <i data-lucide="layers" class="h-10 w-10 text-zinc-200 group-hover:text-cyan-600 transition-colors"></i>
                    </div>
                    <h3 class="text-sm font-mono font-bold uppercase tracking-widest text-zinc-900 mb-3">Deploy Sync Payload</h3>
                    <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-[0.2em] leading-relaxed">Multi-Angle Biometric Snapshots<br/>Required Format: PNG / JPG</p>
                </div>
                
                <!-- Live Previews Overlay -->
                <div x-show="previewPhotos.length > 0" class="absolute bottom-6 left-6 right-6 grid grid-cols-5 gap-2 pointer-events-none">
                    <template x-for="photo in previewPhotos">
                        <div class="aspect-square ag-border overflow-hidden bg-white shadow-md grayscale hover:grayscale-0 transition-all duration-500">
                            <img :src="photo" class="w-full h-full object-cover">
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Right Side: Metrics & Submit -->
        <div class="space-y-8">
            <div class="ag-card p-10 bg-zinc-950 text-white border-l-4 border-l-cyan-600 shadow-[20px_20px_0px_0px_rgba(0,0,0,0.03)] relative overflow-hidden group">
                <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i data-lucide="activity" class="size-48 stroke-[0.5]"></i>
                </div>
                <div class="relative z-10">
                    <label class="block text-[9px] font-mono text-zinc-500 uppercase tracking-[0.3em] mb-8">System Mass Input (KG)</label>
                    <div class="flex items-baseline space-x-6">
                        <input type="number" step="0.1" name="weight" placeholder="00.0" required
                               class="text-7xl font-mono font-bold w-full bg-transparent outline-none text-cyan-500 border-none p-0 focus:ring-0 tracking-tighter placeholder-zinc-800">
                        <span class="text-xs font-mono text-zinc-600 font-bold uppercase">Metric Units</span>
                    </div>
                </div>
            </div>

            <input type="hidden" name="recorded_at" value="{{ date('Y-m-d') }}">

            <button type="submit" class="w-full py-6 bg-zinc-900 text-white text-[11px] font-mono font-bold uppercase tracking-[0.4em] hover:bg-black transition-all shadow-[12px_12px_0px_0px_rgba(0,0,0,0.05)] active:scale-[0.98] group hover:tracking-[0.6em] duration-500">
                Finalize Snapshot Sync
                <i data-lucide="arrow-right" class="size-4 ml-4 inline-block transition-transform group-hover:translate-x-2"></i>
            </button>
        </div>
    </form>

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

    <!-- Sync Detail Modal -->
    <div x-show="syncModalOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        
        <div @click="syncModalOpen = false" 
             class="absolute inset-0 bg-zinc-950/90 backdrop-blur-2xl"></div>

        <div x-show="syncModalOpen"
             x-transition:enter="transition ease-out duration-350"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="ag-card bg-white w-full max-w-4xl max-h-[85vh] relative z-10 overflow-hidden shadow-[48px_48px_0px_0px_rgba(0,0,0,0.15)] flex flex-col">
            
            <div x-data="{ currentImg: 0 }">
                <div class="p-10 border-b border-zinc-100 bg-zinc-50/50 flex justify-between items-center">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <span class="h-2 w-2 bg-cyan-600 animate-pulse"></span>
                            <h2 class="text-xl font-mono font-bold text-zinc-900 uppercase tracking-tighter">Sync Node Analysis V3</h2>
                        </div>
                        <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-[0.4em] flex items-center">
                            <i data-lucide="fingerprint" class="size-3 mr-2 text-cyan-600"></i>
                            Archive Hash ID: #000<span x-text="selectedSync?.id || '00'"></span> // SECURE LOG TRACE
                        </p>
                    </div>
                    <button @click="syncModalOpen = false" class="h-12 w-12 ag-border flex items-center justify-center text-zinc-400 hover:text-zinc-900 hover:rotate-90 duration-500 shadow-sm bg-white">
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <div class="flex flex-col lg:flex-row divide-y lg:divide-y-0 lg:divide-x divide-zinc-100 flex-1 overflow-hidden min-h-0">
                    <!-- Gallery Section -->
                    <div class="lg:w-1/2 bg-zinc-950 flex flex-col items-center justify-center relative overflow-hidden h-full">
                        <div class="h-full w-full relative group flex items-center justify-center">
                            <template x-if="selectedSync?.images && selectedSync.images.length > 0">
                                <template x-for="(img, index) in selectedSync.images" :key="index">
                                    <div x-show="currentImg === index" class="h-full w-full">
                                        <img :src="'/storage/' + img" 
                                             class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </template>
                            
                            <!-- Empty State Placeholder -->
                            <template x-if="!selectedSync?.images || selectedSync.images.length === 0">
                                <div class="flex flex-col items-center justify-center text-zinc-100">
                                    <i data-lucide="image-off" class="size-24 mb-6 stroke-[0.5]"></i>
                                    <span class="text-[10px] font-mono text-zinc-300 uppercase tracking-[0.4em]">No Photo Captured</span>
                                </div>
                            </template>
                            
                            <!-- Internal Nav -->
                            <div x-show="selectedSync?.images && selectedSync.images.length > 1" class="absolute bottom-6 left-0 right-0 flex justify-center space-x-3">
                                <template x-for="(img, index) in selectedSync.images" :key="index">
                                    <button @click="currentImg = index" 
                                            class="h-1.5 transition-all duration-300 border border-black/10"
                                            :class="currentImg === index ? 'bg-cyan-600 w-12' : 'bg-white/80 w-6 hover:bg-white'"></button>
                                </template>
                            </div>
                        </div>
                        
                        <!-- Thumbnail Strip -->
                        <div x-show="selectedSync?.images && selectedSync.images.length > 1" class="mt-8 flex space-x-3 overflow-x-auto w-full max-w-sm p-1 scrollbar-hide">
                            <template x-for="(img, index) in selectedSync.images" :key="index">
                                <div @click="currentImg = index" 
                                     class="h-16 w-16 flex-shrink-0 ag-border cursor-pointer transition-all bg-white p-0.5"
                                     :class="currentImg === index ? 'border-cyan-600 -translate-y-1 shadow-md' : 'opacity-40 hover:opacity-100 border-transparent'">
                                    <img :src="'/storage/' + img" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Stats Section -->
                    <div class="lg:w-1/2 p-10 space-y-8 bg-white overflow-y-auto">
                        <div class="bg-zinc-50/50 p-6 ag-border border-dashed">
                            <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest mb-3 flex items-center">
                                <i data-lucide="clock" class="size-3 mr-2"></i>
                                Timestamp Metric
                            </p>
                            <p class="text-xl font-mono font-bold text-zinc-900 tracking-tighter underline decoration-cyan-100 underline-offset-8" x-text="formatDate(selectedSync?.recorded_at)"></p>
                        </div>

                        <div class="space-y-6">
                            <div class="p-8 bg-zinc-950 text-white relative overflow-hidden group shadow-xl">
                                <div class="absolute -right-4 -top-4 text-zinc-900 group-hover:scale-110 transition-transform duration-1000">
                                    <i data-lucide="activity" class="size-32 stroke-[0.3]"></i>
                                </div>
                                <div class="relative z-10">
                                    <p class="text-[9px] font-mono text-zinc-500 uppercase tracking-[0.3em] mb-4">Sync Recorded Mass</p>
                                    <div class="flex items-baseline space-x-4">
                                        <span class="text-6xl font-mono font-bold tracking-tighter text-cyan-500" x-text="selectedSync?.weight"></span>
                                        <span class="text-xs font-mono text-zinc-500 font-bold uppercase tracking-widest">KILOGRAMS</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-3">
                                <div class="p-5 ag-border flex justify-between items-center bg-zinc-50/30 hover:bg-zinc-50 transition-colors">
                                    <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest">BM Sync Status</p>
                                    <div class="flex items-center space-x-3">
                                        <span class="h-1.5 w-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                        <span class="text-[11px] font-mono font-bold text-emerald-600 uppercase tracking-widest">STABLE V3.0</span>
                                    </div>
                                </div>
                                <div class="p-5 ag-border flex justify-between items-center bg-zinc-50/30 hover:bg-zinc-50 transition-colors">
                                    <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest">Trend Analysis</p>
                                    <span class="text-[11px] font-mono font-bold text-cyan-600 uppercase tracking-widest">Bio Sync Elite</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-zinc-100">
                            <h5 class="text-[10px] font-mono font-bold text-zinc-900 uppercase tracking-widest mb-6 border-b border-zinc-50 pb-2 flex items-center justify-between">
                                <span>Detailed Log Trace</span>
                                <i data-lucide="scroll-text" class="size-4 text-zinc-200"></i>
                            </h5>
                            <div class="space-y-4">
                                <div class="flex justify-between text-[10px] font-mono uppercase items-center">
                                    <span class="text-zinc-400 tracking-widest">Node Architecture</span>
                                    <span class="text-zinc-900 font-bold bg-zinc-50 px-2 py-0.5 ag-border">SECURE ALPHA</span>
                                </div>
                                <div class="flex justify-between text-[10px] font-mono uppercase items-center text-zinc-400">
                                    <span>Sync Protocol</span>
                                    <span class="text-zinc-900 font-bold">MULTI SURFACE V3</span>
                                </div>
                                <div class="flex justify-between text-[10px] font-mono uppercase items-center">
                                    <span class="text-zinc-400">Integrity Check</span>
                                    <div class="flex items-center space-x-2">
                                        <i data-lucide="check-circle-2" class="size-3 text-emerald-600"></i>
                                        <span class="text-emerald-600 font-bold">100% PASS</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-10 bg-zinc-50 border-t border-zinc-100 flex gap-4">
                    <form :action="'{{ route('client.evolution.destroy', ['id' => 'REPLACE_ID']) }}'.replace('REPLACE_ID', selectedSync?.id)" method="POST" class="flex-1" onsubmit="return confirm('CRITICAL_WARNING: This action will purge the biometric log. Proceed?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full py-6 bg-white border border-red-100 text-red-600 text-[11px] font-mono font-bold uppercase tracking-[0.3em] hover:bg-red-50 transition-all duration-300 shadow-sm active:scale-[0.98]">
                            Purge Log Node
                        </button>
                    </form>
                    <button @click="syncModalOpen = false" 
                            class="flex-[2] py-6 bg-zinc-950 text-white text-[12px] font-mono font-bold uppercase tracking-[0.4em] hover:bg-black transition-all hover:tracking-[0.6em] duration-700 shadow-[16px_16px_0px_0px_rgba(0,0,0,0.05)] active:scale-[0.98]">
                        Close Analysis
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
