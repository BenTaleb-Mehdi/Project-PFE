<!-- Protocol Intelligence Modal -->
<div x-show="showDetailsModal" x-cloak :class="showDetailsModal ? 'print-modal-projection' : 'no-print'" class="fixed inset-0 z-[200] flex items-center justify-center p-4">
    <div @click="showDetailsModal = false" class="fixed inset-0 bg-zinc-950/20 backdrop-blur-sm no-print"></div>
    <div class="relative bg-white border border-zinc-200 shadow-[10px_10px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-2xl overflow-hidden font-mono text-zinc-900 border-none print-intelligence-node">
        <header class="bg-zinc-950 p-6 text-white flex justify-between items-center">
            <div class="flex-1">
                <h3 class="text-[10px] font-bold uppercase tracking-[0.3em]" x-text="'PROTOCOL_GENESIS // ' + (detailedProtocol ? detailedProtocol.title : '')"></h3>
                <p class="text-[7px] text-cyan-400 uppercase mt-1 tracking-widest font-mono">Detailed_Intelligence_Report</p>
            </div>
            <div class="flex items-center gap-x-4 no-print">
                <button @click="window.print()" class="flex items-center gap-x-2 px-3 py-1.5 bg-white/10 hover:bg-white/20 text-[8px] font-bold uppercase tracking-widest transition-all">
                    <i data-lucide="file-down" class="size-3"></i>
                    Export_PDF
                </button>
                <button @click="showDetailsModal = false" class="text-zinc-400 hover:text-white transition-all modal-close">
                    <i data-lucide="x" class="size-4"></i>
                </button>
            </div>
        </header>

        <div class="p-8 space-y-8 bg-white overflow-y-auto max-h-[70vh]">
            <!-- Branded Print Identity (Visible only in Print) -->
            <div class="hidden print-only-branding flex-col border-b-2 border-zinc-900 pb-8 mb-8 items-stretch">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-x-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Coach Logo" class="h-10 w-auto object-contain">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold tracking-tighter uppercase text-zinc-950">Coach</span>
                            <span class="text-[9px] font-mono tracking-widest text-zinc-400 uppercase">Performance_Intelligence_Engine</span>
                        </div>
                    </div>
                    <div class="text-right font-mono">
                        <p class="text-[9px] text-zinc-400 uppercase tracking-widest">Document_Context</p>
                        <p class="text-[12px] font-bold text-zinc-950 uppercase" x-text="'PROTO_GENESIS // ' + (detailedProtocol ? detailedProtocol.title : '')"></p>
                        <p class="text-[9px] text-zinc-400 uppercase mt-3 tracking-widest">Issue_Timestamp</p>
                        <p class="text-[10px] font-bold text-zinc-950">{{ now()->format('d.m.Y // H:i:s') }}</p>
                    </div>
                </div>
            </div>

            <!-- Metric Overview -->
            <div class="grid grid-cols-4 gap-4 pb-8 border-b border-zinc-100">
                <div class="space-y-1">
                    <p class="text-[7px] text-zinc-400 uppercase">Total_Kcal</p>
                    <p class="text-lg font-bold text-cyan-600 font-mono" x-text="Math.round(getDetailedStats().k)"></p>
                </div>
                <div class="space-y-1">
                    <p class="text-[7px] text-zinc-400 uppercase">Protein_Yield</p>
                    <p class="text-lg font-bold text-zinc-950 font-mono" x-text="Math.round(getDetailedStats().p) + 'g'"></p>
                </div>
                <div class="space-y-1">
                    <p class="text-[7px] text-zinc-400 uppercase">Carb_Density</p>
                    <p class="text-lg font-bold text-zinc-950 font-mono" x-text="Math.round(getDetailedStats().c) + 'g'"></p>
                </div>
                <div class="space-y-1">
                    <p class="text-[7px] text-zinc-400 uppercase">Fat_Matrix</p>
                    <p class="text-lg font-bold text-emerald-600 font-mono" x-text="Math.round(getDetailedStats().f) + 'g'"></p>
                </div>
            </div>

            <!-- Sequence List -->
            <div class="space-y-4">
                <h4 class="text-[8px] font-bold uppercase tracking-[0.2em] text-zinc-400">Sequence_Analysis</h4>
                <div class="divide-y divide-zinc-50 border border-zinc-100">
                    <template x-for="item in (detailedProtocol ? detailedProtocol.items : [])" :key="item.id">
                        <div class="p-6 transition-all flex flex-col gap-y-4">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-6">
                                    <span class="text-[8px] font-bold text-cyan-600 uppercase w-24 border-r border-zinc-100" x-text="item.time_slot"></span>
                                    <span class="text-[10px] font-bold text-zinc-900 uppercase tracking-tight" x-text="item.meal ? item.meal.name : 'Unknown_Node'"></span>
                                </div>
                                <div class="flex gap-x-4 text-[8px] font-mono text-zinc-400 uppercase">
                                    <span x-text="item.meal ? item.meal.protein + 'P' : ''"></span>
                                    <span x-text="item.meal ? item.meal.carbs + 'C' : ''"></span>
                                    <span x-text="item.meal ? item.meal.fats + 'F' : ''"></span>
                                    <span class="text-cyan-700 font-bold" x-text="item.meal ? Math.round(item.meal.calories) + ' KCAL' : ''"></span>
                                </div>
                            </div>
                            <!-- Meal Details (Rich Text with Images) -->
                            <template x-if="item.meal && item.meal.details">
                                <div class="bg-zinc-50 p-4 border-l-2 border-cyan-100/50 mt-2 text-zinc-900 overflow-hidden">
                                    <div class="v3-editor-matrix text-[10px] font-sans leading-relaxed flex flex-col gap-y-2 whitespace-normal break-words" x-html="renderInstructions(item.meal.details)"></div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <footer class="p-6 bg-zinc-50 border-t border-zinc-100 flex justify-end">
            <button @click="showDetailsModal = false" 
                    class="px-8 py-3 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                Close_Report
            </button>
        </footer>
    </div>
