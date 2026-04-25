@extends('layouts.client')

@section('title', 'Active Protocol')

@section('content')
<div x-data="{ 
    detailModalOpen: false, 
    selectedMeal: null,
    dailyMacros: { 
        kcal: {{ $programData['dailyMacros']['kcal'] ?? 0 }}, 
        p: {{ $programData['dailyMacros']['p'] ?? 0 }}, 
        c: {{ $programData['dailyMacros']['c'] ?? 0 }}, 
        f: {{ $programData['dailyMacros']['f'] ?? 0 }} 
    } 
}" class="max-w-7xl mx-auto relative">
    
    <!-- Background Accents -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-cyan-50/10 blur-[140px] rounded-full -mr-64 -mt-64"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-zinc-50/50 blur-[140px] rounded-full -ml-64 -mb-64"></div>
    </div>

    @if($programData['program_title'] !== 'NO_ACTIVE_PROTOCOL')
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-16">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-4">
                    <span class="h-[1px] w-12 bg-cyan-700"></span>
                    <span class="text-[10px] font-mono font-bold text-cyan-700 uppercase tracking-[0.4em]">Current Status: Deployment Level 03</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-mono font-bold tracking-tighter uppercase text-zinc-900 leading-none">Active Protocol</h1>
                <p class="text-[11px] font-mono text-zinc-400 mt-5 uppercase tracking-[0.2em] flex items-center">
                    <i data-lucide="zap" class="size-4 mr-3 text-cyan-600"></i>
                    Neural MasterPlan: {{ $programData['program_title'] }} // V3.0 PRO SYNC
                </p>
            </div>
            
            <div class="mt-8 lg:mt-0 flex space-x-4">
                <div class="ag-card px-8 py-5 bg-white flex flex-col items-center justify-center border border-zinc-100 shadow-sm">
                    <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest mb-1">Phase</span>
                    <span class="text-sm font-mono font-bold text-zinc-900 uppercase">Load Hypertrophy</span>
                </div>
                <div class="ag-card px-8 py-5 bg-white flex flex-col items-center justify-center border border-zinc-100 shadow-sm">
                    <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest mb-1">Intensity</span>
                    <span class="text-sm font-mono font-bold text-cyan-600 uppercase">Optimal</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8 mb-20">
            <div class="xl:col-span-3 ag-card p-12 !bg-[#09090B] !text-white border-l-4 border-l-cyan-600 relative overflow-hidden group cursor-crosshair">
                <div class="absolute inset-0 opacity-[0.05] pointer-events-none">
                    <svg class="w-full h-full" viewBox="0 0 800 400" preserveAspectRatio="none">
                        <path d="M0 300 L100 280 L200 320 L300 150 L400 240 L500 100 L600 280 L700 200 L800 250" 
                              fill="none" stroke="currentColor" stroke-width="2" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-20">
                        <div>
                            <p class="text-[10px] font-mono text-zinc-600 uppercase tracking-[0.4em] mb-4">Internal Metric Overview</p>
                            <h3 class="text-2xl font-mono font-bold text-zinc-100 uppercase tracking-tight">System Nutrient Partitioning</h3>
                        </div>
                        <div class="mt-8 md:mt-0 flex items-center bg-zinc-900/40 p-1 border-l border-zinc-800">
                            <div class="flex items-baseline px-6">
                                <span class="text-7xl font-mono font-bold text-cyan-500 tracking-tighter leading-none" x-text="dailyMacros.kcal"></span>
                                <span class="text-[10px] font-mono text-zinc-500 font-bold ml-3 uppercase tracking-widest">Kcal Target</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
                        <template x-for="item in [
                            { label: 'Protein Synthetics', val: dailyMacros.p, color: 'bg-cyan-600' },
                            { label: 'Glycogen Reserve', val: dailyMacros.c, color: 'bg-white' },
                            { label: 'Lipid Optimization', val: dailyMacros.f, color: 'bg-zinc-600' }
                        ]">
                            <div class="space-y-4">
                                <div class="flex justify-between items-end border-b border-zinc-800/50 pb-2">
                                    <span class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest" x-text="item.label"></span>
                                    <span class="text-2xl font-mono font-bold text-white tracking-tighter" x-text="item.val + 'g'"></span>
                                </div>
                                <div class="h-2.5 bg-zinc-900 overflow-hidden">
                                    <div :class="item.color" class="h-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="ag-card p-12 bg-white flex flex-col justify-between shadow-sm">
                <div>
                    <div class="h-10 w-10 ag-border flex items-center justify-center text-cyan-600 mb-8">
                        <i data-lucide="info" class="size-5"></i>
                    </div>
                    <h5 class="text-[10px] font-mono font-bold text-zinc-900 uppercase tracking-widest mb-6 border-b border-zinc-100 pb-2">Core Directive</h5>
                    <p class="text-[11px] font-mono text-zinc-400 leading-relaxed uppercase tracking-tight">Maintain strict adherence to meal timing for maximum metabolic overclocking.</p>
                </div>
                <div class="pt-8 mt-12 border-t border-zinc-100">
                    <span class="text-[8px] font-mono text-zinc-300 uppercase block mb-1 tracking-widest">Status Check</span>
                    <div class="flex items-center space-x-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        <span class="text-[10px] font-mono font-bold text-emerald-600 uppercase tracking-widest">100% Sync Ready</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-10">
            <div class="flex items-center justify-between border-b border-zinc-100 pb-3">
                <h4 class="text-[10px] font-mono font-bold uppercase tracking-[0.3em] text-zinc-400">Daily Sequence</h4>
                <div class="flex items-center space-x-2 text-zinc-200">
                    <span class="text-[8px] font-mono uppercase font-bold tracking-widest">Mark V3.0</span>
                    <i data-lucide="list-ordered" class="size-4"></i>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($programData['meals'] as $meal)
                    <div @click="selectedMeal = {{ json_encode($meal) }}; detailModalOpen = true" 
                         class="group ag-card p-0 bg-white hover:border-cyan-600 transition-all cursor-pointer relative overflow-hidden flex flex-col shadow-sm hover:shadow-2xl hover:-translate-y-2 duration-300">
                        
                        <div class="h-1 bg-zinc-50 group-hover:bg-cyan-600 transition-colors"></div>
                        
                        <div class="p-10 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-12">
                                <div class="px-3 py-1 bg-zinc-50 ag-border text-[8px] font-mono font-bold text-zinc-400 uppercase tracking-widest group-hover:bg-cyan-50 group-hover:text-cyan-700 transition-colors">
                                    {{ $meal['cat'] }}
                                </div>
                                <span class="text-[9px] font-mono text-zinc-300 font-bold uppercase tracking-widest">{{ $meal['time'] }} HRS</span>
                            </div>

                            <h4 class="text-xl font-mono font-bold text-zinc-900 uppercase tracking-tighter group-hover:text-cyan-700 transition-colors mb-4 leading-tight min-h-[4rem]">
                                {{ str_replace('_', ' ', $meal['menu']) }}
                            </h4>

                            <div class="mt-auto pt-8 border-t border-zinc-50 flex justify-between items-end opacity-40 group-hover:opacity-100 transition-opacity">
                                <div class="flex flex-col">
                                    <span class="text-2xl font-mono font-bold text-zinc-900 tracking-tighter">{{ $meal['kcal'] }}</span>
                                    <span class="text-[7px] font-mono text-zinc-400 font-bold uppercase tracking-widest">Kcal Yield</span>
                                </div>
                                <div class="h-10 w-10 ag-border flex items-center justify-center text-zinc-200 group-hover:text-cyan-600 group-hover:bg-cyan-50 transition-all">
                                    <i data-lucide="plus" class="size-5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="p-32 text-center ag-border bg-white border-dashed border-zinc-200 mt-20">
            <div class="h-24 w-24 bg-zinc-50 ag-border mx-auto mb-10 flex items-center justify-center text-zinc-200 shadow-inner">
                <i data-lucide="box-select" class="size-12"></i>
            </div>
            <h3 class="text-xl font-mono font-bold text-zinc-900 uppercase tracking-widest mb-4">No Active Protocol Detected</h3>
            <p class="text-[10px] text-zinc-400 uppercase font-mono italic decoration-zinc-100 underline underline-offset-8 tracking-widest">Awaiting Neural Deployment from Coach</p>
        </div>
    @endif

    <!-- Detail Modal -->
    <div x-show="detailModalOpen" x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        
        <div @click="detailModalOpen = false" 
             class="absolute inset-0 bg-zinc-950/90 backdrop-blur-xl transition-all"></div>

        <div x-show="detailModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-12"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="ag-card bg-white w-full max-w-2xl relative z-10 overflow-hidden shadow-[40px_40px_0px_0px_rgba(0,0,0,0.1)]">
            
            <div class="p-10 border-b border-zinc-100 bg-zinc-50/30 flex justify-between items-start">
                <div>
                    <span class="text-[9px] font-mono text-cyan-700 font-bold uppercase tracking-[0.4em] block mb-3 px-3 py-1 bg-cyan-50 ag-border inline-block" x-text="selectedMeal?.cat + ' PROTOCOL NODE'"></span>
                    <h2 class="text-3xl font-mono font-bold text-zinc-900 uppercase tracking-tighter" x-text="selectedMeal?.menu"></h2>
                </div>
                <button @click="detailModalOpen = false" class="h-12 w-12 ag-border flex items-center justify-center text-zinc-400 hover:text-zinc-900 transition-all hover:rotate-90 duration-300">
                    <i data-lucide="x" class="size-5"></i>
                </button>
            </div>

            <div class="p-10">
                <div class="grid grid-cols-4 gap-6 mb-12">
                    <div class="p-6 bg-zinc-50 ag-border text-center">
                        <p class="text-[8px] font-mono text-zinc-400 uppercase mb-2">Energy</p>
                        <p class="text-xl font-mono font-bold text-zinc-900" x-text="selectedMeal?.kcal + 'kc'"></p>
                    </div>
                    <div class="p-6 bg-zinc-50 ag-border text-center border-b-4 border-b-cyan-600">
                        <p class="text-[8px] font-mono text-zinc-400 uppercase mb-2">Protein</p>
                        <p class="text-xl font-mono font-bold text-zinc-900" x-text="selectedMeal?.p + 'g'"></p>
                    </div>
                    <div class="p-6 bg-zinc-50 ag-border text-center border-b-4 border-b-zinc-900">
                        <p class="text-[8px] font-mono text-zinc-400 uppercase mb-2">Carbs</p>
                        <p class="text-xl font-mono font-bold text-zinc-900" x-text="selectedMeal?.c + 'g'"></p>
                    </div>
                    <div class="p-6 bg-zinc-50 ag-border text-center border-b-4 border-b-zinc-400">
                        <p class="text-[8px] font-mono text-zinc-400 uppercase mb-2">Fats</p>
                        <p class="text-xl font-mono font-bold text-zinc-900" x-text="selectedMeal?.f + 'g'"></p>
                    </div>
                </div>

                <div class="bg-zinc-50/50 p-8 ag-border border-dashed">
                    <h4 class="text-[10px] font-mono font-bold text-zinc-900 uppercase tracking-[0.4em] mb-4 flex items-center">
                        <i data-lucide="scroll-text" class="size-4 mr-3 text-cyan-600"></i>
                        Execution Schema
                    </h4>
                    <p class="text-sm font-mono text-zinc-500 leading-relaxed font-sans" x-text="selectedMeal?.desc"></p>
                </div>
            </div>

            <div class="p-10 bg-zinc-50 border-t border-zinc-100 flex justify-end">
                <button @click="detailModalOpen = false" 
                        class="px-12 py-5 bg-zinc-950 text-white text-[11px] font-mono font-bold uppercase tracking-[0.3em] hover:bg-black transition-all shadow-[12px_12px_0px_0px_rgba(0,0,0,0.05)]">
                    Return to Nexus
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
