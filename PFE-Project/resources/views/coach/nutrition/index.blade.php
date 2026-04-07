@extends('layouts.dashboard')

@section('title', 'Nutrition Engine')
@section('header_title', 'Nutrition_Engine')
@section('header_subtitle', 'Protocol_Sync // Biomass_Analysis')

@section('content')
<div x-data="{ 
    activeTab: 'meals',
    // Meal State
    p: 30, c: 20, f: 10,
    get kcal() { return (this.p * 4) + (this.c * 4) + (this.f * 9) },
    // Program State
    programView: 'list',
    searchProtocol: '',
    currentProtocol: {
        name: '',
        meals: { 'Breakfast': '', 'Lunch': '', 'Snack': '', 'Dinner': '' }
    },
    isEditing: false,
    resetProtocol() {
        this.currentProtocol = { name: '', meals: { 'Breakfast': '', 'Lunch': '', 'Snack': '', 'Dinner': '' } };
        this.isEditing = false;
        this.programView = 'create';
    },
    editProgram(p) {
        this.currentProtocol = JSON.parse(JSON.stringify(p));
        this.isEditing = true;
        this.programView = 'create';
    },
    isDeleteModalOpen: false,
    protocolToDelete: null,
    confirmDelete(p) {
        this.protocolToDelete = p;
        this.isDeleteModalOpen = true;
    }
}">
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-[10px] font-mono uppercase tracking-[0.2em] shadow-[4px_4px_0px_0px_rgba(16,185,129,0.1)]">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabs Header -->
    <div class="mb-10 flex flex-col md:flex-row md:justify-between md:items-end gap-6 font-sans border-b border-zinc-100 pb-4">
        <div class="flex space-x-8">
            <button @click="activeTab = 'meals'" 
                    :class="activeTab === 'meals' ? 'text-cyan-600 border-cyan-600' : 'text-zinc-400 border-transparent'"
                    class="text-[10px] font-bold uppercase tracking-widest border-b-2 pb-2 transition-all hover:text-cyan-600 font-mono">
                Meal_Creator
            </button>
            <button @click="activeTab = 'programs'" 
                    :class="activeTab === 'programs' ? 'text-cyan-600 border-cyan-600' : 'text-zinc-400 border-transparent'"
                    class="text-[10px] font-bold uppercase tracking-widest border-b-2 pb-2 transition-all hover:text-cyan-600 font-mono">
                Program_Manager
            </button>
        </div>
        <div x-show="activeTab === 'programs'">
            <button @click="if(programView === 'list') { resetProtocol() } else { programView = 'list' }" 
                    class="px-6 py-3 bg-zinc-950 text-white text-[10px] uppercase font-bold tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] font-mono">
                <span x-text="programView === 'list' ? 'Create_New_Protocol' : 'Return_to_List'"></span>
            </button>
        </div>
    </div>

    <!-- MEAL CREATOR TAB -->
    <form action="{{ route('coach.nutrition.meals.store') }}" method="POST" x-show="activeTab === 'meals'" x-transition class="grid grid-cols-1 lg:grid-cols-3 gap-8 font-mono">
        @csrf
        <div class="lg:col-span-2 space-y-6">
            <div x-data="{ categoryOpen: false, selectedCategoryName: '{{ $categories->first()->name ?? 'Select_Cat' }}', selectedCategoryId: '{{ $categories->first()->id ?? '' }}' }" 
                 class="ag-card p-8 bg-white relative">
                <h3 class="text-xs font-bold uppercase tracking-widest mb-6 border-b border-zinc-100 pb-2">Meal_Configuration</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative">
                        <label class="block text-[8px] text-zinc-400 uppercase tracking-widest mb-2 font-mono">Category</label>
                        <input type="hidden" name="category_id" x-model="selectedCategoryId">
                        <button type="button" @click="categoryOpen = !categoryOpen" 
                                class="w-full bg-zinc-50 px-4 py-3 text-[10px] uppercase border border-zinc-200 flex items-center justify-between outline-none focus:border-cyan-600 transition-colors font-mono text-cyan-700">
                            <span x-text="selectedCategoryName"></span>
                            <i data-lucide="chevron-down" class="size-4" :class="categoryOpen ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="categoryOpen" @click.outside="categoryOpen = false" 
                             class="absolute left-0 mt-1 w-full bg-white border border-zinc-200 z-[100] shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)]">
                            @foreach($categories as $cat)
                                <div @click="selectedCategoryName = '{{ $cat->name }}'; selectedCategoryId = '{{ $cat->id }}'; categoryOpen = false" 
                                     class="px-4 py-3 text-[10px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600 flex items-center justify-between"
                                     :class="selectedCategoryId == '{{ $cat->id }}' ? 'border-l-cyan-600 bg-zinc-50 text-cyan-600' : ''">
                                    <span>{{ $cat->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-[8px] text-zinc-900 font-bold uppercase tracking-widest mb-2 font-sans">Meal_Name</label>
                        <input type="text" name="name" placeholder="Salmon_Bowl_V3" required
                               class="w-full bg-zinc-50 px-4 py-3 text-[10px] uppercase border border-zinc-200 outline-none focus:border-cyan-600 transition-colors font-mono text-zinc-900 placeholder:opacity-30">
                    </div>
                </div>
            </div>

            <div class="ag-card bg-white overflow-hidden">
                <div class="flex items-center gap-x-2 p-2 bg-zinc-50 border-b border-zinc-100 border-dashed">
                    <span class="text-[8px] text-zinc-400 uppercase ml-2">Protocol_Details</span>
                </div>
                <textarea name="details" placeholder="Enter_Repa_Description_Protocol..." 
                      class="w-full min-h-[300px] p-8 text-sm normal-case font-sans focus:outline-none placeholder:italic placeholder:text-zinc-400 bg-white border-0"></textarea>
            </div>
        </div>

        <div class="space-y-6">
            <div class="ag-card p-8 bg-white sticky top-6">
                <h3 class="text-xs font-bold uppercase tracking-widest mb-8 border-b border-zinc-100 pb-4">Matrix_Analysis</h3>
                <div class="space-y-6 mb-12">
                    <div class="space-y-2">
                        <label class="block text-[8px] text-zinc-400 uppercase tracking-widest font-mono">PRO_Entry (g)</label>
                        <input type="number" name="protein" x-model.number="p" required min="0" step="0.1"
                               class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-xs font-mono font-bold outline-none focus:border-zinc-900 transition-all text-cyan-700">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[8px] text-zinc-400 uppercase tracking-widest font-mono">CAR_Entry (g)</label>
                        <input type="number" name="carbs" x-model.number="c" required min="0" step="0.1"
                               class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-xs font-mono font-bold outline-none focus:border-zinc-900 transition-all text-zinc-900">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[8px] text-zinc-400 uppercase tracking-widest font-mono">FAT_Entry (g)</label>
                        <input type="number" name="fats" x-model.number="f" required min="0" step="0.1"
                               class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-xs font-mono font-bold outline-none focus:border-zinc-900 transition-all text-emerald-600">
                    </div>
                </div>
                <div class="text-center p-6 bg-zinc-50 border border-zinc-200 border-dashed">
                    <p class="text-[8px] text-zinc-400 uppercase tracking-widest mb-2 font-sans">Total_Kcal</p>
                    <div class="text-4xl font-bold text-zinc-900 font-mono" x-text="kcal"></div>
                </div>
                <button type="submit" class="w-full py-4 mt-8 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                    Register_Meal
                </button>
            </div>
        </div>
    </form>

    <!-- PROGRAM MANAGER TAB -->
    <div x-show="activeTab === 'programs'" x-transition class="space-y-8 font-mono">
        <div x-show="programView === 'list'" class="ag-card bg-white overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50 flex justify-between items-center">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Active_Protocols</h3>
                <div class="relative w-full md:w-64">
                    <input type="text" x-model="searchProtocol" placeholder="Search..." 
                           class="w-full bg-white border border-zinc-200 px-8 py-1.5 text-[10px] uppercase font-mono tracking-widest focus:outline-none focus:border-cyan-600">
                    <i data-lucide="search" class="absolute left-2.5 top-2 size-3 text-zinc-400"></i>
                </div>
            </div>
            <table class="w-full text-left text-[10px]">
                <thead class="bg-white border-b border-zinc-100 text-zinc-400 uppercase">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-widest">Protocol_Name</th>
                        <th class="px-6 py-4 font-bold tracking-widest">Meals_Count</th>
                        <th class="px-6 py-4 font-bold tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 uppercase">
                    <tr class="hover:bg-cyan-50/30 transition-colors group">
                        <td class="px-6 py-4 font-bold text-zinc-950 group-hover:text-cyan-700">Shred_X_Lite</td>
                        <td class="px-6 py-4 text-zinc-500">4 Slots</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-x-4">
                                <button @click="editProgram({ name: 'Shred_X_Lite', meals: {} })" class="text-zinc-400 hover:text-cyan-600"><i data-lucide="edit-3" class="size-3"></i></button>
                                <button @click="confirmDelete('Shred_X_Lite')" class="text-zinc-400 hover:text-red-500"><i data-lucide="trash-2" class="size-3"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div x-show="programView === 'create'" class="max-w-4xl mx-auto space-y-6">
            <div class="ag-card p-8 bg-white">
                <div class="flex items-center justify-between mb-10 border-b border-zinc-100 pb-4">
                    <h3 class="text-xs font-bold uppercase tracking-widest" x-text="isEditing ? 'Protocol_Editor' : 'Protocol_Timeline_Builder'"></h3>
                    <span class="text-[8px] text-cyan-600 bg-cyan-50 px-2 py-1 font-bold" x-text="isEditing ? 'Editing_Mode' : 'Draft_Mode'"></span>
                </div>
                <div class="mb-8">
                    <label class="block text-[10px] text-zinc-900 uppercase font-bold tracking-widest mb-2 font-sans">Protocol_Name</label>
                    <input type="text" x-model="currentProtocol.name" placeholder="Summer Shred Phase 1" 
                           class="w-full bg-zinc-50 px-4 py-3 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 font-mono text-zinc-900 uppercase">
                </div>
                <div class="space-y-4">
                    <template x-for="cat in ['Breakfast', 'Lunch', 'Snack', 'Dinner']" :key="cat">
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-6 bg-zinc-50 border border-zinc-200 hover:border-cyan-400 hover:bg-white transition-all">
                            <div class="flex items-center space-x-4">
                                <div class="h-2 w-2 bg-cyan-600"></div>
                                <span class="text-[10px] text-zinc-950 font-bold uppercase w-24" x-text="cat"></span>
                            </div>
                            <button class="px-4 py-2 text-[10px] text-cyan-700 font-mono font-bold uppercase border border-zinc-200 bg-zinc-50 hover:bg-white transition-all">
                                Select_Meal
                            </button>
                        </div>
                    </template>
                </div>
                <div class="mt-10 flex justify-end">
                    <button class="px-8 py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                        <span x-text="isEditing ? 'Update_Protocol' : 'Finalize_Protocol'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal (Teleported-like) -->
    <div x-show="isDeleteModalOpen" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center p-4">
        <div @click="isDeleteModalOpen = false" class="absolute inset-0 bg-zinc-950/20 backdrop-blur-sm transition-opacity"></div>
        <div class="relative bg-white w-full max-w-md border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] p-8">
            <div class="flex items-center space-x-4 mb-6">
                <div class="h-10 w-10 bg-red-50 flex items-center justify-center text-red-600 border border-red-100"><i data-lucide="trash-2" class="size-5"></i></div>
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-widest text-zinc-950">Confirm Deletion</h3>
                    <p class="text-[8px] text-zinc-400 uppercase tracking-widest font-mono mt-0.5">IRREVERSIBLE_ACTION // DATA_PURGE_WARNING</p>
                </div>
            </div>
            <p class="text-[10px] text-zinc-500 leading-relaxed mb-8 uppercase font-mono tracking-wider">
               You are about to permanently remove <span class="text-zinc-900 font-bold" x-text="protocolToDelete"></span>. Do you proceed?
            </p>
            <div class="flex space-x-4">
                <button @click="isDeleteModalOpen = false" class="flex-1 h-11 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-red-700 transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">Confirm_Delete</button>
                <button @click="isDeleteModalOpen = false" class="px-6 h-11 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200 hover:bg-zinc-200">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection
