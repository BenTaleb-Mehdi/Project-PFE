        <!-- Protocol Builder View -->
        <div x-show="programView === 'create'" class="max-w-4xl mx-auto space-y-8" x-transition>
            <form :action="isEditing ? '{{ route('coach.nutrition.programs.store') }}' : '{{ route('coach.nutrition.programs.store') }}'" 
                  method="POST" 
                  class="ag-card p-10 bg-white relative overflow-hidden">
                @csrf
                <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none">
                    <i data-lucide="cpu" class="size-32"></i>
                </div>

                <input type="hidden" name="id" :value="editingProgramId">

                <div class="flex items-center justify-between mb-12 border-b border-zinc-100 pb-6">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-950" x-text="isEditing ? 'Protocol Editor V3' : 'Timeline Matrix Builder'"></h3>
                        <p class="text-[8px] text-cyan-700 mt-1 uppercase tracking-widest">Operational // Structural Design</p>
                    </div>
                </div>

                <div class="mb-10">
                    <label class="block text-[9px] text-zinc-500 uppercase font-bold tracking-widest mb-3">Protocol Identifier Label</label>
                    <input type="text" name="title" x-model="currentProtocolTitle" placeholder="E.G. SUMMER SHRED PHASE 1" required
                           class="w-full bg-zinc-50 px-5 py-4 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 font-mono text-zinc-950 uppercase tracking-widest shadow-inner rounded-none">
                </div>

                <div class="space-y-4">
                    <label class="block text-[9px] text-zinc-500 uppercase font-bold tracking-widest mb-6">Slot Assignment Matrix</label>
                    @foreach($categories as $cat)
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-4 sm:p-6 bg-zinc-50 border border-zinc-200 hover:border-cyan-500 hover:bg-white transition-all group gap-3">
                            <div class="flex items-center gap-3 sm:gap-6">
                                <div class="h-4 w-1 bg-zinc-300 group-hover:bg-cyan-600 transition-colors shrink-0"></div>
                                <span class="text-[10px] text-zinc-900 font-bold uppercase font-mono">{{ $cat->name }}</span>
                                
                                <input type="hidden" name="items[{{ $loop->index }}][slot]" value="{{ $cat->name }}">
                                <input type="hidden" name="items[{{ $loop->index }}][day]" value="Everyday">
                                <!-- Hidden input for the selected meal id, synced by Alpine -->
                                <input type="hidden" name="items[{{ $loop->index }}][meal_id]" 
                                       :value="protocolItems.find(i => i.slot === '{{ $cat->name }}')?.meal_id">
                            </div>
                            
                            <div class="relative w-full md:w-auto" x-data='{ open: false }'>
                                <button type="button" @click.stop="open = !open" 
                                        class="w-full md:w-auto px-5 py-3 text-[9px] text-cyan-700 font-mono font-bold uppercase border border-zinc-200 bg-white hover:border-cyan-600 transition-all min-w-[200px] flex justify-between items-center"
                                        x-text="getMealName('{{ $cat->name }}')">
                                </button>
                                <div x-show="open" @click.outside="open = false" x-cloak
                                     class="absolute right-0 mt-1 w-72 bg-white border border-zinc-200 z-[120] shadow-2xl max-h-64 overflow-y-auto rounded-none">
                                    <div class="p-2 border-b border-zinc-100 bg-zinc-50 sticky top-0">
                                        <p class="text-[8px] text-zinc-400 uppercase text-center tracking-widest">Select_Module</p>
                                    </div>
                                    @foreach($meals as $m)
                                        <div @click="setMeal('{{ $cat->name }}', {{ $m->id }}); open = false" 
                                             class="px-5 py-3 text-[9px] uppercase font-bold hover:bg-cyan-600 hover:text-white cursor-pointer border-b border-zinc-50 text-zinc-600 transition-colors flex justify-between items-center group/item">
                                            <span>{{ $m->name }}</span>
                                            <span class="text-[7px] opacity-0 group-hover/item:opacity-100 font-mono tracking-tighter">{{ $m->calories }} KCAL</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 pt-8 border-t border-zinc-100 flex justify-end gap-x-4">
                    <button type="button" @click="programView = 'list'" class="px-8 py-4 border border-zinc-200 text-zinc-400 text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-50">Cancel Build</button>
                    <button type="submit" class="px-10 py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.98]">
                        <span x-text="isEditing ? 'Commit Protocol Updates' : 'Initialize Protocol Node'"></span>
                    </button>
                </div>
            </form>
        </div>