</div>

<!-- Meal Intelligence Modal (Single Node) -->
<div x-show="showMealModal" x-cloak :class="showMealModal ? 'print-modal-projection' : 'no-print'" class="fixed inset-0 z-[200] flex items-center justify-center p-4">
    <div @click="showMealModal = false" class="fixed inset-0 bg-zinc-950/20 backdrop-blur-sm no-print"></div>
    <div class="relative bg-white border border-zinc-200 shadow-[10px_10px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-2xl overflow-hidden font-mono text-zinc-900 border-none print-intelligence-node">
        <header class="bg-zinc-950 p-6 text-white flex justify-between items-center">
            <div class="flex-1">
                <h3 class="text-[10px] font-bold uppercase tracking-[0.3em]" x-text="'NODE_GENESIS // ' + (detailedMeal ? detailedMeal.name : '')"></h3>
                <p class="text-[7px] text-cyan-400 uppercase mt-1 tracking-widest font-mono">Detailed_Meal_Intelligence</p>
            </div>
            <div class="flex items-center gap-x-4 no-print">
                <button @click="window.print()" class="flex items-center gap-x-2 px-3 py-1.5 bg-white/10 hover:bg-white/20 text-[8px] font-bold uppercase tracking-widest transition-all">
                    <i data-lucide="file-down" class="size-3"></i>
                    Export_PDF
                </button>
                <button @click="showMealModal = false" class="text-zinc-400 hover:text-white transition-all modal-close">
                    <i data-lucide="x" class="size-4"></i>
                </button>
            </div>
        </header>

        <div class="p-8 space-y-8 bg-white overflow-y-auto max-h-[70vh]">
            <!-- Branded Print Identity -->
            <div class="hidden print-only-branding flex-col border-b-2 border-zinc-900 pb-8 mb-8 items-stretch">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-x-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Coach Logo" class="h-10 w-auto object-contain">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold tracking-tighter uppercase text-zinc-950">Coach</span>
                            <span class="text-[9px] font-mono tracking-widest text-zinc-400 uppercase">Performance_Intelligence_Engine</span>
                        </div>
                    </div>
                    <div class="text-right font-mono">
                        <p class="text-[9px] text-zinc-400 uppercase tracking-widest">Document_Context</p>
                        <p class="text-[12px] font-bold text-zinc-950 uppercase" x-text="'NUTRITION_NODE // ' + (detailedMeal ? detailedMeal.name : '')"></p>
                        <p class="text-[9px] text-zinc-400 uppercase mt-3 tracking-widest">Issue_Timestamp</p>
                        <p class="text-[10px] font-bold text-zinc-950">{{ now()->format('d.m.Y // H:i:s') }}</p>
                    </div>
                </div>
            </div>

            <!-- Macro Matrix -->
            <div class="grid grid-cols-4 gap-4 pb-8 border-b border-zinc-100">
                <div class="space-y-1">
                    <p class="text-[7px] text-zinc-400 uppercase">Total_Kcal</p>
                    <p class="text-lg font-bold text-cyan-600 font-mono" x-text="detailedMeal ? detailedMeal.calories : 0"></p>
                </div>
                <div class="space-y-1">
                    <p class="text-[7px] text-zinc-400 uppercase">Protein_Yield</p>
                    <p class="text-lg font-bold text-zinc-950 font-mono" x-text="(detailedMeal ? detailedMeal.protein : 0) + 'g'"></p>
                </div>
                <div class="space-y-1">
                    <p class="text-[7px] text-zinc-400 uppercase">Carb_Density</p>
                    <p class="text-lg font-bold text-zinc-950 font-mono" x-text="(detailedMeal ? detailedMeal.carbs : 0) + 'g'"></p>
                </div>
                <div class="space-y-1">
                    <p class="text-[7px] text-zinc-400 uppercase">Fat_Matrix</p>
                    <p class="text-lg font-bold text-emerald-600 font-mono" x-text="(detailedMeal ? detailedMeal.fats : 0) + 'g'"></p>
                </div>
            </div>

            <!-- Method/Details -->
            <template x-if="detailedMeal && detailedMeal.details">
                <div class="space-y-4">
                    <h4 class="text-[8px] font-bold uppercase tracking-[0.2em] text-zinc-400">Preparation_Matrix</h4>
                    <div class="bg-zinc-50 p-6 border-l-2 border-cyan-100/50">
                        <div class="v3-editor-matrix text-[10px] text-zinc-700 font-sans leading-relaxed" x-html="renderInstructions(detailedMeal.details)"></div>
                    </div>
                </div>
            </template>
        </div>

        <footer class="p-6 bg-zinc-50 border-t border-zinc-100 flex justify-end border-none">
            <button @click="showMealModal = false" 
                    class="px-8 py-3 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                Close_Report
            </button>
        </footer>
    </div>
</div>