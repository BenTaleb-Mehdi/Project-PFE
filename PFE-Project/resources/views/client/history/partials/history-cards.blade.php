<!-- History Cards (Mobile) -->
<div class="md:hidden space-y-3">
    @forelse($programData['all_programs'] as $program)
        <div @click="toggleExpand({{ $program->id }})" class="ag-card bg-white p-4 border border-zinc-200 cursor-pointer space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-mono text-zinc-400">#{{ $program->id }}</span>
                <div class="flex flex-col">
                    <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">Status: Success Sync</span>
                    <span class="text-[10px] font-mono font-bold text-cyan-600 uppercase tracking-widest">PROFILE_SYNCED // Record_Modified</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-zinc-900 uppercase">{{ $program->title }}</span>
                <span class="text-[10px] text-zinc-500 font-mono">{{ $program->items_count }} Slots</span>
            </div>
            <div x-show="expandedIds.includes({{ $program->id }})" x-cloak class="pt-3 border-t border-dashed border-zinc-200 mt-2 space-y-4">
                <div>
                    <h5 class="text-[8px] font-bold text-zinc-400 uppercase tracking-[0.2em] mb-3">Meal Matrix Sequence</h5>
                    <div class="space-y-2">
                        @foreach($program->items as $item)
                            <div class="flex justify-between items-center bg-zinc-50 p-2 text-[9px]">
                                <span class="font-bold text-zinc-400 font-mono">{{ $item->meal->category->name ?? 'Meal' }}</span>
                                <span class="text-zinc-900">{{ $item->meal->name ?? 'N/A' }}</span>
                                <span class="font-bold text-cyan-700 font-mono">{{ $item->meal->calories ?? 0 }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @php
                    $totalP = $program->items->sum(fn($i) => $i->meal->protein ?? 0);
                    $totalC = $program->items->sum(fn($i) => $i->meal->carbs ?? 0);
                    $totalF = $program->items->sum(fn($i) => $i->meal->fats ?? 0);
                @endphp
                <div class="grid grid-cols-3 gap-2">
                    <div class="bg-white p-2 border text-center">
                        <p class="text-[7px] text-zinc-400 uppercase">P</p>
                        <p class="text-sm font-bold text-cyan-700">{{ $totalP }}g</p>
                    </div>
                    <div class="bg-white p-2 border text-center">
                        <p class="text-[7px] text-zinc-400 uppercase">C</p>
                        <p class="text-sm font-bold text-cyan-700">{{ $totalC }}g</p>
                    </div>
                    <div class="bg-white p-2 border text-center">
                        <p class="text-[7px] text-zinc-400 uppercase">F</p>
                        <p class="text-sm font-bold text-cyan-700">{{ $totalF }}g</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end pt-1 border-t border-zinc-100">
                <div class="text-zinc-300 transition-transform" :class="expandedIds.includes({{ $program->id }}) ? 'rotate-180 text-cyan-600' : ''">
                    <i data-lucide="chevron-down" class="h-4 w-4"></i>
                </div>
            </div>
        </div>
    @empty
        <div class="p-12 text-center text-zinc-300 uppercase tracking-[0.3em] text-[8px] font-mono border border-dashed border-zinc-200 bg-white">
            NODES NULL // NO HISTORY DETECTED
        </div>
    @endforelse
</div>
