<!-- History Table (Desktop) -->
<div class="ag-card bg-white border border-zinc-200 overflow-hidden hidden md:block">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse font-mono">
            <thead class="bg-zinc-50 border-b border-zinc-200 text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                <tr>
                    <th class="px-6 py-4">Protocol ID</th>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Meal Nodes</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100 uppercase text-[10px]">
                @forelse($programData['all_programs'] as $program)
                    <!-- Main Row -->
                    <tr @click="toggleExpand({{ $program->id }})" 
                        class="group hover:bg-zinc-50 transition-colors cursor-pointer border-b border-zinc-100 last:border-0">
                        <td class="px-6 py-4 text-zinc-400">#{{ $program->id }}</td>
                        <td class="px-6 py-4 font-bold text-zinc-900">{{ $program->title }}</td>
                        <td class="px-6 py-4 text-zinc-500">{{ $program->items_count }} Slots</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">Status: Success Sync</span>
                                <span class="text-[10px] font-mono font-bold text-cyan-600 uppercase tracking-widest">PROFILE_SYNCED // Record_Modified</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="text-zinc-300 transition-all duration-300 transform"
                                 :class="expandedIds.includes({{ $program->id }}) ? 'rotate-180 text-cyan-600' : 'group-hover:text-zinc-950'">
                                <i data-lucide="chevron-down" class="h-4 w-4 ml-auto"></i>
                            </div>
                        </td>
                    </tr>

                    <!-- Expanded Detail Row -->
                    <tr x-show="expandedIds.includes({{ $program->id }})" x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-zinc-50/50 border-b border-zinc-100">
                        <td colspan="5" class="px-0 py-0">
                            <div class="p-4 sm:p-8 border-t border-dashed border-zinc-200">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-12 text-left">
                                    <!-- Meal Matrix -->
                                    <div>
                                        <div class="flex justify-between items-center mb-4">
                                            <h5 class="text-[8px] font-bold text-zinc-400 uppercase tracking-[0.2em]">Meal Matrix Sequence</h5>
                                            <span class="text-[8px] font-mono text-cyan-600 uppercase">{{ $program->items_count }} Sequences Logged</span>
                                        </div>
                                        <div class="ag-card bg-white border border-zinc-200 overflow-hidden shadow-sm">
                                            @if($program->items_count > 0)
                                                <table class="w-full text-left text-[9px]">
                                                    <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-400 uppercase font-bold">
                                                        <tr>
                                                            <th class="px-4 py-3 font-mono">Seq</th>
                                                            <th class="px-4 py-3">Item Label</th>
                                                            <th class="px-4 py-3 text-right">Kcal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-zinc-100">
                                                        @foreach($program->items as $item)
                                                            <tr class="hover:bg-cyan-50/30 transition-colors">
                                                                <td class="px-4 py-2.5 font-bold text-zinc-400 font-mono">{{ $item->meal->category->name ?? 'Meal' }}</td>
                                                                <td class="px-4 py-2.5 text-zinc-900 font-medium">{{ $item->meal->name ?? 'N/A' }}</td>
                                                                <td class="px-4 py-2.5 text-right font-bold text-cyan-700 font-mono">{{ $item->meal->calories ?? 0 }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <div class="p-8 text-center bg-zinc-50/50">
                                                    <p class="text-[10px] font-mono text-zinc-400 uppercase italic">No Meal Data Sequenced</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Macro Distribution -->
                                    <div>
                                        <h5 class="text-[8px] font-bold text-zinc-400 uppercase tracking-[0.2em] mb-4">Macro Distribution Archive</h5>
                                        @php
                                            $totalP = $program->items->sum(fn($i) => $i->meal->protein ?? 0);
                                            $totalC = $program->items->sum(fn($i) => $i->meal->carbs ?? 0);
                                            $totalF = $program->items->sum(fn($i) => $i->meal->fats ?? 0);
                                        @endphp
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="ag-card bg-white p-4 border border-zinc-200 text-center hover:border-emerald-200 transition-colors">
                                                <p class="text-[8px] text-zinc-400 uppercase tracking-widest mb-1">Protein</p>
                                                <p class="text-lg sm:text-xl font-mono font-bold text-cyan-700">{{ $totalP }}<span class="text-[8px] ml-0.5">G</span></p>
                                            </div>
                                            <div class="ag-card bg-white p-4 border border-zinc-200 text-center hover:border-cyan-200 transition-colors">
                                                <p class="text-[8px] text-zinc-400 uppercase tracking-widest mb-1">Carbs</p>
                                                <p class="text-lg sm:text-xl font-mono font-bold text-cyan-700">{{ $totalC }}<span class="text-[8px] ml-0.5">G</span></p>
                                            </div>
                                            <div class="ag-card bg-white p-4 border border-zinc-200 text-center hover:border-orange-200 transition-colors">
                                                <p class="text-[8px] text-zinc-400 uppercase tracking-widest mb-1">Fats</p>
                                                <p class="text-lg sm:text-xl font-mono font-bold text-cyan-700">{{ $totalF }}<span class="text-[8px] ml-0.5">G</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-zinc-300 uppercase tracking-[0.3em] text-[8px] font-mono">
                            NODES NULL // NO HISTORY DETECTED
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
</div>
</div>
