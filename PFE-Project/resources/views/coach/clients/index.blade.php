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
    
    // Assignment State
    protocolOpen: false,
    protocolSearch: '',
    protocols: {{ $protocols->map(fn($p) => ['id' => $p->id, 'title' => $p->title])->toJson() }},
    selectedProtocol: { id: null, title: 'Select_Nutrition_Protocol' },
    
    get filteredProtocols() {
        if (this.protocolSearch === '') return this.protocols;
        return this.protocols.filter(p => p.title.toLowerCase().includes(this.protocolSearch.toLowerCase()));
    },
    durationWeeks: 12,

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
    filterStatus: '{{ request('status', 'ALL_STATUSES') }}',
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
        <!-- Search Input -->
        <form action="{{ route('coach.clients.index') }}" method="GET" class="relative flex-1 w-full" x-ref="searchForm">
            <input type="text" name="search" 
                   x-model="searchQuery"
                   x-on:input.debounce.500ms="$refs.searchForm.submit()"
                   placeholder="Search_Pupils (Name, ID)..." 
                   class="w-full bg-zinc-50 border border-zinc-200 px-10 py-2.5 text-[10px] font-mono uppercase tracking-widest focus:outline-none focus:border-cyan-600 rounded-none transition-colors">
            <div class="absolute left-3.5 top-3 text-zinc-400">
                <i data-lucide="search" class="size-3.5"></i>
            </div>
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
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
                    @foreach(['ALL_STATUSES', 'active', 'pending', 'inactive'] as $opt)
                        <a href="{{ route('coach.clients.index', ['status' => $opt, 'search' => request('search')]) }}"
                           class="w-full text-left flex items-center px-4 py-2 text-[10px] font-mono uppercase tracking-widest hover:bg-zinc-50 border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 transition-all font-sans {{ request('status', 'ALL_STATUSES') === $opt ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500' }}">
                            {{ str_replace('_', ' ', $opt) }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Client List -->
    <div class="grid grid-cols-1 gap-4 font-sans">
        @forelse($clients as $client)
            <div class="ag-card bg-white overflow-hidden group transition-all"
                 :class="expandedClientIds.includes({{ $client->id }}) ? 'border-cyan-600 ring-1 ring-cyan-600/10' : 'border-zinc-200'">
                
                <!-- Main Row -->
                <div @click="expandedClientIds.includes({{ $client->id }}) ? expandedClientIds = expandedClientIds.filter(id => id !== {{ $client->id }}) : expandedClientIds.push({{ $client->id }})"
                     class="p-6 flex flex-col md:flex-row md:items-center justify-between cursor-pointer hover:bg-zinc-50/50 transition-colors">
                    <div class="flex items-center space-x-6">
                        <div class="h-10 w-10 border border-zinc-200 flex items-center justify-center font-bold text-cyan-600 bg-cyan-50 font-mono">{{ substr($client->user->name, 0, 1) }}</div>
                        <div>
                            <h4 class="text-xs font-bold uppercase text-zinc-900">{{ $client->user->name }}</h4>
                            <p class="text-[10px] text-zinc-400 uppercase mt-1">
                                <span class="font-mono text-cyan-700">ID: #{{ $client->id }}</span>
                                <span class="mx-2 opacity-50">//</span>
                                <span>Goal: {{ $client->target_goal ?? 'NOT_SET' }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0 flex items-center space-x-6">
                        <span class="px-3 py-1 {{ $client->status === 'active' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-zinc-50 text-zinc-400 border-zinc-100' }} text-[8px] font-bold uppercase tracking-widest border border-dashed font-mono">_{{ strtoupper($client->status) }}</span>
                        
                        <button @click.stop="selectedClient = {{ json_encode($client) }}; showAssignModal = true" 
                                class="flex items-center gap-x-1.5 px-4 py-2 text-[10px] uppercase text-cyan-600 font-bold hover:underline font-mono">
                            <i data-lucide="clipboard-list" class="size-3 text-cyan-600"></i>
                            Assign_Program
                        </button>

                        <div class="text-zinc-300 transition-all duration-200 transform"
                             :class="expandedClientIds.includes({{ $client->id }}) ? 'rotate-180 text-cyan-600' : 'group-hover:text-zinc-950'">
                            <i data-lucide="chevron-down" class="h-4 w-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Details Pane -->
                <div x-show="expandedClientIds.includes({{ $client->id }})" 
                     x-collapse
                     x-cloak
                     class="border-t border-dashed border-zinc-100 bg-zinc-50/50">
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
                                <div class="bg-white p-3 border border-zinc-100">
                                    <p class="text-[8px] text-zinc-400 uppercase">BMI</p>
                                    <p class="text-xs font-mono font-bold text-zinc-900">
                                        @if($client->height && $client->current_weight)
                                            {{ round($client->current_weight / (($client->height / 100) ** 2), 1) }}
                                        @else
                                            --
                                        @endif
                                    </p>
                                </div>
                                <div class="bg-white p-3 border border-zinc-100">
                                    <p class="text-[8px] text-zinc-400 uppercase">Status</p>
                                    <p class="text-xs font-mono font-bold text-emerald-600 uppercase">{{ $client->status }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Program_Status -->
                        <div class="space-y-4">
                            <h5 class="text-[8px] font-mono text-zinc-400 uppercase tracking-[0.2em] mb-4">Current_Assignment</h5>
                            @if($client->program)
                                <div class="bg-white p-4 border border-zinc-200">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-[10px] font-bold text-zinc-900 uppercase">{{ $client->program->title }}</span>
                                        <span class="text-[8px] font-mono text-cyan-700">
                                            Day {{ \Carbon\Carbon::parse($client->program_started_at)->diffInDays(now()) + 1 }}/{{ $client->duration_weeks * 7 }}
                                        </span>
                                    </div>
                                    <div class="w-full h-1 bg-zinc-100 overflow-hidden">
                                        @php
                                            $daysElapsed = \Carbon\Carbon::parse($client->program_started_at)->diffInDays(now()) + 1;
                                            $totalDays = $client->duration_weeks * 7;
                                            $progress = ($daysElapsed / $totalDays) * 100;
                                        @endphp
                                        <div class="h-full bg-cyan-600 transition-all duration-500" style="width: {{ min(100, $progress) }}%"></div>
                                    </div>
                                    <p class="text-[8px] text-zinc-400 mt-3 uppercase tracking-widest">Adherence_Tracking: <span class="text-zinc-900 font-bold">ACTIVE</span></p>
                                </div>
                            @else
                                <div class="bg-white p-4 border border-zinc-200 border-dashed border-2 flex flex-center">
                                    <p class="text-[9px] text-zinc-400 uppercase py-4">No_Active_Protocol_Assigned</p>
                                </div>
                            @endif
                        </div>

                        <!-- Quick_Logs -->
                        <div class="space-y-4">
                            <h5 class="text-[8px] font-mono text-zinc-400 uppercase tracking-[0.2em] mb-4">Intelligence_Feed</h5>
                            <div class="space-y-2">
                                @forelse($client->evolutions->take(2) as $evolution)
                                    <div class="flex items-center space-x-3 text-[9px] uppercase">
                                        <div class="h-1.5 w-1.5 rounded-full {{ $loop->first ? 'bg-emerald-500' : 'bg-cyan-500' }}"></div>
                                        <span class="text-zinc-400 font-mono">{{ $evolution->recorded_at }} //</span>
                                        <span class="text-zinc-900 font-bold">Weight_Logged: {{ $evolution->weight }}kg</span>
                                    </div>
                                @empty
                                    <p class="text-[9px] text-zinc-300 italic uppercase">No_Recent_Traffic</p>
                                @endforelse
                            </div>
                            <div class="grid grid-cols-2 gap-3 mt-4">
                                <button @click.stop="openModal({{ json_encode($client->load('user')) }})" class="w-full py-2 bg-white text-zinc-900 text-[8px] uppercase font-bold tracking-widest hover:bg-zinc-50 transition-all border border-zinc-200 hover:border-cyan-600 hover:text-cyan-600 flex items-center justify-center gap-x-1.5 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">
                                    <i data-lucide="edit-3" class="size-3"></i>
                                    Edit_Profile
                                </button>
                                <button @click.stop="confirmDelete({{ json_encode(['id' => $client->id, 'name' => $client->user->name]) }})" class="w-full py-2 bg-red-50 text-red-600 text-[8px] uppercase font-bold tracking-widest hover:bg-red-100 transition-all border border-red-100 flex items-center justify-center gap-x-1.5 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">
                                    <i data-lucide="trash-2" class="size-3"></i>
                                    Terminate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 bg-white border border-dashed border-zinc-200 text-center uppercase font-mono text-[10px] text-zinc-400">
                No_Pupils_Found_In_Registry
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8 font-mono">
        {{ $clients->appends(request()->query())->links() }}
    </div>

    <!-- Modals -->
    <!-- Add/Edit Client Modal (The Maquette Design) -->
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
            <div class="space-y-4 font-mono">
                <div class="space-y-1">
                    <label class="text-[8px] uppercase text-zinc-400">Identity_Name</label>
                    <input type="text" name="name" x-model="newClient.name" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 uppercase" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[8px] uppercase text-zinc-400">Email_Access</label>
                        <input type="email" name="email" x-model="newClient.email" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[8px] uppercase text-zinc-400">Phone_Node</label>
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
                        <label class="text-[8px] uppercase text-zinc-400">Status_Node</label>
                        <select name="status" x-model="newClient.status" class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 uppercase">
                            <option value="active">_ACTIVE</option>
                            <option value="pending">_PENDING</option>
                            <option value="inactive">_INACTIVE</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center justify-center gap-x-2">
                    <i data-lucide="check" class="size-3" x-show="isEditing"></i>
                    <i data-lucide="plus" class="size-3" x-show="!isEditing"></i>
                    <span x-text="isEditing ? 'Save_Profile_Modifications' : 'Onboard_Pupil'"></span>
                </button>
            </div>
        </form>
    </div>

    <!-- Assignment Modal (The Wizard) -->
    <div x-show="showAssignModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div @click="showAssignModal = false" class="fixed inset-0 bg-zinc-950/20 backdrop-blur-sm"></div>
        <form :action="'{{ route('coach.clients.index') }}/' + (selectedClient ? selectedClient.id : '') + '/assign'" 
              method="POST"
              class="relative bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-md p-8">
            @csrf
            
            <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-900 mb-2">Program_Assignment_Wizard</h3>
            <p class="text-[10px] text-cyan-600 uppercase font-mono mb-6" x-text="'Target: ' + (selectedClient ? selectedClient.user.name : '')"></p>
            
            <div class="space-y-6">
                <!-- Protocol Selection Dropdown -->
                <div>
                    <label class="block text-[10px] text-zinc-900 uppercase font-bold tracking-widest mb-2 font-mono">Select_Nutrition_Protocol</label>
                    <div class="relative">
                        <button type="button" @click="protocolOpen = !protocolOpen" 
                                class="w-full bg-zinc-50 px-4 py-3 text-[10px] flex items-center justify-between border border-zinc-200 outline-none focus:border-cyan-600 transition-colors uppercase font-mono text-cyan-700 rounded-none">
                            <span x-text="selectedProtocol.title"></span>
                            <i data-lucide="chevron-down" class="size-3 transition-transform" :class="protocolOpen ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="protocolOpen" @click.outside="protocolOpen = false" x-cloak
                             class="absolute left-0 mt-1 w-full bg-white border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.05)] z-[110] flex flex-col">
                            
                            <!-- Search Box -->
                            <div class="p-3 bg-white border-b border-zinc-200 flex items-center gap-x-2 focus-within:bg-zinc-50/50 transition-all">
                                <i data-lucide="search" class="size-3 text-zinc-400"></i>
                                <input type="text" x-model="protocolSearch" placeholder="Type_to_filter..." 
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
                                    Search_Mismatch // No_Protocol_Found
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="program_id" :value="selectedProtocol.id" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] text-zinc-900 uppercase font-bold tracking-widest mb-2 font-mono">Duration_Protocol (Weeks)</label>
                    <input type="number" name="duration_weeks" x-model="durationWeeks" min="1" max="52"
                           class="w-full bg-zinc-50 px-4 py-3 text-[10px] uppercase border border-zinc-200 outline-none focus:border-cyan-600 transition-colors font-mono text-cyan-700">
                </div>
                
                <button type="submit" 
                        class="w-full py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center justify-center gap-x-2">
                    <i data-lucide="link" class="size-3"></i>
                    Link_Protocol_to_Client
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="isDeleteModalOpen" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center p-4">
        <div @click="isDeleteModalOpen = false" class="absolute inset-0 bg-zinc-950/20 backdrop-blur-sm"></div>
        <form :action="'{{ route('coach.clients.index') }}/' + (clientToDelete ? clientToDelete.id : '')" 
              method="POST"
              class="relative bg-white w-full max-w-sm border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] p-8 text-center">
            @csrf
            @method('DELETE')
            <div class="size-12 bg-red-50 text-red-600 border border-red-100 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="alert-octagon" class="size-6"></i>
            </div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-950 mb-2">Confirm_Deactivation</h3>
            <p class="text-[10px] text-zinc-400 uppercase font-mono mb-8">Revoking access for <span class="text-zinc-950 font-bold" x-text="clientToDelete ? clientToDelete.name : ''"></span>. Irreversible action.</p>
            <div class="flex gap-4 font-sans">
                <button type="button" @click="isDeleteModalOpen = false" class="flex-1 py-3 border border-zinc-200 text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-50 transition-all">Cancel</button>
                <button type="submit" class="flex-1 py-3 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-red-700 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">Execute_Purge</button>
            </div>
        </form>
    </div>
</div>
@endsection
