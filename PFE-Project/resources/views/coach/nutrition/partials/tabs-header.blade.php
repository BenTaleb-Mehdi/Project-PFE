    <!-- Tabs Header (Maquette Spec) -->
    <div class="mb-10 flex flex-col md:flex-row md:justify-between md:items-end gap-6 font-sans border-b border-zinc-100 pb-4">
        <div class="flex space-x-8">
            <button @click="activeTab = 'meals'" 
                    :class="activeTab === 'meals' ? 'text-cyan-600 border-cyan-600' : 'text-zinc-400 border-transparent'"
                    class="text-[10px] font-bold uppercase tracking-widest border-b-2 pb-2 transition-all hover:text-cyan-600 font-mono">
                Meal Creator
            </button>
            <button @click="activeTab = 'programs'" 
                    :class="activeTab === 'programs' ? 'text-cyan-600 border-cyan-600' : 'text-zinc-400 border-transparent'"
                    class="text-[10px] font-bold uppercase tracking-widest border-b-2 pb-2 transition-all hover:text-cyan-600 font-mono">
                Program Manager
            </button>
        </div>
        <div x-show="activeTab === 'programs'" class="flex gap-4">
            <a href="{{ route('coach.nutrition.programs.export') }}" 
               class="px-6 py-3 border border-zinc-200 text-zinc-600 text-[10px] uppercase font-bold tracking-widest hover:bg-zinc-50 transition-all font-mono flex items-center gap-x-2">
                <i data-lucide="download" class="size-3"></i>
                <span>Export Registry</span>
            </a>
            <button @click="programView === 'list' ? resetProtocol() : programView = 'list'" 
                    class="px-6 py-3 bg-zinc-950 text-white text-[10px] uppercase font-bold tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] font-mono flex items-center gap-x-2">
                <i :data-lucide="programView === 'list' ? 'plus' : 'list-ordered'" class="size-3"></i>
                <span x-text="programView === 'list' ? 'Create New Protocol' : 'Return to Registry'"></span>
            </button>
        </div>
    </div>
