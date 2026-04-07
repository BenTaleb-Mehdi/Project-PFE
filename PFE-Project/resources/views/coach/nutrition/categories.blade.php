@extends('layouts.dashboard')

@section('title', 'Categories')
@section('header_title', 'Category_Management')
@section('header_subtitle', 'Step_01: Define Meal Sequences')

@section('content')
<div x-data="{ 
    isModalOpen: false,
    editingCategoryId: null,
    tempName: '',
    searchCategory: '',
    
    openModal(category = null) {
        if (category) {
            this.editingCategoryId = category.id;
            this.tempName = category.name;
        } else {
            this.editingCategoryId = null;
            this.tempName = '';
        }
        this.isModalOpen = true;
    },
    
    isDeleteModalOpen: false,
    categoryToDelete: null,
    confirmDelete(category) {
        this.categoryToDelete = category;
        this.isDeleteModalOpen = true;
    },
}">

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-[10px] font-mono uppercase tracking-[0.2em] shadow-[4px_4px_0px_0px_rgba(16,185,129,0.1)]">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-600 text-[10px] font-mono uppercase tracking-[0.2em] shadow-[4px_4px_0px_0px_rgba(239,68,68,0.1)]">
            {{ session('error') }}
        </div>
    @endif
    <!-- Discovery Bar -->
    <div class="ag-card p-4 bg-white mb-6 border border-zinc-200 flex flex-col md:flex-row gap-4 items-center max-w-4xl font-mono text-zinc-900">
        <div class="relative flex-1 w-full">
            <input type="text" x-model="searchCategory" placeholder="Search_Categories..." 
                   class="w-full bg-zinc-50 border border-zinc-200 px-10 py-2.5 text-[10px] uppercase tracking-widest focus:outline-none focus:border-cyan-600 transition-colors">
            <i data-lucide="search" class="absolute left-3.5 top-3 size-3.5 text-zinc-400"></i>
        </div>
    </div>

    <!-- Category List -->
    <div class="max-w-4xl space-y-4 font-mono">
        @foreach($categories as $index => $cat)
            <div class="ag-card p-6 bg-white flex justify-between items-center group hover:border-cyan-600 transition-all">
                <div class="flex items-center space-x-6">
                    <span class="text-[10px] text-zinc-300">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="font-bold text-sm uppercase tracking-widest text-zinc-950">{{ $cat->name }}</h3>
                </div>
                <div class="flex items-center space-x-4">
                    <button @click="openModal({{ json_encode($cat) }})" class="p-2 text-zinc-400 hover:text-cyan-600 transition-colors">
                        <i data-lucide="edit-3" class="size-4"></i>
                    </button>
                    <button @click="confirmDelete({{ json_encode($cat) }})" class="p-2 text-zinc-400 hover:text-red-500 transition-colors">
                        <i data-lucide="trash-2" class="size-4"></i>
                    </button>
                </div>
            </div>
        @endforeach

        <button @click="openModal()" 
                class="w-full py-4 border-2 border-dashed border-zinc-200 text-zinc-400 text-[10px] uppercase tracking-widest hover:border-cyan-600 hover:text-cyan-600 transition-all font-mono">
            + Add_New_Sequence_Slot
        </button>
    </div>

    <!-- Modals -->
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/20 backdrop-blur-sm">
        <form :action="editingCategoryId ? '{{ route('coach.nutrition.categories') }}/' + editingCategoryId : '{{ route('coach.nutrition.categories.store') }}'" 
              method="POST"
              class="bg-white w-full max-w-lg border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.05)] overflow-hidden font-mono">
            @csrf
            <template x-if="editingCategoryId">
                @method('PUT')
            </template>

            <div class="px-8 py-6 border-b border-zinc-100 flex justify-between items-center">
                <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-950" x-text="editingCategoryId ? 'Rename_Category' : 'New_Sequence_Slot'"></h3>
                <button type="button" @click="isModalOpen = false" class="text-zinc-400 hover:text-zinc-950 transition-colors"><i data-lucide="x" class="size-4"></i></button>
            </div>
            <div class="p-8 space-y-6">
                <div>
                    <label class="block text-[8px] text-zinc-400 uppercase tracking-widest mb-2 font-mono">Category_Name</label>
                    <input type="text" name="name" x-model="tempName" placeholder="e.g. BREAKFAST_ENGINE" 
                           class="w-full bg-zinc-50 px-4 py-3 text-xs uppercase border border-zinc-200 outline-none focus:border-cyan-600 transition-colors">
                    @error('name')
                        <p class="text-[8px] text-red-600 mt-2 uppercase tracking-widest font-mono">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col space-y-3">
                    <button type="submit" class="w-full py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                        Finalize_Configuration
                    </button>
                    <button type="button" @click="isModalOpen = false" class="w-full py-4 text-[10px] uppercase text-zinc-400 hover:text-zinc-950 transition-colors">Abandon_Changes</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="isDeleteModalOpen" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center p-4">
        <div @click="isDeleteModalOpen = false" class="absolute inset-0 bg-zinc-950/20 backdrop-blur-sm"></div>
        <form :action="'{{ route('coach.nutrition.categories') }}/' + (categoryToDelete ? categoryToDelete.id : '')" 
              method="POST"
              class="relative bg-white w-full max-w-md border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] p-8 font-mono text-zinc-900">
            @csrf
            @method('DELETE')
            <div class="flex items-center space-x-4 mb-6">
                <div class="h-10 w-10 bg-red-50 flex items-center justify-center text-red-600 border border-red-100"><i data-lucide="trash-2" class="size-5"></i></div>
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-widest">Confirm Deletion</h3>
                    <p class="text-[8px] text-zinc-400 uppercase tracking-widest mt-0.5">IRREVERSIBLE_ACTION // DATA_PURGE_WARNING</p>
                </div>
            </div>
            <p class="text-[10px] text-zinc-500 leading-relaxed mb-8 uppercase tracking-wider">
               You are about to permanently remove sequence <span class="text-zinc-900 font-bold" x-text="categoryToDelete ? categoryToDelete.name : ''"></span>. This action is irreversible.
            </p>
            <div class="flex space-x-4 font-sans">
                <button type="submit" class="flex-1 h-11 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-red-700 transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">Confirmer</button>
                <button type="button" @click="isDeleteModalOpen = false" class="px-6 h-11 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200 hover:bg-zinc-200">Annuler</button>
            </div>
        </form>
    </div>
</div>
@endsection
