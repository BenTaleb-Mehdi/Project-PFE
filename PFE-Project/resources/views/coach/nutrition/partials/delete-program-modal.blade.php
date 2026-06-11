    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-zinc-950/60 backdrop-blur-sm"
         x-cloak>
        <div @click.outside="showDeleteModal = false" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-2"
             class="bg-white w-full max-w-md shadow-[12px_12px_0px_0px_rgba(0,0,0,0.1)] border border-zinc-200 relative overflow-hidden">
            
            <!-- Warning Header -->
            <div class="h-1 bg-red-500 w-full"></div>
            
            <div class="p-8">
                <div class="flex items-center gap-x-4 mb-6">
                    <div class="size-12 bg-red-50 flex items-center justify-center rounded-none border border-red-100">
                        <i data-lucide="alert-triangle" class="size-6 text-red-500"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-950">Confirm Node Purge</h4>
                        <p class="text-[8px] text-red-600 font-mono uppercase tracking-widest mt-1">Destructive Action // Irreversible</p>
                    </div>
                </div>

                <div class="bg-zinc-50 border border-zinc-100 p-6 mb-8">
                    <p class="text-[10px] text-zinc-400 uppercase tracking-widest mb-2 font-mono">Target Protocol Identity:</p>
                    <p class="text-xs font-bold text-zinc-950 uppercase tracking-widest font-mono" x-text="programToDelete?.title || 'Unknown Protocol'"></p>
                </div>

                <p class="text-[10px] text-zinc-500 leading-relaxed mb-8 font-sans">
                    Warning: You are about to purge this protocol from the master registry. This action will remove all associated matrix data. Confirm system override?
                </p>

                <div class="flex gap-x-4">
                    <button @click="showDeleteModal = false" 
                            class="flex-1 px-6 py-4 border border-zinc-200 text-zinc-400 text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-50 transition-all">
                        Abort Purge
                    </button>
                    <button @click="executeDelete()" 
                            class="flex-1 px-6 py-4 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-red-700 transition-all shadow-[4px_4px_0px_0px_rgba(220,38,38,0.2)]">
                        Confirm Purge
                    </button>
                </div>
            </div>
        </div>
    </div>
