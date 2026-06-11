<!-- Modals -->

<!-- Add/Edit Client Modal (The Maquette Design) -->
<div x-show="showClientModal" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
    <form :action="isEditing ? '{{ route('coach.clients.index') }}/' + editingClientId : '{{ route('coach.clients.store') }}'"
          method="POST"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 scale-100"
          x-transition:leave-end="opacity-0 translate-y-2"
          @click.outside="showClientModal = false"
           class="relative bg-white border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] w-full max-w-lg p-4 sm:p-8">
        @csrf
        <template x-if="isEditing">
            @method('PUT')
        </template>

        <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-900 mb-6" x-text="isEditing ? 'Edit Pupil Profile' : 'Onboard New Pupil'"></h3>
        <div class="space-y-4 font-mono">
            <div class="space-y-1">
                <label class="text-[8px] uppercase text-zinc-400">Identity Name</label>
                <input type="text" name="name" x-model="newClient.name" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 uppercase" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[8px] uppercase text-zinc-400">Email Access</label>
                    <input type="email" name="email" x-model="newClient.email" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600" required>
                </div>
                <div class="space-y-1">
                    <label class="text-[8px] uppercase text-zinc-400">Phone Node</label>
                    <input type="tel" name="phone_number" x-model="newClient.phone_number" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[8px] uppercase text-zinc-400">Mass (KG)</label>
                    <input type="number" step="0.1" name="current_weight" x-model="newClient.current_weight" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 text-cyan-700">
                </div>
                <div class="space-y-1">
                    <label class="text-[8px] uppercase text-zinc-400">Target (KG)</label>
                    <input type="number" step="0.1" name="target_goal" x-model="newClient.target_goal" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[8px] uppercase text-zinc-400">Height (CM)</label>
                    <input type="number" name="height" x-model="newClient.height" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 text-cyan-700">
                </div>
                <div class="space-y-1">
                    <label class="text-[8px] uppercase text-zinc-400">Status Node</label>
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open" @click.away="open = false"
                                class="w-full flex justify-between items-center bg-zinc-50 border border-zinc-200 px-4 py-3 text-[10px] font-mono uppercase tracking-widest text-zinc-900 focus:border-cyan-600 transition-colors">
                            <div class="flex items-center gap-2">
                                <div class="h-1.5 w-1.5 rounded-full"
                                     :class="{
                                        'bg-cyan-500': newClient.status === 'active',
                                        'bg-amber-500': newClient.status === 'pending',
                                        'bg-zinc-400': newClient.status === 'inactive'
                                     }"></div>
                                <span x-text="newClient.status"></span>
                            </div>
                            <i data-lucide="chevron-down" class="size-3 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak
                             class="absolute top-full left-0 right-0 z-[110] bg-white border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.05)] mt-1">
                            <div class="py-1">
                                <template x-for="opt in ['active', 'pending', 'inactive']">
                                    <button type="button" @click="newClient.status = opt; open = false"
                                            class="w-full text-left px-4 py-2.5 text-[10px] font-mono uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 transition-all flex items-center justify-between"
                                            :class="newClient.status === opt ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500'">
                                        <div class="flex items-center gap-2">
                                            <div class="h-1 w-1 rounded-full"
                                                 :class="{
                                                    'bg-cyan-500': opt === 'active',
                                                    'bg-amber-500': opt === 'pending',
                                                    'bg-zinc-400': opt === 'inactive'
                                                 }"></div>
                                            <span x-text="opt"></span>
                                        </div>
                                        <i data-lucide="check" class="size-2.5" x-show="newClient.status === opt"></i>
                                    </button>
                                </template>
                            </div>
                        </div>
                        <input type="hidden" name="status" :value="newClient.status">
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center justify-center gap-x-2">
                <i data-lucide="check" class="size-3" x-show="isEditing"></i>
                <i data-lucide="plus" class="size-3" x-show="!isEditing"></i>
                <span x-text="isEditing ? 'Save Profile Modifications' : 'Onboard Pupil'"></span>
            </button>
        </div>
    </form>
</div>

