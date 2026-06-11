        <!-- Matrix Analysis Column -->
        <div class="space-y-6">
            <div class="ag-card p-6 bg-white sticky top-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.03)] border-zinc-200">
                <div class="flex items-center justify-between mb-6 border-b border-zinc-100 pb-4">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-zinc-950">Matrix Analysis</h3>
                    <div class="flex gap-1">
                        <div class="h-1 w-1 bg-cyan-500"></div>
                        <div class="h-1 w-3 bg-zinc-100"></div>
                    </div>
                </div>

                <!-- Macro Distribution Bar (Live Gradient) -->
                <div class="mb-8 space-y-2">
                    <div class="flex justify-between text-[8px] uppercase tracking-widest text-zinc-400 font-mono">
                        <span>Distribution Yield</span>
                        <span class="text-cyan-600" x-text="Math.round(totalMacros) + 'G TOTAL'"></span>
                    </div>
                    <div class="h-4 w-full bg-zinc-100 flex overflow-hidden">
                        <div class="h-full bg-cyan-600 transition-all duration-500" :style="'width: ' + pPct + '%'"></div>
                        <div class="h-full bg-zinc-900 transition-all duration-500 border-l border-white/10" :style="'width: ' + cPct + '%'"></div>
                        <div class="h-full bg-emerald-500 transition-all duration-500 border-l border-white/10" :style="'width: ' + fPct + '%'"></div>
                    </div>
                    <div class="flex gap-x-4 mt-2">
                        <div class="flex items-center gap-1.5">
                            <div class="size-1.5 bg-cyan-600"></div>
                            <span class="text-[7px] text-zinc-500 uppercase tracking-tighter">PRO</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="size-1.5 bg-zinc-900"></div>
                            <span class="text-[7px] text-zinc-500 uppercase tracking-tighter">CAR</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="size-1.5 bg-emerald-500"></div>
                            <span class="text-[7px] text-zinc-500 uppercase tracking-tighter">FAT</span>
                        </div>
                    </div>
                </div>

                <!-- Compact Metric Inputs -->
                <div class="grid grid-cols-3 gap-2 mb-8">
                    <div class="space-y-1.5">
                        <label class="block text-[7px] text-zinc-400 uppercase tracking-widest font-mono">PRO (G)</label>
                        <input type="number" x-model.number="p" min="0" step="0.1"
                               class="w-full bg-zinc-50 border border-zinc-200 px-3 py-2 text-[10px] font-mono font-bold outline-none focus:border-cyan-600 transition-all text-cyan-700 rounded-none shadow-inner">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[7px] text-zinc-400 uppercase tracking-widest font-mono">CAR (G)</label>
                        <input type="number" x-model.number="c" min="0" step="0.1"
                               class="w-full bg-zinc-50 border border-zinc-200 px-3 py-2 text-[10px] font-mono font-bold outline-none focus:border-cyan-600 transition-all text-zinc-950 rounded-none shadow-inner">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[7px] text-zinc-400 uppercase tracking-widest font-mono">FAT (G)</label>
                        <input type="number" x-model.number="f" min="0" step="0.1"
                               class="w-full bg-zinc-50 border border-zinc-200 px-3 py-2 text-[10px] font-mono font-bold outline-none focus:border-cyan-600 transition-all text-emerald-600 rounded-none shadow-inner">
                    </div>
                </div>

                <!-- Digital Kcal Monitor -->
                <div class="relative bg-zinc-950 p-6 overflow-hidden border-t border-white/5">
                    <div class="absolute top-0 right-0 p-2 opacity-10 pointer-events-none">
                        <i data-lucide="activity" class="size-12 text-cyan-500"></i>
                    </div>
                    <p class="text-[8px] text-cyan-500/50 uppercase tracking-[0.3em] mb-2 font-mono">Total Energy Output</p>
                    <div class="flex items-baseline gap-x-2">
                        <span class="text-3xl font-bold text-white font-mono tracking-tighter" x-text="kcal"></span>
                        <span class="text-[10px] text-cyan-500 font-mono font-bold uppercase tracking-widest">Kcal Units</span>
                    </div>
                    <div class="mt-4 flex gap-1">
                        <template x-for="i in 20">
                            <div class="h-1 w-full bg-cyan-950/30" :class="i <= (kcal/1000 * 20) ? 'bg-cyan-500/50' : ''"></div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
