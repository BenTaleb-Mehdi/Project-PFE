<div class="space-y-10">
    <div class="flex items-center justify-between border-b border-zinc-100 pb-3">
        <h4 class="text-[10px] font-mono font-bold uppercase tracking-[0.3em] text-zinc-400">Daily Sequence</h4>
        <div class="flex items-center space-x-2 text-zinc-200">
            <span class="text-[8px] font-mono uppercase font-bold tracking-widest">Mark V3.0</span>
            <i data-lucide="list-ordered" class="size-4"></i>
        </div>
    </div>
    
    <div class="relative">
        <!-- Timeline Connecting Line -->
        <div class="absolute left-[20px] top-4 bottom-4 w-px bg-zinc-200 hidden md:block"></div>

        <div class="space-y-8">
            @foreach($programData['meals'] as $meal)
                <div @click="selectedMeal = {{ json_encode($meal) }}; detailModalOpen = true" 
                     class="group relative flex flex-col md:flex-row md:items-center gap-8 cursor-pointer">
                    
                    <!-- Timeline Dot -->
                    <div class="hidden md:flex absolute left-0 w-10 h-10 items-center justify-center bg-white z-10">
                        <div class="h-3 w-3 bg-zinc-200 group-hover:bg-cyan-600 group-hover:scale-125 transition-all duration-300"></div>
                    </div>

                    <!-- Time Indicator -->
                    <div class="md:ml-16 min-w-[100px]">
                        <span class="text-[10px] font-mono font-bold text-zinc-400 group-hover:text-cyan-700 transition-colors uppercase tracking-widest">{{ $meal['time'] }} HRS</span>
                    </div>

                    <!-- Meal Card (Timeline Content) -->
                    <div class="flex-1 ag-card p-6 md:p-8 bg-white hover:border-cyan-600 transition-all flex flex-col md:flex-row md:items-center justify-between shadow-sm hover:shadow-xl hover:-translate-y-1 duration-300">
                        <div class="flex items-center gap-6">
                            <div class="h-12 w-12 bg-zinc-50 ag-border flex items-center justify-center text-zinc-300 group-hover:bg-cyan-50 group-hover:text-cyan-700 transition-colors">
                                <i data-lucide="utensils" class="size-5"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="text-[8px] font-mono font-bold text-zinc-400 uppercase tracking-widest">{{ $meal['cat'] }}</span>
                                    <span class="h-px w-3 bg-zinc-200"></span>

                                </div>
                                <h4 class="text-lg font-mono font-bold text-zinc-900 uppercase tracking-tighter group-hover:text-cyan-700 transition-colors">
                                    {{ str_replace('_', ' ', $meal['menu']) }}
                                </h4>
                            </div>
                        </div>

                        <div class="mt-4 md:mt-0 flex items-center gap-8">
                            <div class="text-right">
                                <p class="text-xl font-mono font-bold text-zinc-900 tracking-tighter">{{ $meal['kcal'] }}</p>
                                <p class="text-[7px] font-mono text-zinc-400 font-bold uppercase tracking-widest">Kcal Output</p>
                            </div>
                            <div class="h-10 w-10 ag-border flex items-center justify-center text-zinc-200 group-hover:text-cyan-600 group-hover:bg-cyan-50 transition-all">
                                <i data-lucide="chevron-right" class="size-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
