        <!-- List View -->
        <div x-show="programView === 'list'" class="ag-card bg-white overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div class="flex items-center gap-x-3">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Protocol Registry Control</h3>
                    <span class="text-[8px] bg-cyan-100 text-cyan-700 font-mono px-2 py-0.5" x-text="'COUNT: ' + filteredPrograms.length"></span>
                </div>
                <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                    <!-- Live Search -->
                    <div class="relative w-full md:w-80">
                        <input type="text" x-model="programSearch" placeholder="Filter Protocols..." 
                               class="w-full bg-white border border-zinc-200 px-10 py-2.5 text-[10px] uppercase font-mono tracking-widest focus:outline-none focus:border-cyan-600 rounded-none">
                        <i data-lucide="search" class="absolute left-3.5 top-3 size-3.5 text-zinc-400"></i>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="relative w-full md:w-48" x-data="{ open: false }">
                        <button @click.stop="open = !open" 
                                class="w-full bg-white border border-zinc-200 px-4 py-2.5 text-[10px] uppercase font-mono tracking-widest flex items-center justify-between focus:outline-none focus:border-cyan-600 rounded-none transition-all">
                            <span x-text="programFilter === 'ALL_PROTOCOLS' ? 'ALL_STATUSES' : programFilter"></span>
                            <i data-lucide="filter" class="size-3 text-zinc-400"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" 
                             class="absolute left-0 mt-1 w-full bg-white border border-zinc-200 z-[110] shadow-xl">
                            <div @click="programFilter = 'ALL_PROTOCOLS'; open = false" 
                                 class="px-4 py-2.5 text-[8px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600">
                                ALL STATUSES
                            </div>
                            <div @click="programFilter = 'ACTIVE'; open = false" 
                                 class="px-4 py-2.5 text-[8px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600">
                                ACTIVE (LINKED)
                            </div>
                            <div @click="programFilter = 'UNUSED'; open = false" 
                                 class="px-4 py-2.5 text-[8px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600">
                                UNUSED (DORMANT)
                            </div>
                            <div @click="programFilter = 'HIGH_DENSITY'; open = false" 
                                 class="px-4 py-2.5 text-[8px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600">
                                HIGH DENSITY (5+ MEALS)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Desktop Table -->
            <div class="overflow-x-auto hidden md:block">
                <table class="w-full text-left text-[10px]">
                    <thead class="bg-white border-b border-zinc-100 text-zinc-400 uppercase tracking-widest font-bold">
                        <tr>
                            <th class="px-8 py-5">Protocol Matrix Identity</th>
                            <th class="px-8 py-5">Meal Slots</th>
                            <th class="px-8 py-5 text-center">Associated Clients</th>
                            <th class="px-8 py-5">Date Modified</th>
                            <th class="px-8 py-5 text-right">Action Nodes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 uppercase">
                        <template x-for="program in filteredPrograms" :key="program.id">
                            <tr class="hover:bg-cyan-50/20 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-x-3">
                                        <div class="h-1.5 w-1.5 bg-cyan-600"></div>
                                        <span class="font-bold text-zinc-950 group-hover:text-cyan-700 transition-colors" x-text="program.title"></span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-zinc-500 font-mono" x-text="program.items_count + ' Units'"></td>
                                <td class="px-8 py-5 text-center">
                                    <span class="text-[10px] bg-zinc-100 text-zinc-950 font-mono px-3 py-1 font-bold border border-zinc-200" x-text="program.clients_count + ' ACTIVE'"></span>
                                </td>
                                <td class="px-8 py-5 text-zinc-400 font-mono" x-text="program.updated_at ? program.updated_at.split('T')[0] : 'N/A'"></td>
                                 <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end gap-x-6">
                                        <button @click="openDetails(program)" class="text-zinc-400 hover:text-cyan-600 transition-all" title="View Intelligence Report"><i data-lucide="layout-list" class="size-3.5"></i></button>
                                        <button @click="editProgram(program)" class="text-zinc-400 hover:text-cyan-600 transition-all"><i data-lucide="terminal" class="size-3.5"></i></button>
                                        <button @click="openDeleteModal(program)" class="text-zinc-300 hover:text-red-500 transition-all">
                                             <i data-lucide="zap-off" class="size-3.5"></i>
                                         </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card Layout -->
            <div class="md:hidden divide-y divide-zinc-100">
                <template x-for="program in filteredPrograms" :key="program.id">
                    <div class="p-4 hover:bg-zinc-50 transition-colors space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-x-2">
                                <div class="h-1.5 w-1.5 bg-cyan-600"></div>
                                <span class="font-bold text-xs text-zinc-950 uppercase" x-text="program.title"></span>
                            </div>
                            <span class="text-[10px] bg-zinc-100 text-zinc-950 font-mono px-2 py-0.5 font-bold" x-text="program.clients_count + ' ACTIVE'"></span>
                        </div>
                        <div class="flex items-center justify-between text-[9px] text-zinc-500 font-mono">
                            <span x-text="program.items_count + ' Units'"></span>
                            <span x-text="program.updated_at ? program.updated_at.split('T')[0] : 'N/A'"></span>
                        </div>
                        <div class="flex justify-end gap-x-4 pt-1 border-t border-zinc-50">
                            <button @click="openDetails(program)" class="text-zinc-400 hover:text-cyan-600"><i data-lucide="layout-list" class="size-3.5"></i></button>
                            <button @click="editProgram(program)" class="text-zinc-400 hover:text-cyan-600"><i data-lucide="terminal" class="size-3.5"></i></button>
                            <button @click="openDeleteModal(program)" class="text-zinc-300 hover:text-red-500"><i data-lucide="zap-off" class="size-3.5"></i></button>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="filteredPrograms.length === 0" class="px-8 py-20 text-center">
                <div class="flex flex-col items-center gap-3">
                    <i data-lucide="search-x" class="size-8 text-zinc-200"></i>
                    <p class="text-[8px] text-zinc-300 uppercase tracking-[0.4em] font-mono">NODES_NULL // NO_MATCH_DETECTED</p>
                    <button @click="programSearch = ''; programFilter = 'ALL_PROTOCOLS'" 
                            class="text-[8px] text-cyan-600 uppercase font-mono tracking-widest hover:text-cyan-800 transition-colors">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
