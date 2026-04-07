@extends('layouts.dashboard')

@section('title', 'Team Management')
@section('header_title', 'Team_Registry')
@section('header_subtitle', 'Hierarchy_Control // Staff_Manifest_V3.0')

@section('content')
<div x-data="{ 
    isAddMemberModalOpen: false,
    searchQuery: '',
    filterSpec: 'ALL_SPECIALIZATIONS',
    teamMembers: [
        { id: 'STF-001', name: 'Coach_Mehdi', email: 'mehdi@coach.io', spec: 'Hypertrophy_Logic', pupils: 42, status: 'Active' },
        { id: 'STF-002', name: 'Coach_Sarah', email: 'sarah@coach.io', spec: 'Nutrition_V3_Engine', pupils: 36, status: 'Active' }
    ],
    isEditModalOpen: false,
    editingMember: null,
    isDeleteModalOpen: false,
    memberToDelete: null,
    deleteIndex: null,
    
    openEditModal(member) {
        this.editingMember = JSON.parse(JSON.stringify(member));
        this.isEditModalOpen = true;
    },
    saveEditMember() {
        const index = this.teamMembers.findIndex(m => m.id === this.editingMember.id);
        if (index !== -1) this.teamMembers[index] = this.editingMember;
        this.isEditModalOpen = false;
    },
    confirmDelete(member, index) {
        this.memberToDelete = member;
        this.deleteIndex = index;
        this.isDeleteModalOpen = true;
    },
    executeDelete() {
        this.teamMembers.splice(this.deleteIndex, 1);
        this.isDeleteModalOpen = false;
    },
    toggleStatus(index) {
        this.teamMembers[index].status = this.teamMembers[index].status === 'Active' ? 'Inactive' : 'Active';
    }
}">
    <!-- Action Header -->
    <div class="mb-8 flex justify-end">
        <button @click="isAddMemberModalOpen = true"
                class="px-6 py-3 bg-zinc-950 text-white text-[10px] uppercase font-bold tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center gap-x-2 font-mono">
            <i data-lucide="user-plus" class="size-3"></i>
            Add_Member
        </button>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 font-sans">
        <div class="ag-card p-6 border border-zinc-200">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Total_Staff</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-cyan-700">12</span>
                <span class="text-[10px] text-zinc-400 uppercase tracking-widest">Active_Nodes</span>
            </div>
        </div>
        <div class="ag-card p-6 border border-zinc-200">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Active_Coaches</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-cyan-700">08</span>
            </div>
        </div>
        <div class="ag-card p-6 border border-zinc-200">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Performance_Index</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-emerald-600">98.2%</span>
            </div>
        </div>
    </div>

    <!-- Discovery Bar -->
    <div class="ag-card p-4 bg-white mb-6 border border-zinc-200 flex flex-col md:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full text-zinc-900">
            <input type="text" x-model="searchQuery" placeholder="Search_Members (Name, ID)..." 
                   class="w-full bg-zinc-50 border border-zinc-200 px-10 py-2.5 text-[10px] font-mono uppercase tracking-widest focus:outline-none focus:border-cyan-600 transition-colors">
            <i data-lucide="search" class="absolute left-3.5 top-3 size-3.5 text-zinc-400"></i>
        </div>

        <div class="relative w-full md:w-64" x-data="{ open: false }">
            <button @click="open = !open" 
                    class="w-full flex justify-between items-center bg-zinc-50 border border-zinc-200 px-4 py-2.5 text-[10px] font-mono uppercase tracking-widest text-zinc-500 hover:text-zinc-900 transition-colors">
                <span x-text="filterSpec.replace('_', ' ')"></span>
                <i data-lucide="chevron-down" class="size-3" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" @click.away="open = false" 
                 class="absolute right-0 mt-1 z-[100] bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-[256px]">
                <div class="py-1">
                    <template x-for="opt in ['ALL_SPECIALIZATIONS', 'Hypertrophy_Logic', 'Nutrition_V3_Engine', 'Bio-Mechanics']">
                        <button @click="filterSpec = opt; open = false" 
                                class="w-full text-left px-4 py-2 text-[10px] font-mono uppercase tracking-widest border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 hover:bg-zinc-50 transition-all"
                                :class="filterSpec === opt ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500'">
                            <span x-text="opt.replace('_', ' ')"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="ag-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-zinc-50 border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono">Member_ID</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono">Identity</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono">Specialization</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono">Pupils</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 font-sans">
                    <template x-for="(member, index) in teamMembers" :key="member.id">
                        <tr class="hover:bg-zinc-50/50 transition-colors"
                            x-show="(searchQuery === '' || member.name.toLowerCase().includes(searchQuery.toLowerCase())) && (filterSpec === 'ALL_SPECIALIZATIONS' || filterSpec === member.spec)">
                            <td class="px-6 py-4 text-[10px] font-mono text-cyan-700 font-bold" x-text="'#' + member.id"></td>
                            <td class="px-6 py-4">
                                <p class="text-[10px] font-bold text-zinc-900 uppercase" x-text="member.name"></p>
                                <p class="text-[8px] text-zinc-400 uppercase font-mono" x-text="member.email"></p>
                            </td>
                            <td class="px-6 py-4 text-[10px] text-zinc-500 uppercase tracking-wider" x-text="member.spec"></td>
                            <td class="px-6 py-4 text-[10px] font-mono text-cyan-700 font-bold" x-text="member.pupils"></td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <button @click="openEditModal(member)" class="p-2 text-zinc-400 hover:text-cyan-600 transition-colors"><i data-lucide="edit-3" class="size-3.5"></i></button>
                                    <button @click="confirmDelete(member, index)" class="p-2 text-zinc-400 hover:text-red-600 transition-colors"><i data-lucide="trash-2" class="size-3.5"></i></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modals -->
    <!-- Edit Modal -->
    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/20 backdrop-blur-sm">
        <div @click.outside="isEditModalOpen = false" class="bg-white w-full max-w-lg border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] p-8">
            <header class="mb-8 font-sans">
                <h2 class="text-xl font-bold tracking-tight uppercase text-zinc-900">Edit_Staff_Member</h2>
                <p class="text-[8px] text-cyan-700 uppercase tracking-widest font-mono mt-1">Personnel_Modification_Interface // V3.0</p>
            </header>
            <div class="space-y-6" x-if="editingMember">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5"><label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">Full_Name</label>
                        <input type="text" x-model="editingMember.name" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 focus:border-cyan-600 font-sans uppercase">
                    </div>
                    <div class="space-y-1.5"><label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">Email</label>
                        <input type="email" x-model="editingMember.email" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 focus:border-cyan-600 font-mono">
                    </div>
                </div>
                <div class="flex space-x-4 pt-4 font-sans">
                    <button @click="saveEditMember()" class="flex-1 h-11 bg-zinc-900 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">Save_Changes</button>
                    <button @click="isEditModalOpen = false" class="h-11 px-6 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200 hover:bg-zinc-200">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="isDeleteModalOpen" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-zinc-950/20 backdrop-blur-sm">
        <div class="relative bg-white w-full max-w-md border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] p-8 font-mono text-zinc-900">
            <div class="flex items-center space-x-4 mb-6">
                <div class="h-10 w-10 bg-red-50 flex items-center justify-center text-red-600 border border-red-100"><i data-lucide="trash-2" class="size-5"></i></div>
                <h3 class="text-sm font-bold uppercase tracking-widest">Confirm Termination</h3>
            </div>
            <p class="text-[10px] text-zinc-500 uppercase mb-8">Revoke access for <span class="font-bold text-zinc-950" x-text="memberToDelete ? memberToDelete.name : ''"></span>?</p>
            <div class="flex gap-4 font-sans">
                <button @click="executeDelete()" class="flex-1 h-11 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">Confirm_Delete</button>
                <button @click="isDeleteModalOpen = false" class="px-6 h-11 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection
