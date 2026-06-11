            <!-- Meal Registry (Relocated & Enhanced) -->
            <div class="ag-card bg-white overflow-hidden border border-zinc-100 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.02)]">
                <div class="p-6 bg-zinc-50 border-b border-zinc-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-x-3">
                        <p class="text-[10px] font-mono text-zinc-950 uppercase font-bold tracking-widest">Meal Registry</p>
                        <span class="text-[8px] bg-cyan-100 text-cyan-700 font-mono px-2 py-0.5" x-text="'COUNT: ' + filteredMeals.length"></span>
                    </div>
                    
                    <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                        <!-- Live Search -->
                        <div class="relative w-full md:w-64">
                            <input type="text" x-model="mealSearch" @input="mealPage = 1" placeholder="Search Registry..." 
                                   class="w-full bg-white border border-zinc-200 px-10 py-2.5 text-[9px] uppercase font-mono tracking-widest focus:outline-none focus:border-cyan-600 rounded-none transition-all placeholder:text-zinc-300">
                            <i data-lucide="search" class="absolute left-3.5 top-3 size-3.5 text-zinc-400"></i>
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="relative w-full md:w-48" x-data="{ open: false }">
                            <button @click.stop="open = !open" 
                                    class="w-full bg-white border border-zinc-200 px-4 py-2.5 text-[9px] uppercase font-mono tracking-widest flex items-center justify-between focus:outline-none focus:border-cyan-600 rounded-none transition-all">
                                <span x-text="mealCategory === 'ALL_CATEGORIES' ? 'ALL_NODES' : mealCategory"></span>
                                <i data-lucide="filter" class="size-3 text-zinc-400"></i>
                            </button>
                            <div x-show="open" @click.outside="open = false" 
                                 class="absolute left-0 mt-1 w-full bg-white border border-zinc-200 z-[110] shadow-xl">
                                <div @click="mealCategory = 'ALL_CATEGORIES'; mealPage = 1; open = false" 
                                     class="px-4 py-2.5 text-[8px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600">
                                    ALL NODES
                                </div>
                                @foreach($categories as $cat)
                                    <div @click="mealCategory = '{{ $cat->name }}'; mealPage = 1; open = false" 
                                         class="px-4 py-2.5 text-[8px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600">
                                        {{ $cat->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="divide-y divide-zinc-50 max-h-[800px] overflow-y-auto">
                    <template x-for="meal in paginatedMeals" :key="meal.id">
                        <div class="p-5 hover:bg-zinc-50/50 transition-all group border-l-2 border-transparent hover:border-cyan-600 cursor-default">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[7px] px-2 py-0.5 bg-zinc-100 text-zinc-500 font-mono uppercase tracking-[0.2em]" x-text="meal.category ? meal.category.name : 'UNCAT'"></span>
                                <div class="text-right">
                                    <span class="text-[10px] font-mono text-zinc-950 font-bold group-hover:text-cyan-700" x-text="meal.calories"></span>
                                    <span class="text-[7px] text-zinc-400 uppercase ml-0.5">kcal</span>
                                </div>
                            </div>
                            <div class="mt-2 mb-3">
                                <div class="text-[9px] text-zinc-400 font-sans line-clamp-2 overflow-hidden opacity-60 normal-case" x-html="renderInstructions(meal.details)"></div>
                            </div>
                            <div class="flex justify-between items-end mt-4 border-t border-zinc-100 pt-3">
                                <div class="flex items-center gap-x-4">
                                    <h4 class="text-[10px] font-bold text-zinc-900 uppercase font-mono tracking-wide" x-text="meal.name"></h4>
                                    <button @click="openMealDetails(meal)" class="text-[8px] text-cyan-600 uppercase font-mono tracking-widest hover:text-cyan-800 transition-colors flex items-center gap-x-1" title="View Intelligence">
                                        <i data-lucide="scan-line" class="size-3"></i> INTELLIGENCE
                                    </button>
                                    <button @click="editMeal(meal)" class="text-[8px] text-zinc-400 uppercase font-mono tracking-widest hover:text-cyan-600 transition-colors flex items-center gap-x-1" title="Modify Node">
                                        <i data-lucide="terminal" class="size-3"></i> EDIT
                                    </button>
                                    <button @click="openDeleteMealModal(meal)" class="text-[8px] text-zinc-300 uppercase font-mono tracking-widest hover:text-red-500 transition-colors flex items-center gap-x-1" title="Purge Node">
                                        <i data-lucide="zap-off" class="size-3"></i> DELETE
                                    </button>
                                </div>
                                <div class="flex gap-x-3">
                                    <div class="flex flex-col items-end">
                                        <span class="text-[6px] text-zinc-300 uppercase">PRO</span>
                                        <span class="text-[8px] font-mono text-cyan-700 font-bold" x-text="meal.protein + 'g'"></span>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-[6px] text-zinc-300 uppercase">CAR</span>
                                        <span class="text-[8px] font-mono text-zinc-950 font-bold" x-text="meal.carbs + 'g'"></span>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-[6px] text-zinc-300 uppercase">FAT</span>
                                        <span class="text-[8px] font-mono text-emerald-600 font-bold" x-text="meal.fats + 'g'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="filteredMeals.length === 0" class="p-20 text-center">
                        <p class="text-[8px] text-zinc-300 uppercase tracking-[0.4em] font-mono">Registry Null // Search Mismatch</p>
                    </div>
                </div>

                <!-- Registry Pagination -->
                <div x-show="mealTotalPages > 1" class="p-4 bg-zinc-50 border-t border-zinc-100 flex items-center justify-between">
                    <button @click="mealPage = Math.max(1, mealPage - 1)" 
                            :disabled="mealPage === 1"
                            class="px-4 py-2 text-[8px] font-bold uppercase tracking-[0.2em] font-mono border border-zinc-200 bg-white hover:bg-zinc-50 disabled:opacity-30 disabled:cursor-not-allowed transition-all">
                        PREV NODE
                    </button>
                    <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest" x-text="'NODE GATE: ' + mealPage + ' / ' + mealTotalPages"></span>
                    <button @click="mealPage = Math.min(mealTotalPages, mealPage + 1)" 
                            :disabled="mealPage === mealTotalPages"
                            class="px-4 py-2 text-[8px] font-bold uppercase tracking-[0.2em] font-mono border border-zinc-200 bg-white hover:bg-zinc-50 disabled:opacity-30 disabled:cursor-not-allowed transition-all">
                        NEXT NODE
                    </button>
                </div>
            </div>
