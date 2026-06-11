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
            <div class="flex flex-col">
                <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">Status: Success Sync</span>
                <span class="text-[10px] font-mono font-bold text-cyan-600 uppercase tracking-widest">PROFILE_SYNCED // Record_Modified</span>
            </div>
        </div>
    </div>
</div>
