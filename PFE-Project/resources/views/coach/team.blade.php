@extends('layouts.dashboard')

@section('title', 'Team Management')
@section('header_title', 'Team Registry')
@section('header_subtitle', 'Hierarchy Control // Staff Manifest V3.0')

@section('content')
<div x-data='teamManagement({ 
    searchQuery: "{{ request("search") }}",
    filterSpec: "{{ request("specialty", "ALL_SPECIALIZATIONS") }}"
})'>

    <!-- Action Header -->
    <div class="mb-8 lg:flex lg:justify-end gap-4 font-mono">
        <button @click="isSpecialtyModalOpen = true"
                class="px-6 py-3 bg-white text-zinc-950 border border-zinc-200 text-[10px] uppercase font-bold tracking-widest hover:bg-zinc-50 transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.02)] active:scale-[0.99] flex items-center gap-x-2">
            <i data-lucide="settings-2" class="size-3"></i>
            Manage Specialties
        </button>
        <button @click="isAddMemberModalOpen = true"
                class="px-6 py-3 bg-zinc-950 text-white text-[10px] uppercase font-bold tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center gap-x-2">
            <i data-lucide="user-plus" class="size-3"></i>
            Add Member
        </button>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 font-sans">
        <div class="ag-card p-6 border border-zinc-200">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Total Staff</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-cyan-700">{{ $team->total() }}</span>
                <span class="text-[10px] text-zinc-400 uppercase tracking-widest">Active Nodes</span>
            </div>
        </div>
        <div class="ag-card p-6 border border-zinc-200">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Registry Efficiency</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-emerald-600">98.2%</span>
            </div>
        </div>
        <div class="ag-card p-6 border border-zinc-200">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">System Status</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-zinc-900 uppercase">ONLINE</span>
            </div>
        </div>
    </div>

    <!-- Discovery Bar -->
    <div class="ag-card p-4 bg-white mb-6 border border-zinc-200 flex flex-col md:flex-row gap-4 items-center">
        <form action="{{ route('coach.team') }}" method="GET" class="relative flex-1 w-full text-zinc-900">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Members (Name, Email, ID)..." 
                   class="w-full bg-zinc-50 border border-zinc-200 px-10 py-2.5 text-[10px] font-mono uppercase tracking-widest focus:outline-none focus:border-cyan-600 transition-colors">
            <i data-lucide="search" class="absolute left-3.5 top-3 size-3.5 text-zinc-400"></i>
        </form>

        <div class="relative w-full md:w-64" x-data="{ open: false }">
            <button @click="open = !open" 
                    @click.away="open = false"
                    class="w-full flex justify-between items-center bg-zinc-50 border border-zinc-200 px-4 py-2.5 text-[10px] font-mono uppercase tracking-widest text-zinc-500 hover:text-zinc-900 transition-colors">
                <span x-text="filterSpec.replace('_', ' ')"></span>
                <i data-lucide="chevron-down" class="size-3 transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-cloak
                 class="absolute right-0 mt-1 z-[100] bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-[256px]">
                <div class="py-1">
                    @foreach($specialties as $spec)
                        <a href="{{ route('coach.team', ['specialty' => $spec->id, 'search' => request('search')]) }}" 
                           class="w-full text-left block px-4 py-2 text-[10px] font-mono uppercase tracking-widest border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 hover:bg-zinc-50 transition-all {{ request('specialty') == $spec->id ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500' }}">
                            {{ $spec->name }}
                        </a>
                    @endforeach
                    <a href="{{ route('coach.team', ['search' => request('search')]) }}" 
                       class="w-full text-left block px-4 py-2 text-[10px] font-mono uppercase tracking-widest border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 hover:bg-zinc-50 transition-all {{ !request('specialty') ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500' }}">
                        ALL_SPECIALIZATIONS
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="ag-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse font-sans font-medium">
                <thead class="bg-zinc-50 border-b border-zinc-200 uppercase font-mono tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Member ID</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Identity</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Specialization</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 uppercase">
                    @foreach($team as $member)
                        <tr class="hover:bg-zinc-50/50 transition-colors">
                            <td class="px-6 py-4 text-[10px] font-mono text-cyan-700 font-bold">#STF-{{ str_pad($member->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">
                                <p class="text-[10px] font-bold text-zinc-900">{{ $member->user->name }}</p>
                                <p class="text-[8px] text-zinc-400 font-mono">{{ $member->user->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($member->specialties as $spec)
                                        <span class="px-1.5 py-0.5 bg-zinc-100 text-zinc-500 text-[7px] font-bold tracking-tighter">{{ $spec->name }}</span>
                                    @endforeach
                                    @if($member->specialties->isEmpty())
                                        <span class="text-[8px] text-zinc-300 italic">No Specialization</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($member->status === 'active')
                                    <div class="flex items-center gap-x-2 px-2 py-1 text-[8px] font-bold border bg-emerald-50 text-emerald-600 border-emerald-100 font-mono w-fit">
                                        <div class="size-1.5 rounded-full bg-emerald-500"></div>
                                        ACTIVE
                                    </div>
                                @else
                                    <div class="flex items-center gap-x-2 px-2 py-1 text-[8px] font-bold border bg-zinc-50 text-zinc-400 border-zinc-200 font-mono w-fit">
                                        <div class="size-1.5 rounded-full bg-zinc-300"></div>
                                        INACTIVE
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <button @click="openEditModal({{ json_encode($member->load(['user', 'specialties'])) }})" class="p-2 text-zinc-400 hover:text-cyan-600 transition-colors"><i data-lucide="edit-3" class="size-3.5"></i></button>
                                    <button @click="confirmDelete({{ json_encode(['id' => $member->id, 'name' => $member->user->name]) }})" class="p-2 text-zinc-400 hover:text-red-600 transition-colors"><i data-lucide="trash-2" class="size-3.5"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-8 font-mono">
        {{ $team->appends(request()->query())->links() }}
    </div>

    <!-- Modals -->
    <!-- Add Modal -->
    <div x-show="isAddMemberModalOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
        <form action="{{ route('coach.team.store') }}" method="POST" 
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4 scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 scale-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 translate-y-0 scale-100"
              x-transition:leave-end="opacity-0 translate-y-2"
              @click.outside="isAddMemberModalOpen = false"
              class="bg-white w-full max-w-lg border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] p-8 font-mono">
            @csrf
            <header class="mb-8 font-sans">
                <h2 class="text-xl font-bold tracking-tight uppercase text-zinc-900">Add New Member</h2>
                <p class="text-[8px] text-cyan-700 uppercase tracking-widest font-mono mt-1">Staff Deployment Interface // V3.0</p>
            </header>
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Full Name</label>
                        <input type="text" name="name" required class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 font-sans uppercase">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Email Access</label>
                        <input type="email" name="email" required class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Phone Number</label>
                        <input type="text" name="phone_number" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 font-mono">
                    </div>
                    <div class="space-y-1.5 relative" x-data="{ open: false, selectedNames: [] }">
                        <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Specialties</label>
                        <button type="button" @click="open = !open"
                                class="w-full flex justify-between items-center text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 uppercase text-left min-h-[42px]">
                            <span class="truncate" x-text="selectedNames.length ? selectedNames.join(', ') : 'Select Specialties'"></span>
                            <i data-lucide="chevron-down" class="size-4 shrink-0" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute left-0 right-0 top-full mt-1 z-[110] bg-white border border-zinc-200 shadow-xl max-h-48 overflow-y-auto font-mono uppercase">
                            @foreach($specialties as $spec)
                                <label class="flex items-center px-4 py-2.5 text-[10px] hover:bg-zinc-50 cursor-pointer group">
                                    <input type="checkbox" name="specialties[]" value="{{ $spec->id }}" 
                                           @change="if($el.checked) { selectedNames.push('{{ $spec->name }}') } else { selectedNames = selectedNames.filter(n => n !== '{{ $spec->name }}') }"
                                           class="mr-3 accent-cyan-600">
                                    <span class="font-bold tracking-widest text-zinc-500 group-hover:text-cyan-600 transition-colors">{{ $spec->name }}</span>
                                </label>
                            @endforeach
                            @if($specialties->isEmpty())
                                <div class="px-4 py-2.5 text-[8px] text-zinc-400 italic">No specialties defined. Use 'Manage Specialties' to add.</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Bio / Notes</label>
                    <textarea name="bio" rows="2" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 font-sans uppercase"></textarea>
                </div>

                <div class="flex space-x-4 pt-4 font-sans">
                    <button type="submit" class="flex-1 h-11 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,0.1)]">Initialize Deployment</button>
                    <button type="button" @click="isAddMemberModalOpen = false" class="h-11 px-6 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Edit Modal -->
    <div x-show="isEditModalOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
        <form :action="'{{ route('coach.team') }}/' + editingMember.id" method="POST"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4 scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 scale-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 translate-y-0 scale-100"
              x-transition:leave-end="opacity-0 translate-y-2"
              @click.outside="isEditModalOpen = false"
              class="bg-white w-full max-w-lg border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] p-8 font-mono">
            @csrf
            @method('PUT')
            <header class="mb-8 font-sans">
                <h2 class="text-xl font-bold tracking-tight uppercase text-zinc-900">Edit Staff Member</h2>
                <p class="text-[8px] text-cyan-700 uppercase tracking-widest font-mono mt-1">Personnel Modification Interface // V3.0</p>
            </header>
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4 uppercase">
                    <div class="space-y-1.5">
                        <label class="text-[10px] text-zinc-400 tracking-widest">Full Name</label>
                        <input type="text" name="name" x-model="editingMember.name" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 font-sans">
                    </div>
                    <div class="space-y-1.5 uppercase">
                        <label class="text-[10px] text-zinc-400 tracking-widest">Email Access</label>
                        <input type="email" name="email" x-model="editingMember.email" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 uppercase">
                    <div class="space-y-1.5">
                        <label class="text-[10px] text-zinc-400 tracking-widest">Phone Number</label>
                        <input type="text" name="phone_number" x-model="editingMember.phone_number" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 font-mono">
                    </div>
                    <div class="space-y-1.5 relative" x-data="{ open: false }">
                        <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Specialties</label>
                        <button type="button" @click="open = !open"
                                class="w-full flex justify-between items-center text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 uppercase text-left min-h-[42px]">
                            <span class="truncate" x-text="editingMember.specialties.length ? 'Selected (' + editingMember.specialties.length + ')' : 'Select Specialties'"></span>
                            <i data-lucide="chevron-down" class="size-4 shrink-0" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute left-0 right-0 top-full mt-1 z-[110] bg-white border border-zinc-200 shadow-xl max-h-48 overflow-y-auto font-mono uppercase">
                            @foreach($specialties as $spec)
                                <label class="flex items-center px-4 py-2.5 text-[10px] hover:bg-zinc-50 cursor-pointer group">
                                    <input type="checkbox" name="specialties[]" value="{{ $spec->id }}" 
                                           :checked="editingMember.specialties.includes({{ $spec->id }})"
                                           @change="if($el.checked) { editingMember.specialties.push({{ $spec->id }}) } else { editingMember.specialties = editingMember.specialties.filter(id => id !== {{ $spec->id }}) }"
                                           class="mr-3 accent-cyan-600">
                                    <span class="font-bold tracking-widest text-zinc-500 group-hover:text-cyan-600 transition-colors">{{ $spec->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Bio / Notes</label>
                        <textarea name="bio" rows="2" x-model="editingMember.bio" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 font-sans uppercase"></textarea>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Status Node</label>
                        <input type="hidden" name="status" :value="editingMember.status">
                        <div class="flex space-x-2">
                            <button type="button" @click="editingMember.status = 'active'"
                                    :class="editingMember.status === 'active' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-zinc-50 text-zinc-400 border-zinc-200'"
                                    class="flex-1 px-3 py-2 border text-[8px] font-bold uppercase tracking-widest font-mono transition-all">
                                ACTIVE
                            </button>
                            <button type="button" @click="editingMember.status = 'inactive'"
                                    :class="editingMember.status === 'inactive' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-zinc-50 text-zinc-400 border-zinc-200'"
                                    class="flex-1 px-3 py-2 border text-[8px] font-bold uppercase tracking-widest font-mono transition-all">
                                INACTIVE
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4 pt-4 font-sans">
                    <button type="submit" class="flex-1 h-11 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,0.1)]">Save Modifications</button>
                    <button type="button" @click="isEditModalOpen = false" class="h-11 px-6 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Specialty Management Modal -->
    <div x-show="isSpecialtyModalOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-2"
             @click.outside="isSpecialtyModalOpen = false"
             class="bg-white w-full max-w-md border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] p-8 font-mono">
            <header class="mb-6 font-sans">
                <h2 class="text-xl font-bold tracking-tight uppercase text-zinc-900">Manage Specialties</h2>
                <p class="text-[8px] text-cyan-700 uppercase tracking-widest font-mono mt-1">Matrix Definitions // V3.0</p>
            </header>
            
            <div class="mb-8">
                <!-- Add Form -->
                <form x-show="!editingSpecialty.id" action="{{ route('coach.team.specialties.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="New Specialty Name..." 
                           class="flex-1 text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600 uppercase">
                    <button type="submit" class="px-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all">ADD</button>
                </form>

                <!-- Edit Form -->
                <form x-show="editingSpecialty.id" :action="'{{ url('/coach/team/specialties') }}/' + editingSpecialty.id" method="POST" class="flex gap-2">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" required x-model="editingSpecialty.name"
                           class="flex-1 text-[10px] p-3 bg-zinc-50 border border-cyan-600 outline-none uppercase font-bold text-cyan-600">
                    <button type="submit" class="px-4 bg-cyan-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-cyan-700 transition-all">SAVE</button>
                    <button type="button" @click="editingSpecialty = { id: null, name: '' }" class="px-3 bg-zinc-100 text-zinc-400 hover:text-zinc-600 border border-zinc-200"><i data-lucide="x" class="size-4"></i></button>
                </form>
            </div>

            <div class="space-y-2 max-h-64 overflow-y-auto pr-2">
                @foreach($specialties as $spec)
                    <div class="flex justify-between items-center p-3 bg-zinc-50 border border-zinc-200" :class="editingSpecialty.id == {{ $spec->id }} ? 'border-cyan-200 bg-cyan-50/30' : ''">
                        <span class="text-[10px] font-bold text-zinc-600 uppercase tracking-widest">{{ $spec->name }}</span>
                        <div class="flex gap-3">
                            <button type="button" @click="editingSpecialty = { id: {{ $spec->id }}, name: '{{ $spec->name }}' }" 
                                    class="text-zinc-400 hover:text-cyan-600 transition-colors">
                                <i data-lucide="edit-2" class="size-3.5"></i>
                            </button>
                            <form action="{{ route('coach.team.specialties.destroy', $spec->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-zinc-400 hover:text-red-600 transition-colors">
                                    <i data-lucide="trash-2" class="size-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
                @if($specialties->isEmpty())
                    <p class="text-[10px] text-zinc-400 italic text-center py-4">No specialties defined.</p>
                @endif
            </div>

            <div class="mt-8">
                <button type="button" @click="isSpecialtyModalOpen = false; editingSpecialty = { id: null, name: '' }" class="w-full h-11 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Close</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="isDeleteModalOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm"
         @click.self="isDeleteModalOpen = false">
        <form :action="'{{ route('coach.team') }}/' + (memberToDelete ? memberToDelete.id : '')" method="POST"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4 scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 scale-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 translate-y-0 scale-100"
              x-transition:leave-end="opacity-0 translate-y-2"
              @click.outside="isDeleteModalOpen = false"
              class="relative bg-white w-full max-w-md border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] p-8 font-mono text-zinc-900">
            @csrf
            @method('DELETE')
            <div class="flex items-center space-x-4 mb-6">
                <div class="h-10 w-10 bg-red-50 flex items-center justify-center text-red-600 border border-red-100"><i data-lucide="trash-2" class="size-5"></i></div>
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-widest">Confirm Termination</h3>
                    <p class="text-[8px] text-zinc-400 uppercase tracking-widest mt-0.5">STAFF RESCISSION // ACCESS REVOCATION</p>
                </div>
            </div>
            <p class="text-[10px] text-zinc-500 uppercase mb-8">Revoking credentials for <span class="font-bold text-zinc-950" x-text="memberToDelete ? memberToDelete.name : ''"></span>. Proceed?</p>
            <div class="flex gap-4 font-sans">
                <button type="submit" class="flex-1 h-11 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">Confirm Purge</button>
                <button type="button" @click="isDeleteModalOpen = false" class="px-6 h-11 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
            </div>
        </form>
    </div>
</div>
@include('components.ai-chatbot')

<!-- Success Toast for Laravel session -->
<div x-data="{ show: false, message: '' }" x-show="show" x-init="@if (session('success')) 
    message = '{{ session('success') }}'; 
    show = true; 
    setTimeout(() => show = false, 3000); 
@endif" class="fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow-lg transition-opacity" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <span x-text="message"></span>
</div>

@endsection
