<!-- Detail Modal -->
<div x-show="detailModalOpen" x-cloak
     class="fixed inset-0 z-[100] flex items-center justify-center p-4">
    
    <div @click="detailModalOpen = false" 
         class="absolute inset-0 bg-zinc-950/90 backdrop-blur-xl transition-all"></div>

    <div x-show="detailModalOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-12"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="ag-card bg-white w-full max-w-xl max-h-[85vh] flex flex-col relative z-10 overflow-hidden shadow-[24px_24px_0px_0px_rgba(0,0,0,0.1)]">
        
        <!-- Header: Fixed -->
        <div class="p-6 border-b border-zinc-100 bg-zinc-50/30 flex justify-between items-start shrink-0">
            <div>
                <span class="text-[9px] font-mono text-cyan-700 font-bold uppercase tracking-[0.4em] block mb-2 px-3 py-1 bg-cyan-50 ag-border inline-block" x-text="selectedMeal?.cat + ' PROTOCOL NODE'"></span>
                <h2 class="text-2xl font-mono font-bold text-zinc-900 uppercase tracking-tighter" x-text="selectedMeal?.menu"></h2>
            </div>
            <button @click="detailModalOpen = false" class="h-10 w-10 ag-border flex items-center justify-center text-zinc-400 hover:text-zinc-900 transition-all hover:rotate-90 duration-300">
                <i data-lucide="x" class="size-5"></i>
            </button>
        </div>

        <!-- Body: Scrollable Area -->
        <div class="p-6 overflow-y-auto flex-1 progress-scrollbar">
            <!-- Macros Grid -->
            <div class="grid grid-cols-4 gap-4 mb-8">
                <div class="p-4 bg-zinc-50 ag-border text-center border-b-4 border-b-cyan-700">
                    <p class="text-[8px] font-mono text-zinc-400 uppercase mb-1">Energy</p>
                    <p class="text-lg font-mono font-bold text-cyan-700" x-text="selectedMeal?.kcal + 'kc'"></p>
                </div>
                <div class="p-4 bg-zinc-50 ag-border text-center border-b-4 border-b-cyan-700">
                    <p class="text-[8px] font-mono text-zinc-400 uppercase mb-1">Protein</p>
                    <p class="text-lg font-mono font-bold text-cyan-700" x-text="selectedMeal?.p + 'g'"></p>
                </div>
                <div class="p-4 bg-zinc-50 ag-border text-center border-b-4 border-b-cyan-700">
                    <p class="text-[8px] font-mono text-zinc-400 uppercase mb-1">Carbs</p>
                    <p class="text-lg font-mono font-bold text-cyan-700" x-text="selectedMeal?.c + 'g'"></p>
                </div>
                <div class="p-4 bg-zinc-50 ag-border text-center border-b-4 border-b-cyan-700">
                    <p class="text-[8px] font-mono text-zinc-400 uppercase mb-1">Fats</p>
                    <p class="text-lg font-mono font-bold text-cyan-700" x-text="selectedMeal?.f + 'g'"></p>
                </div>
            </div>

            <!-- Execution Schema -->
            <div class="bg-zinc-50/50 p-6 ag-border border-dashed">
                <h4 class="text-[10px] font-mono font-bold text-zinc-900 uppercase tracking-[0.4em] mb-4 flex items-center">
                    <i data-lucide="scroll-text" class="size-4 mr-3 text-cyan-600"></i>
                    Execution Schema
                </h4>
                <div class="text-sm font-mono text-zinc-500 leading-relaxed font-sans prose prose-zinc max-w-none" x-html="selectedMeal?.details"></div>
            </div>
        </div>

        <!-- Footer: Fixed -->
        <div class="p-6 bg-zinc-50 border-t border-zinc-100 flex justify-between items-center shrink-0 gap-4">
            <template x-if="!selectedMeal?.is_validated">
                <form action="{{ route('client.meals.validate') }}" method="POST" class="m-0">
                    @csrf
                    <input type="hidden" name="program_item_id" :value="selectedMeal?.id">
                    <button type="submit" 
                            class="px-6 py-3.5 bg-cyan-600 text-white text-[10px] font-mono font-bold uppercase tracking-widest hover:bg-cyan-700 transition-all shadow-[6px_6px_0px_0px_rgba(8,145,178,0.1)] active:scale-95 flex items-center gap-2 whitespace-nowrap">
                        <i data-lucide="check-circle" class="size-4"></i>
                        Validate Node
                    </button>
                </form>
            </template>


            <button @click="detailModalOpen = false" 
                    class="px-6 py-3.5 bg-zinc-950 text-white text-[10px] font-mono font-bold uppercase tracking-[0.2em] hover:bg-black transition-all shadow-[6px_6px_0px_0px_rgba(0,0,0,0.05)] whitespace-nowrap">
                Return to Nexus
            </button>
        </div>
    </div>
</div>