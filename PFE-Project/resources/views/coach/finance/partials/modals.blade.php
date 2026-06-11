<!-- Modals -->

<!-- Add Payment Modal -->
<div x-show="isAddPaymentModalOpen" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
    <form action="{{ route('coach.finance.store') }}" method="POST"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 scale-100"
          x-transition:leave-end="opacity-0 translate-y-2"
          @click.outside="isAddPaymentModalOpen = false"
           class="relative bg-white w-full max-w-lg border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] p-4 sm:p-8 font-mono">
        @csrf
        <header class="mb-6 sm:mb-8 font-sans">
            <h2 class="text-xl font-bold tracking-tight uppercase text-zinc-900">Add New Transaction</h2>
            <p class="text-[8px] text-cyan-700 uppercase tracking-widest font-mono mt-1">Pupil Payment Sync V3.0</p>
        </header>
        <div class="space-y-6">
            <!-- Pupil Selection -->
            <div class="space-y-1.5 font-sans relative">
                <label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">Select Pupil</label>
                <input type="hidden" name="client_id" :value="selectedPupil?.id">
                <button type="button" @click.stop="pupilOpen = !pupilOpen"
                        class="w-full flex justify-between items-center text-[10px] p-3 bg-zinc-50 border border-zinc-200 uppercase font-sans text-cyan-700">
                    <!-- FIXED: Added fallback string and safe optional chaining to prevent initialization crashes -->
                    <span x-text="selectedPupil?.name || 'Select Active Pupil...'"></span>
                    <i data-lucide="chevron-down" class="size-4" :class="pupilOpen ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="pupilOpen" @click.away="pupilOpen = false" x-cloak
                     class="absolute z-[120] left-0 right-0 mt-1 bg-white border border-zinc-200 shadow-xl max-h-64 overflow-hidden flex flex-col uppercase font-mono">
                    <!-- Search Box -->
                    <div class="p-3 bg-white border-b border-zinc-200 flex items-center gap-x-2 focus-within:bg-zinc-50/50 transition-all">
                        <i data-lucide="search" class="size-3 text-zinc-400"></i>
                        <input type="text" x-model="pupilSearch" placeholder="Type to filter..."
                               class="w-full bg-transparent border-none focus:ring-0 text-[10px] uppercase font-mono placeholder:text-zinc-300 p-0">
                    </div>

                    <!-- List -->
                    <div class="overflow-y-auto max-h-48 divide-y divide-zinc-50">
                        <template x-for="client in filteredPupils" :key="client.id">
                            <div @click="selectedPupil = { id: client.id, name: client.name }; pupilOpen = false; pupilSearch = ''"
                                 class="px-4 py-3 text-[10px] hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer border-l-2 border-transparent hover:border-cyan-600 transition-all text-zinc-500 font-bold flex justify-between items-center">
                                <span x-text="client.name"></span>
                                <span class="text-[10px] opacity-60 font-bold" x-text="'#' + client.id"></span>
                            </div>
                        </template>
                        <div x-show="filteredPupils.length === 0" class="p-8 text-center text-[8px] text-zinc-400 italic">
                            Search Mismatch // No Pupil Found
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 font-sans">
                <div class="space-y-1.5 font-mono">
                    <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Amount (MAD)</label>
                    <input type="number" name="amount" required class="w-full text-sm p-3 bg-zinc-50 border border-zinc-200 focus:border-cyan-600 outline-none text-cyan-700 font-bold">
                </div>
                <div class="space-y-1.5 font-mono">
                    <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Transaction Date</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600">
                </div>
            </div>

            <div class="space-y-1.5 font-sans">
                <label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">Initial_Status</label>
                <div class="flex space-x-3 uppercase">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="status" value="paid" class="hidden peer" checked>
                        <span class="px-4 py-2 bg-zinc-50 border border-zinc-200 text-[10px] font-bold peer-checked:bg-cyan-50 peer-checked:text-cyan-600 peer-checked:border-cyan-100 transition-all font-mono">_PAID</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="status" value="pending" class="hidden peer">
                        <span class="px-4 py-2 bg-zinc-50 border border-zinc-200 text-[10px] font-bold peer-checked:bg-amber-50 peer-checked:text-amber-600 peer-checked:border-amber-100 transition-all font-mono">_PENDING</span>
                    </label>
                </div>
            </div>

            <div class="flex space-x-4 pt-4 font-sans">
                <button type="submit" class="flex-1 h-11 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center justify-center gap-x-2">
                    <i data-lucide="check" class="size-3"></i>
                    Initialize Payment
                </button>
                <button type="button" @click="isAddPaymentModalOpen = false" class="h-11 px-6 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
            </div>
        </div>
    </form>
</div>