<!-- Assignment Modal (The Wizard) -->
<div x-show="showAssignModal" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
    <form :action="'{{ route('coach.clients.index') }}/' + (selectedClient ? selectedClient.id : '') + '/assign'"
          method="POST"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 scale-100"
          x-transition:leave-end="opacity-0 translate-y-2"
          @click.outside="showAssignModal = false"
           class="relative bg-white border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] w-full max-w-md p-4 sm:p-8">
        @csrf

        <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-900 mb-2">Program Assignment Wizard</h3>
        <p class="text-[10px] text-cyan-600 uppercase font-mono mb-6" x-text="'Target: ' + (selectedClient ? selectedClient.user.name : '')"></p>

        <div class="space-y-6">
            <!-- Protocol Selection Dropdown -->
            <div>
                <label class="block text-[10px] text-zinc-900 uppercase font-bold tracking-widest mb-2 font-mono">Select Nutrition Protocol</label>
                <div class="relative">
                    <button type="button" @click.stop="protocolOpen = !protocolOpen"
                            class="w-full bg-zinc-50 px-4 py-3 text-[10px] flex items-center justify-between border border-zinc-200 outline-none focus:border-cyan-600 transition-colors uppercase font-mono text-cyan-700 rounded-none">
                        <span x-text="selectedProtocol.title"></span>
                        <i data-lucide="chevron-down" class="size-3 transition-transform" :class="protocolOpen ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="protocolOpen" @click.outside="protocolOpen = false" x-cloak
                         class="absolute left-0 mt-1 w-full bg-white border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.05)] z-[110] flex flex-col">

                        <!-- Search Box -->
                        <div class="p-3 bg-white border-b border-zinc-200 flex items-center gap-x-2 focus-within:bg-zinc-50/50 transition-all">
                            <i data-lucide="search" class="size-3 text-zinc-400"></i>
                            <input type="text" x-model="protocolSearch" placeholder="Type to filter..."
                                   class="w-full bg-transparent border-none focus:ring-0 text-[10px] uppercase font-mono placeholder:text-zinc-300 p-0">
                        </div>

                        <div class="max-h-48 overflow-y-auto divide-y divide-zinc-50">
                            <template x-for="protocol in filteredProtocols" :key="protocol.id">
                                <div @click="selectedProtocol = { id: protocol.id, title: protocol.title }; protocolOpen = false; protocolSearch = ''"
                                     class="px-4 py-3 text-[10px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer border-l-2 border-transparent hover:border-cyan-600 flex items-center justify-between font-mono"
                                     :class="selectedProtocol.id === protocol.id ? 'border-l-cyan-600 bg-zinc-50 text-cyan-600' : ''">
                                    <span x-text="protocol.title"></span>
                                    <template x-if="protocol.id == 1">
                                        <span class="text-[8px] bg-cyan-50 px-1 border border-cyan-100">LATEST</span>
                                    </template>
                                </div>
                            </template>
                            <div x-show="filteredProtocols.length === 0" class="p-8 text-center text-[8px] text-zinc-400 italic font-mono uppercase">
                                Search Mismatch // No Protocol Found
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="program_id" :value="selectedProtocol.id" required>
                </div>
            </div>

            <div>
                <label class="block text-[10px] text-zinc-900 uppercase font-bold tracking-widest mb-2 font-mono">Duration Protocol (Weeks)</label>
                <input type="number" name="duration_weeks" x-model="durationWeeks" min="1" max="52"
                       class="w-full bg-zinc-50 px-4 py-3 text-[10px] uppercase border border-zinc-200 outline-none focus:border-cyan-600 transition-colors font-mono text-cyan-700">
            </div>

            <button type="submit"
                    class="w-full py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center justify-center gap-x-2">
                <i data-lucide="link" class="size-3"></i>
                Link Protocol to Client
            </button>
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
    <form :action="'{{ route('coach.clients.index') }}/' + (clientToDelete ? clientToDelete.id : '')"
          method="POST"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 scale-100"
          x-transition:leave-end="opacity-0 translate-y-2"
          @click.outside="isDeleteModalOpen = false"
           class="relative bg-white w-full max-w-sm border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] p-4 sm:p-8 text-center">
        @csrf
        @method('DELETE')
        <div class="size-12 bg-red-50 text-red-600 border border-red-100 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="alert-octagon" class="size-6"></i>
        </div>
        <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-950 mb-2">Confirm Deactivation</h3>
        <p class="text-[10px] text-zinc-400 uppercase font-mono mb-8">Revoking access for <span class="text-zinc-950 font-bold" x-text="clientToDelete ? clientToDelete.name : ''"></span>. Irreversible action.</p>
        <div class="flex gap-4 font-sans">
            <button type="button" @click="isDeleteModalOpen = false" class="flex-1 py-3 border border-zinc-200 text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-50 transition-all">Cancel</button>
            <button type="submit" class="flex-1 py-3 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-red-700 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">Execute Purge</button>
        </div>
    </form>
</div>

<!-- Image Preview Modal -->
<div x-show="previewImage" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-zinc-950/80 backdrop-blur-md">
    <div @click.outside="previewImage = null" class="relative max-w-3xl max-h-[85vh] overflow-hidden bg-white border border-zinc-200 shadow-2xl p-2 flex flex-col items-center">
        <button type="button" @click="previewImage = null" class="absolute top-4 right-4 h-10 w-10 bg-zinc-950 text-white hover:bg-black transition-colors flex items-center justify-center font-bold font-mono">X</button>
        <img :src="previewImage" class="max-w-full max-h-[80vh] object-contain">
    </div>
</div>
