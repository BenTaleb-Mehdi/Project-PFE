@extends('layouts.dashboard')

@section('title', 'Client Registry')
@section('header_title', 'Client_Registry')
@section('header_subtitle', 'Pupil_Database // Assignment_Protocol')

@section('content')
<div x-data="{ 
    showAssignModal: false,
    selectedClient: null,
    showClientModal: false,
    isEditing: false,
    editingClientId: null,
    newClient: { name: '', email: '', phone_number: '', target_goal: '', current_weight: '', height: '', status: 'active' },
    
    openModal(client = null) {
        if (client) {
            this.isEditing = true;
            this.editingClientId = client.id;
            this.newClient = { 
                id: client.id,
                name: client.user.name, 
                email: client.user.email, 
                phone_number: client.phone_number, 
                target_goal: client.target_goal, 
                current_weight: client.current_weight, 
                height: client.height, 
                status: client.status 
            };
        } else {
            this.isEditing = false;
            this.editingClientId = null;
            this.newClient = { name: '', email: '', phone_number: '', target_goal: '', current_weight: '', height: '', status: 'active' };
        }
        this.showClientModal = true;
    },

    isDeleteModalOpen: false,
    clientToDelete: null,
    confirmDelete(client) {
        this.clientToDelete = client;
        this.isDeleteModalOpen = true;
    },

    searchQuery: '{{ request('search') }}',
    filterStatus: 'ALL_STATUSES',
    expandedClientIds: [],
}">
    <!-- Action Bar -->
    <div class="mb-10 lg:flex lg:justify-end font-mono">
        <button @click="openModal()"
                class="px-6 py-3 bg-zinc-950 text-white text-[10px] uppercase font-bold tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center gap-x-2">
            <i data-lucide="plus" class="size-3"></i>
            Onboard_New_Pupil
        </button>
    </div>

    <!-- Discovery Bar -->
    <div class="ag-card p-4 bg-white mb-6 border border-zinc-200 flex flex-col md:flex-row gap-4 items-center">
        <form action="{{ route('coach.clients.index') }}" method="GET" class="relative flex-1 w-full text-zinc-900">
            <input type="text" name="search" x-model="searchQuery" placeholder="Search_Pupils (Name, ID)..." 
                   class="w-full bg-zinc-50 border border-zinc-200 px-10 py-2.5 text-[10px] font-mono uppercase tracking-widest focus:outline-none focus:border-cyan-600 transition-colors">
            <div class="absolute left-3.5 top-3 text-zinc-400">
                <i data-lucide="search" class="size-3.5"></i>
            </div>
            <button type="submit" class="hidden"></button>
        </form>

        <!-- Filter Dropdown: Status -->
        <div class="relative w-full md:w-64" x-data="{ open: false }">
            <button @click="open = !open" 
                    @click.away="open = false"
                    class="w-full flex justify-between items-center bg-zinc-50 border border-zinc-200 px-4 py-2.5 text-[10px] font-mono uppercase tracking-widest text-zinc-500 hover:text-zinc-900 transition-colors">
                <span x-text="filterStatus.replace('_', ' ')"></span>
                <i data-lucide="chevron-down" class="size-3 transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" x-cloak
                 class="absolute right-0 mt-1 z-[100] bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-[256px]">
                <div class="py-1">
                    <template x-for="opt in ['ALL_STATUSES', 'Active', 'Pending']">
                        <button @click="filterStatus = opt; open = false" 
                                class="w-full text-left px-4 py-2 text-[10px] font-mono uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 transition-all font-sans"
                                :class="filterStatus === opt ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500'">
                            <span x-text="opt.replace('_', ' ')"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Client List -->
    <div class="grid grid-cols-1 gap-4 font-sans">
        @foreach($clients as $client)
            <div class="ag-card bg-white overflow-hidden group transition-all"
                 :class="expandedClientIds.includes({{ $client->id }}) ? 'border-cyan-600 ring-1 ring-cyan-600/10' : 'border-zinc-200'">
                
                <div @click="expandedClientIds.includes({{ $client->id }}) ? expandedClientIds = expandedClientIds.filter(id => id !== {{ $client->id }}) : expandedClientIds.push({{ $client->id }})"
                     class="p-6 flex flex-col md:flex-row md:items-center justify-between cursor-pointer hover:bg-zinc-50/50 transition-colors">
                    <div class="flex items-center space-x-6">
                        <div class="h-10 w-10 border border-zinc-200 flex items-center justify-center font-bold text-cyan-600 bg-cyan-50 font-mono">{{ substr($client->user->name, 0, 1) }}</div>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-zinc-900">{{ $client->user->name }}</h4>
                            <p class="text-[10px] text-zinc-400 uppercase mt-1">
                                <span class="font-mono text-cyan-700">ID: #{{ $client->id }}</span>
                                <span class="mx-2 opacity-50">//</span>
                                <span>Status: {{ $client->status }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0 flex items-center space-x-6">
                        <span class="px-3 py-1 {{ $client->status === 'active' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-zinc-50 text-zinc-400 border-zinc-100' }} text-[8px] font-bold uppercase tracking-widest border font-mono">_{{ $client->status }}</span>
                        <div class="text-zinc-300 transition-all duration-200 transform" :class="expandedClientIds.includes({{ $client->id }}) ? 'rotate-180 text-cyan-600' : 'group-hover:text-zinc-950'">
                            <i data-lucide="chevron-down" class="h-4 w-4"></i>
                        </div>
                    </div>
                </div>

                <div x-show="expandedClientIds.includes({{ $client->id }})" x-collapse x-cloak class="border-t border-dashed border-zinc-100 bg-zinc-50/50">
                    <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Bio_Metrics -->
                        <div class="space-y-4">
                            <h5 class="text-[8px] font-mono text-zinc-400 uppercase tracking-[0.2em] mb-4">Bio_Metrics_Core</h5>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white p-3 border border-zinc-100">
                                    <p class="text-[8px] text-zinc-400 uppercase">Weight</p>
                                    <p class="text-xs font-mono font-bold text-zinc-900">{{ $client->current_weight ?? '--' }} KG</p>
                                </div>
                                <div class="bg-white p-3 border border-zinc-100">
                                    <p class="text-[8px] text-zinc-400 uppercase">Height</p>
                                    <p class="text-xs font-mono font-bold text-cyan-600">{{ $client->height ?? '--' }} CM</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick_Logs -->
                        <div class="space-y-4 col-span-2">
                            <h5 class="text-[8px] font-mono text-zinc-400 uppercase tracking-[0.2em] mb-4">Intelligence_Feed</h5>
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 mt-4">
                                <button @click.stop="openModal({{ json_encode($client->load('user')) }})" class="w-full py-2 bg-white text-zinc-900 text-[8px] uppercase font-bold tracking-widest hover:bg-zinc-50 transition-all border border-zinc-200 hover:border-cyan-600 hover:text-cyan-600 flex items-center justify-center gap-x-1.5 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">
                                    <i data-lucide="edit-3" class="size-3 text-zinc-950"></i>
                                    Edit_Profile
                                </button>
                                <button @click.stop="confirmDelete({{ json_encode(['id' => $client->id, 'name' => $client->user->name]) }})" class="w-full py-2 bg-red-50 text-red-600 text-[8px] uppercase font-bold tracking-widest hover:bg-red-100 transition-all border border-red-100 flex items-center justify-center gap-x-1.5 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">
                                    <i data-lucide="trash-2" class="size-3"></i>
                                    Terminate_Pupil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-8 font-mono">
        {{ $clients->links() }}
    </div>

    <!-- Modals -->
    <!-- Client Modal -->
    <div x-show="showClientModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div @click="showClientModal = false" class="fixed inset-0 bg-zinc-950/20 backdrop-blur-sm"></div>
        <form :action="isEditing ? '{{ route('coach.clients.index') }}/' + editingClientId : '{{ route('coach.clients.store') }}'" 
              method="POST"
              class="relative bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-lg p-8">
            @csrf
            <template x-if="isEditing">
                @method('PUT')
            </template>

            <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-900 mb-6" x-text="isEditing ? 'Edit_Pupil_Profile' : 'Onboard_New_Pupil'"></h3>
            <div class="space-y-4">
                <div class="space-y-1">
                    <label class="text-[8px] uppercase font-mono text-zinc-400">Identity_Name</label>
                    <input type="text" name="name" x-model="newClient.name" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 font-mono uppercase">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[8px] uppercase font-mono text-zinc-400">Email_Access</label>
                        <input type="email" name="email" x-model="newClient.email" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 font-mono">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[8px] uppercase font-mono text-zinc-400">Phone_Node</label>
                        <input type="tel" name="phone_number" x-model="newClient.phone_number" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 font-mono">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[8px] uppercase font-mono text-zinc-400">Current_Mass (KG)</label>
                        <input type="number" name="current_weight" x-model="newClient.current_weight" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 font-mono">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[8px] uppercase font-mono text-zinc-400">Target_Goal (KG)</label>
                        <input type="number" name="target_goal" x-model="newClient.target_goal" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 font-mono">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[8px] uppercase font-mono text-zinc-400">Height (CM)</label>
                        <input type="number" name="height" x-model="newClient.height" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 font-mono">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[8px] uppercase font-mono text-zinc-400">Status_Node</label>
                        <select name="status" x-model="newClient.status" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 font-mono uppercase">
                            <option value="active">_ACTIVE</option>
                            <option value="pending">_PENDING</option>
                            <option value="inactive">_INACTIVE</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                    <span x-text="isEditing ? 'Save_Profile_Modifications' : 'Onboard_Pupil'"></span>
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Modal -->
    <div x-show="isDeleteModalOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div @click="isDeleteModalOpen = false" class="fixed inset-0 bg-zinc-950/20 backdrop-blur-sm"></div>
        <form :action="'{{ route('coach.clients.index') }}/' + (clientToDelete ? clientToDelete.id : '')" 
              method="POST"
              class="relative bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-sm p-8 text-center text-zinc-900">
            @csrf
            @method('DELETE')
            <i data-lucide="alert-triangle" class="size-8 text-red-600 mx-auto mb-4"></i>
            <h3 class="text-xs font-bold uppercase tracking-widest mb-2">Confirm_Termination</h3>
            <p class="text-[10px] text-zinc-500 uppercase mb-8">Revoking access for <span class="font-bold" x-text="clientToDelete ? clientToDelete.name : ''"></span>. Irreversible purge.</p>
            <div class="flex gap-4">
                <button type="button" @click="isDeleteModalOpen = false" class="flex-1 py-3 border border-zinc-200 text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-50 transition-all font-sans">Abstain</button>
                <button type="submit" class="flex-1 py-3 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-red-700 transition-all font-sans">Execute_Purge</button>
            </div>
        </form>
    </div>
</div>
@endsection