<!-- Edit Transaction Modal -->
<div x-show="isEditModalOpen" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
    <form :action="'{{ route('coach.finance') }}/' + editingTxn?.id" method="POST"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 scale-100"
          x-transition:leave-end="opacity-0 translate-y-2"
          @click.outside="isEditModalOpen = false"
           class="relative bg-white w-full max-w-lg border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] p-4 sm:p-8 font-mono">
        @csrf
        @method('PUT')
        <header class="mb-8 font-sans">
            <h2 class="text-xl font-bold tracking-tight uppercase text-zinc-900">Edit Transaction</h2>
            <p class="text-[8px] text-cyan-700 uppercase tracking-widest font-mono mt-1">Update Fiscal Record // V3.0</p>
        </header>
        <div class="space-y-6">
            <!-- FIXED: Changed x-model map path to query the loaded relationship graph: client -> user -> name -->
            <div class="space-y-1.5 uppercase opacity-60">
                <label class="text-[10px] text-zinc-400 tracking-widest">Client Name</label>
                <input type="text" 
                       readonly
                       disabled
                       :value="editingTxn?.client?.user?.name || 'UNKNOWN PUPIL'" 
                       class="w-full text-[11px] p-3 bg-zinc-100 border border-zinc-200 text-zinc-500 font-mono font-bold tracking-wider select-none cursor-not-allowed outline-none" />
            </div>

            <div class="grid grid-cols-2 gap-4 font-sans uppercase">
                <div class="space-y-1.5 font-mono">
                    <label class="text-[10px] text-zinc-400 tracking-widest">Amount (MAD)</label>
                    <input type="number" name="amount" x-model="editingTxn.amount" required class="w-full text-sm p-3 bg-zinc-50 border border-zinc-200 focus:border-cyan-600 outline-none text-cyan-700 font-bold">
                </div>
                <div class="space-y-1.5 font-mono">
                    <label class="text-[10px] text-zinc-400 tracking-widest">Date</label>
                    <input type="date" name="date" x-model="editingTxn.date" required class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600">
                </div>
            </div>

            <div class="space-y-1.5 font-sans">
                <label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">Current Status</label>
                <div class="flex space-x-3">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="status" value="paid" x-model="editingTxn.status" class="hidden peer">
                        <span class="px-4 py-2 bg-zinc-50 border border-zinc-200 text-[10px] font-bold peer-checked:bg-cyan-50 peer-checked:text-cyan-600 peer-checked:border-cyan-100 transition-all font-mono uppercase">PAID</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="status" value="pending" x-model="editingTxn.status" class="hidden peer">
                        <span class="px-4 py-2 bg-zinc-50 border border-zinc-200 text-[10px] font-bold peer-checked:bg-amber-50 peer-checked:text-amber-600 peer-checked:border-amber-100 transition-all font-mono uppercase">PENDING</span>
                    </label>
                </div>
            </div>

            <div class="flex space-x-4 pt-4 font-sans">
                <button type="submit" class="flex-1 h-11 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,0.1)]">Save Modifications</button>
                <button type="button" @click="isEditModalOpen = false" class="h-11 px-6 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
            </div>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
<div x-show="isDeleteModalOpen" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
    <form :action="'{{ route('coach.finance') }}/' + (txnToDelete ? txnToDelete.id : '')" method="POST"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 scale-100"
          x-transition:leave-end="opacity-0 translate-y-2"
          @click.outside="isDeleteModalOpen = false"
           class="relative bg-white w-full max-w-md border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] p-4 sm:p-8 font-mono text-zinc-900">
        @csrf
        @method('DELETE')
        <div class="flex items-center space-x-4 mb-6">
            <div class="h-10 w-10 bg-red-50 flex items-center justify-center text-red-600 border border-red-100"><i data-lucide="trash-2" class="size-5"></i></div>
            <div>
                <h3 class="text-sm font-bold uppercase tracking-widest">Confirm Deletion</h3>
                <p class="text-[8px] text-zinc-400 uppercase tracking-widest mt-0.5">FISCAL PURGE // RECORD REMOVAL</p>
            </div>
        </div>
        <p class="text-[10px] text-zinc-500 uppercase mb-8 leading-relaxed">
           Purging transaction <span class="font-bold text-zinc-950" x-text="txnToDelete ? '#' + txnToDelete.id : ''"></span> for <span class="font-bold text-zinc-950" x-text="txnToDelete ? txnToDelete.name : ''"></span>. Irreversible.
        </p>
        <div class="flex gap-4 font-sans">
            <button type="submit" class="flex-1 h-11 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">Execute Purge</button>
            <button type="button" @click="isDeleteModalOpen = false" class="px-6 h-11 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
        </div>
    </form>
</div>