@extends('layouts.dashboard')

@section('title', 'Nutrition Engine')
@section('header_title', 'Nutrition_Engine')
@section('header_subtitle', 'Protocol_Sync // Biomass_Analysis')

@section('content')
<div x-data='{ 
    activeTab: "meals",
    meals: @json($meals),
    // Meal Creator Matrix
    p: 30, c: 20, f: 10,
    get kcal() { return (this.p * 4) + (this.c * 4) + (this.f * 9) },
    get totalMacros() { return this.p + this.c + this.f || 1 },
    get pPct() { return (this.p / this.totalMacros) * 100 },
    get cPct() { return (this.c / this.totalMacros) * 100 },
    get fPct() { return (this.f / this.totalMacros) * 100 },
    
    // UI State
    programView: "list",
    mealSearch: "{{ request("meal_search") }}",
    mealCategory: "ALL_CATEGORIES",
    programSearch: "{{ request("program_search") }}",
    
    // Pagination
    mealPage: 1,
    mealsPerPage: 5,
    
    get filteredMeals() {
        return this.meals.filter(m => {
            const matchesSearch = !this.mealSearch || m.name.toLowerCase().includes(this.mealSearch.toLowerCase());
            const matchesCategory = this.mealCategory === "ALL_CATEGORIES" || (m.category && m.category.name === this.mealCategory);
            return matchesSearch && matchesCategory;
        });
    },
    
    get paginatedMeals() {
        let start = (this.mealPage - 1) * this.mealsPerPage;
        return this.filteredMeals.slice(start, start + this.mealsPerPage);
    },
    
    get mealTotalPages() {
        return Math.ceil(this.filteredMeals.length / this.mealsPerPage) || 1;
    },
    
    // Program Builder State
    isEditing: false,
    editingProgramId: null,
    currentProtocolTitle: "",
    protocolItems: [], // { slot_id, meal_id }
    
    resetProtocol() {
        this.currentProtocolTitle = "";
        this.protocolItems = [];
        this.isEditing = false;
        this.programView = "create";
    },

    editProgram(p) {
        this.editingProgramId = p.id;
        this.currentProtocolTitle = p.title;
        // Map existing items
        this.protocolItems = (p.items || []).map(i => ({
            slot: i.time_slot,
            meal_id: i.meal_id
        }));
        this.isEditing = true;
        this.programView = "create";
    },

    setMeal(slot, mealId) {
        let index = this.protocolItems.findIndex(i => i.slot === slot);
        if (index !== -1) {
            this.protocolItems[index].meal_id = mealId;
        } else {
            this.protocolItems.push({ slot: slot, meal_id: mealId });
        }
    },

    getMealName(slot) {
        let item = this.protocolItems.find(i => i.slot === slot);
        if (!item) return "Select_Meal";
        let m = this.meals.find(m => m.id == item.meal_id);
        return m ? m.name : "Unknown_Meal";
    },

    // Detailed View State
    showDetailsModal: false,
    detailedProtocol: null,
    openDetails(p) {
        this.detailedProtocol = p;
        this.showDetailsModal = true;
    },
    
    // Meal Intelligence State
    showMealModal: false,
    detailedMeal: null,
    openMealDetails(m) {
        this.detailedMeal = m;
        this.showMealModal = true;
    },
    getDetailedStats() {
        if (!this.detailedProtocol) return { p: 0, c: 0, f: 0, k: 0 };
        return this.detailedProtocol.items.reduce((acc, item) => {
            if (item.meal) {
                acc.p += parseFloat(item.meal.protein);
                acc.c += parseFloat(item.meal.carbs);
                acc.f += parseFloat(item.meal.fats);
                acc.k += parseFloat(item.meal.calories);
            }
            return acc;
        }, { p: 0, c: 0, f: 0, k: 0 });
    },

    // Rich Text State
    detailsHTML: "",
    showLinkModal: false,
    showImageModal: false,
    savedRange: null,
    linkUrl: "",
    imageUrl: "",

    saveSelection() {
        const sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            this.savedRange = sel.getRangeAt(0);
        }
    },

    restoreSelection() {
        if (this.savedRange) {
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(this.savedRange);
        }
    },

    insertLink() {
        this.restoreSelection();
        if (this.linkUrl) {
            document.execCommand("createLink", false, this.linkUrl);
        }
        this.showLinkModal = false;
        this.linkUrl = "";
    },

    insertImage(url) {
        this.restoreSelection();
        if (url) {
            document.execCommand("insertImage", false, url);
        }
        this.showImageModal = false;
        this.imageUrl = "";
    },

    handleImageUpload(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (event) => {
            this.insertImage(event.target.result);
        };
        reader.readAsDataURL(file);
    },
    
    renderInstructions(html) {
        if (!html) return "";
        return html;
    }
}'>
    <!-- Alerts / Notifications -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-[10px] font-mono uppercase tracking-[0.2em] shadow-[4px_4px_0px_0px_rgba(16,185,129,0.1)]">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabs Header (Maquette Spec) -->
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
            <button @click="programView === 'list' ? resetProtocol() : programView = 'list'" 
                    class="px-6 py-3 bg-zinc-950 text-white text-[10px] uppercase font-bold tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] font-mono flex items-center gap-x-2">
                <i :data-lucide="programView === 'list' ? 'plus' : 'list-ordered'" class="size-3"></i>
                <span x-text="programView === 'list' ? 'Create_New_Protocol' : 'Return_to_Registry'"></span>
            </button>
        </div>
    </div>

    <!-- TAB 01: MEAL CREATOR -->
    <div x-show="activeTab === 'meals'" x-transition class="grid grid-cols-1 lg:grid-cols-3 gap-8 font-mono">
        <!-- Configuration Column -->
        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('coach.nutrition.meals.store') }}" method="POST" class="ag-card p-8 bg-white relative">
                @csrf
                <h3 class="text-xs font-bold uppercase tracking-widest mb-6 border-b border-zinc-100 pb-2">Meal_Configuration</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Category Dropdown -->
                    <div class="relative" x-data='{ open: false, selected: "{{ $categories->first()->name ?? "Select_Category" }}", selectedId: "{{ $categories->first()->id ?? "" }}" }'>
                        <label class="block text-[8px] text-zinc-400 uppercase tracking-widest mb-2">Category_Node</label>
                        <input type="hidden" name="category_id" :value="selectedId">
                        <button type="button" @click="open = !open" 
                                class="w-full bg-zinc-50 px-4 py-3 text-[10px] uppercase border border-zinc-200 flex items-center justify-between outline-none focus:border-cyan-600 transition-colors font-mono text-cyan-700 rounded-none">
                            <span x-text="selected"></span>
                            <i data-lucide="chevron-down" class="size-4" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" 
                             class="absolute left-0 mt-1 w-full bg-white border border-zinc-200 z-[110] shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)]">
                            @foreach($categories as $cat)
                                <div @click="selected = '{{ $cat->name }}'; selectedId = '{{ $cat->id }}'; open = false" 
                                     class="px-4 py-3 text-[10px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600 flex items-center justify-between">
                                    <span>{{ $cat->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Meal Name -->
                    <div>
                        <label class="block text-[8px] text-zinc-400 uppercase tracking-widest mb-2">Identity_Label</label>
                        <input type="text" name="name" placeholder="E.G. SHRED_OATS_V4" required
                               class="w-full bg-zinc-50 px-4 py-3 text-[10px] uppercase border border-zinc-200 outline-none focus:border-cyan-600 transition-colors font-mono text-zinc-900 placeholder:opacity-30 rounded-none">
                    </div>
                </div>

                <!-- Hidden Macro Inputs (Synced with Matrix) -->
                <input type="hidden" name="protein" :value="p">
                <input type="hidden" name="carbs" :value="c">
                <input type="hidden" name="fats" :value="f">

                <div class="bg-white border border-zinc-200 shadow-[4px_4px_0_0_rgba(0,0,0,0.04)] relative" x-data="{ }">
                    <!-- Matrix Rich Toolbar -->
                    <div class="flex flex-wrap items-center bg-white border-b border-zinc-200 sticky top-0 z-10">
                        <!-- Text Style Group -->
                        <div class="flex border-r border-zinc-200">
                            <button type="button" @mousedown.prevent="document.execCommand('bold')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Bold_Sync (Ctrl+B)">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"/><path d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"/>
                                </svg>
                            </button>
                            <button type="button" @mousedown.prevent="document.execCommand('italic')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Italic_Sync (Ctrl+I)">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path d="M19 4h-9m0 0l-4 16m4-16h9m-9 16h9" stroke-linecap="square"/>
                                </svg>
                            </button>
                            <button type="button" @mousedown.prevent="document.execCommand('underline')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Underline_Sync (Ctrl+U)">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path d="M6 3v7a6 6 0 006 6 6 6 0 006-6V3M4 21h16"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Lists Group -->
                        <div class="flex border-r border-zinc-200">
                            <button type="button" @mousedown.prevent="document.execCommand('insertUnorderedList')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Bullet_Matrix">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                                </svg>
                            </button>
                            <button type="button" @mousedown.prevent="document.execCommand('insertOrderedList')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Ordered_Sequence">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M10 6h11M10 12h11M10 18h11M4 6h1v4M4 10h2M4 18h3"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Headings Group -->
                        <div class="flex border-r border-zinc-200">
                            <button type="button" @mousedown.prevent="document.execCommand('formatBlock', false, 'H1')"
                                    class="h-10 px-3 flex items-center text-[10px] font-bold text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors font-mono">
                                H1
                            </button>
                            <button type="button" @mousedown.prevent="document.execCommand('formatBlock', false, 'H2')"
                                    class="h-10 px-3 flex items-center text-[10px] font-bold text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors font-mono">
                                H2
                            </button>
                            <button type="button" @mousedown.prevent="document.execCommand('formatBlock', false, 'blockquote')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Hypermedia Group -->
                        <div class="flex border-r border-zinc-200">
                            <button type="button" @mousedown.prevent="saveSelection(); showLinkModal = true"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Link_Nexus">
                                <i data-lucide="link" class="size-3.5"></i>
                            </button>
                            <button type="button" @mousedown.prevent="saveSelection(); showImageModal = true"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Image_Buffer">
                                <i data-lucide="image" class="size-3.5"></i>
                            </button>
                        </div>
                        <!-- Style Sanitizer -->
                        <div class="flex border-r border-zinc-200">
                            <button type="button" @mousedown.prevent="document.execCommand('removeFormat')" 
                                    class="h-10 w-10 flex items-center justify-center text-zinc-400 hover:bg-cyan-50 hover:text-cyan-600 transition-all" title="Remove_Styles // Format_Purge">
                                <i data-lucide="eraser" class="size-3.5"></i>
                            </button>
                        </div>
                        <!-- Clear -->
                        <div class="flex ml-auto group">
                            <button type="button" @mousedown.prevent="detailsHTML = ''; $refs.editor.innerHTML = ''" 
                                    class="h-10 w-10 flex items-center justify-center text-red-300 hover:bg-red-50 hover:text-red-500 transition-all" title="Purge_Buffer">
                                <i data-lucide="trash-2" class="size-3.5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Hidden Input for Form Sync -->
                    <input type="hidden" name="details" :value="detailsHTML">

                    <!-- Content Engine -->
                    <div contenteditable="true" 
                         x-ref="editor"
                         @input="detailsHTML = $el.innerHTML"
                         @blur="detailsHTML = $el.innerHTML"
                         class="v3-editor-matrix p-8 min-h-[400px] text-sm font-sans text-zinc-900 leading-relaxed focus:outline-none bg-white font-sans normal-case"
                         data-placeholder="Start writing your protocol intelligence here...">
                    </div>

                    <!-- Link Nexus Modal -->
                    <div x-show="showLinkModal" x-transition 
                         class="absolute inset-x-0 top-10 bg-white border-b border-zinc-200 z-[120] p-6 shadow-2xl animate-in slide-in-from-top duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest">Connect_Link_Nexus</span>
                            <button @click="showLinkModal = false" class="text-zinc-400 hover:text-red-500 transition-colors">
                                <i data-lucide="x" class="size-3.5"></i>
                            </button>
                        </div>
                        <div class="flex gap-x-3">
                            <div class="flex-1 relative">
                                <i data-lucide="link" class="absolute left-3 top-2.5 size-3.5 text-zinc-300"></i>
                                <input type="url" x-model="linkUrl" placeholder="https://..." 
                                       class="w-full bg-zinc-50 border border-zinc-100 px-10 py-2.5 text-[10px] font-mono focus:outline-none focus:border-cyan-600 transition-all rounded-none">
                            </div>
                            <button type="button" @click="insertLink()" 
                                    class="bg-zinc-950 text-white px-6 text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all">
                                Sync_Link
                            </button>
                        </div>
                    </div>

                    <!-- Media Matrix Modal -->
                    <div x-show="showImageModal" x-transition 
                         class="absolute inset-x-0 top-10 bg-white border-b border-zinc-200 z-[120] p-6 shadow-2xl animate-in slide-in-from-top duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest">Inject_Media_Node</span>
                            <button @click="showImageModal = false" class="text-zinc-400 hover:text-red-500 transition-colors">
                                <i data-lucide="x" class="size-3.5"></i>
                            </button>
                        </div>
                        <div class="flex flex-col gap-y-4">
                            <div class="flex gap-x-3">
                                <div class="flex-1 relative">
                                    <i data-lucide="globe" class="absolute left-3 top-2.5 size-3.5 text-zinc-300"></i>
                                    <input type="url" x-model="imageUrl" placeholder="Remote_Image_URL..." 
                                           class="w-full bg-zinc-50 border border-zinc-100 px-10 py-2.5 text-[10px] font-mono focus:outline-none focus:border-cyan-600 transition-all rounded-none">
                                </div>
                                <button type="button" @click="insertImage(imageUrl)" 
                                        class="bg-zinc-950 text-white px-6 text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all">
                                    Embed_Remote
                                </button>
                            </div>
                            <div class="relative group">
                                <input type="file" @change="handleImageUpload($event)" accept="image/*"
                                       class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                <div class="border-2 border-dashed border-zinc-100 p-6 flex flex-col items-center justify-center group-hover:bg-zinc-50 transition-all group-hover:border-cyan-100">
                                    <i data-lucide="upload-cloud" class="size-6 text-zinc-300 mb-2 group-hover:text-cyan-400 transition-all"></i>
                                    <p class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest group-hover:text-cyan-600 transition-all">Local_Upload_Node</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                        Register_Meal_to_Registry
                    </button>
                </div>
            </form>

            <!-- Meal Registry (Relocated & Enhanced) -->
            <div class="ag-card bg-white overflow-hidden border border-zinc-100 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.02)]">
                <div class="p-6 bg-zinc-50 border-b border-zinc-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-x-3">
                        <p class="text-[10px] font-mono text-zinc-950 uppercase font-bold tracking-widest">Meal_Registry</p>
                        <span class="text-[8px] bg-cyan-100 text-cyan-700 font-mono px-2 py-0.5" x-text="'COUNT: ' + filteredMeals.length"></span>
                    </div>
                    
                    <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                        <!-- Live Search -->
                        <div class="relative w-full md:w-64">
                            <input type="text" x-model="mealSearch" @input="mealPage = 1" placeholder="Search_Registry..." 
                                   class="w-full bg-white border border-zinc-200 px-10 py-2.5 text-[9px] uppercase font-mono tracking-widest focus:outline-none focus:border-cyan-600 rounded-none transition-all placeholder:text-zinc-300">
                            <i data-lucide="search" class="absolute left-3.5 top-3 size-3.5 text-zinc-400"></i>
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="relative w-full md:w-48" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="w-full bg-white border border-zinc-200 px-4 py-2.5 text-[9px] uppercase font-mono tracking-widest flex items-center justify-between focus:outline-none focus:border-cyan-600 rounded-none transition-all">
                                <span x-text="mealCategory === 'ALL_CATEGORIES' ? 'ALL_NODES' : mealCategory"></span>
                                <i data-lucide="filter" class="size-3 text-zinc-400"></i>
                            </button>
                            <div x-show="open" @click.outside="open = false" 
                                 class="absolute left-0 mt-1 w-full bg-white border border-zinc-200 z-[110] shadow-xl">
                                <div @click="mealCategory = 'ALL_CATEGORIES'; mealPage = 1; open = false" 
                                     class="px-4 py-2.5 text-[8px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600">
                                    ALL_NODES
                                </div>
                                @foreach($categories as $cat)
                                    <div @click="mealCategory = '{{ $cat->name }}'; mealPage = 1; open = false" 
                                         class="px-4 py-2.5 text-[8px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600">
                                        {{ $cat->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="divide-y divide-zinc-50 max-h-[800px] overflow-y-auto">
                    <template x-for="meal in paginatedMeals" :key="meal.id">
                        <div class="p-5 hover:bg-zinc-50/50 transition-all group border-l-2 border-transparent hover:border-cyan-600 cursor-default">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[7px] px-2 py-0.5 bg-zinc-100 text-zinc-500 font-mono uppercase tracking-[0.2em]" x-text="meal.category ? meal.category.name : 'UNCAT'"></span>
                                <div class="text-right">
                                    <span class="text-[10px] font-mono text-zinc-950 font-bold group-hover:text-cyan-700" x-text="meal.calories"></span>
                                    <span class="text-[7px] text-zinc-400 uppercase ml-0.5">kcal</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-end mt-4 border-t border-zinc-100 pt-3">
                                <div class="flex items-center gap-x-4">
                                    <h4 class="text-[10px] font-bold text-zinc-900 uppercase font-mono tracking-wide" x-text="meal.name"></h4>
                                    <button @click="openMealDetails(meal)" class="text-[8px] text-cyan-600 uppercase font-mono tracking-widest hover:text-cyan-800 transition-colors flex items-center gap-x-1" title="View_Intelligence">
                                        <i data-lucide="scan-line" class="size-3"></i> INTELLIGENCE
                                    </button>
                                </div>
                                <div class="flex gap-x-3">
                                    <div class="flex flex-col items-end">
                                        <span class="text-[6px] text-zinc-300 uppercase">PRO</span>
                                        <span class="text-[8px] font-mono text-cyan-700 font-bold" x-text="meal.protein + 'g'"></span>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-[6px] text-zinc-300 uppercase">CAR</span>
                                        <span class="text-[8px] font-mono text-zinc-950 font-bold" x-text="meal.carbs + 'g'"></span>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-[6px] text-zinc-300 uppercase">FAT</span>
                                        <span class="text-[8px] font-mono text-emerald-600 font-bold" x-text="meal.fats + 'g'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="filteredMeals.length === 0" class="p-20 text-center">
                        <p class="text-[8px] text-zinc-300 uppercase tracking-[0.4em] font-mono">Registry_Null // Search_Mismatch</p>
                    </div>
                </div>

                <!-- Registry Pagination -->
                <div x-show="mealTotalPages > 1" class="p-4 bg-zinc-50 border-t border-zinc-100 flex items-center justify-between">
                    <button @click="mealPage = Math.max(1, mealPage - 1)" 
                            :disabled="mealPage === 1"
                            class="px-4 py-2 text-[8px] font-bold uppercase tracking-[0.2em] font-mono border border-zinc-200 bg-white hover:bg-zinc-50 disabled:opacity-30 disabled:cursor-not-allowed transition-all">
                        PREV_NODE
                    </button>
                    <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest" x-text="'NODE_GATE: ' + mealPage + ' / ' + mealTotalPages"></span>
                    <button @click="mealPage = Math.min(mealTotalPages, mealPage + 1)" 
                            :disabled="mealPage === mealTotalPages"
                            class="px-4 py-2 text-[8px] font-bold uppercase tracking-[0.2em] font-mono border border-zinc-200 bg-white hover:bg-zinc-50 disabled:opacity-30 disabled:cursor-not-allowed transition-all">
                        NEXT_NODE
                    </button>
                </div>
            </div>
        </div>

        <!-- Matrix Analysis Column -->
        <div class="space-y-6">
            <div class="ag-card p-6 bg-white sticky top-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.03)] border-zinc-200">
                <div class="flex items-center justify-between mb-6 border-b border-zinc-100 pb-4">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-zinc-950">Matrix_Analysis</h3>
                    <div class="flex gap-1">
                        <div class="h-1 w-1 bg-cyan-500"></div>
                        <div class="h-1 w-3 bg-zinc-100"></div>
                    </div>
                </div>

                <!-- Macro Distribution Bar (Live Gradient) -->
                <div class="mb-8 space-y-2">
                    <div class="flex justify-between text-[8px] uppercase tracking-widest text-zinc-400 font-mono">
                        <span>Distribution_Yield</span>
                        <span class="text-cyan-600" x-text="Math.round(totalMacros) + 'G_TOTAL'"></span>
                    </div>
                    <div class="h-4 w-full bg-zinc-100 flex overflow-hidden">
                        <div class="h-full bg-cyan-600 transition-all duration-500" :style="'width: ' + pPct + '%'"></div>
                        <div class="h-full bg-zinc-900 transition-all duration-500 border-l border-white/10" :style="'width: ' + cPct + '%'"></div>
                        <div class="h-full bg-emerald-500 transition-all duration-500 border-l border-white/10" :style="'width: ' + fPct + '%'"></div>
                    </div>
                    <div class="flex gap-x-4 mt-2">
                        <div class="flex items-center gap-1.5">
                            <div class="size-1.5 bg-cyan-600"></div>
                            <span class="text-[7px] text-zinc-500 uppercase tracking-tighter">PRO</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="size-1.5 bg-zinc-900"></div>
                            <span class="text-[7px] text-zinc-500 uppercase tracking-tighter">CAR</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="size-1.5 bg-emerald-500"></div>
                            <span class="text-[7px] text-zinc-500 uppercase tracking-tighter">FAT</span>
                        </div>
                    </div>
                </div>

                <!-- Compact Metric Inputs -->
                <div class="grid grid-cols-3 gap-2 mb-8">
                    <div class="space-y-1.5">
                        <label class="block text-[7px] text-zinc-400 uppercase tracking-widest font-mono">PRO (G)</label>
                        <input type="number" x-model.number="p" min="0" step="0.1"
                               class="w-full bg-zinc-50 border border-zinc-200 px-3 py-2 text-[10px] font-mono font-bold outline-none focus:border-cyan-600 transition-all text-cyan-700 rounded-none shadow-inner">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[7px] text-zinc-400 uppercase tracking-widest font-mono">CAR (G)</label>
                        <input type="number" x-model.number="c" min="0" step="0.1"
                               class="w-full bg-zinc-50 border border-zinc-200 px-3 py-2 text-[10px] font-mono font-bold outline-none focus:border-cyan-600 transition-all text-zinc-950 rounded-none shadow-inner">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[7px] text-zinc-400 uppercase tracking-widest font-mono">FAT (G)</label>
                        <input type="number" x-model.number="f" min="0" step="0.1"
                               class="w-full bg-zinc-50 border border-zinc-200 px-3 py-2 text-[10px] font-mono font-bold outline-none focus:border-cyan-600 transition-all text-emerald-600 rounded-none shadow-inner">
                    </div>
                </div>

                <!-- Digital Kcal Monitor -->
                <div class="relative bg-zinc-950 p-6 overflow-hidden border-t border-white/5">
                    <div class="absolute top-0 right-0 p-2 opacity-10 pointer-events-none">
                        <i data-lucide="activity" class="size-12 text-cyan-500"></i>
                    </div>
                    <p class="text-[8px] text-cyan-500/50 uppercase tracking-[0.3em] mb-2 font-mono">Total_Energy_Output</p>
                    <div class="flex items-baseline gap-x-2">
                        <span class="text-3xl font-bold text-white font-mono tracking-tighter" x-text="kcal"></span>
                        <span class="text-[10px] text-cyan-500 font-mono font-bold uppercase tracking-widest">Kcal_Units</span>
                    </div>
                    <div class="mt-4 flex gap-1">
                        <template x-for="i in 20">
                            <div class="h-1 w-full bg-cyan-950/30" :class="i <= (kcal/1000 * 20) ? 'bg-cyan-500/50' : ''"></div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 02: PROGRAM MANAGER -->
    <div x-show="activeTab === 'programs'" x-transition class="space-y-8 font-mono">
        <!-- List View -->
        <div x-show="programView === 'list'" class="ag-card bg-white overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Protocol_Registry_Control</h3>
                <div class="relative w-full md:w-80">
                    <input type="text" x-model="programSearch" placeholder="Filter_Protocols..." 
                           class="w-full bg-white border border-zinc-200 px-10 py-2.5 text-[10px] uppercase font-mono tracking-widest focus:outline-none focus:border-cyan-600 rounded-none">
                    <i data-lucide="search" class="absolute left-3.5 top-3 size-3.5 text-zinc-400"></i>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[10px]">
                    <thead class="bg-white border-b border-zinc-100 text-zinc-400 uppercase tracking-widest font-bold">
                        <tr>
                            <th class="px-8 py-5">Protocol_Matrix_Identity</th>
                            <th class="px-8 py-5">Meal_Slots</th>
                            <th class="px-8 py-5">Date_Modified</th>
                            <th class="px-8 py-5 text-right">Action_Nodes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 uppercase">
                        @forelse($programs as $program)
                            <tr class="hover:bg-cyan-50/20 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-x-3">
                                        <div class="h-1.5 w-1.5 bg-cyan-600"></div>
                                        <span class="font-bold text-zinc-950 group-hover:text-cyan-700 transition-colors">{{ $program->title }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-zinc-500 font-mono">{{ $program->items_count }} Units</td>
                                <td class="px-8 py-5 text-zinc-400 font-mono">{{ $program->updated_at?->format('Y-m-d') ?? 'N/A' }}</td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end gap-x-6">
                                        <button @click="openDetails({{ json_encode($program) }})" class="text-zinc-400 hover:text-cyan-600 transition-all" title="View_Intelligence_Report"><i data-lucide="layout-list" class="size-3.5"></i></button>
                                        <button @click="editProgram({{ json_encode($program->load('items')) }})" class="text-zinc-400 hover:text-cyan-600 transition-all"><i data-lucide="terminal" class="size-3.5"></i></button>
                                        <form action="{{ route('coach.nutrition.programs.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Nodes_Purge_Confirm?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-zinc-300 hover:text-red-500 transition-all"><i data-lucide="zap-off" class="size-3.5"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-zinc-300 uppercase tracking-[0.3em] text-[8px]">
                                    NODES_NULL // NO_DATA_DETECTED
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Protocol Builder View -->
        <div x-show="programView === 'create'" class="max-w-4xl mx-auto space-y-8" x-transition>
            <form :action="isEditing ? '{{ route('coach.nutrition.programs.store') }}' : '{{ route('coach.nutrition.programs.store') }}'" 
                  method="POST" 
                  class="ag-card p-10 bg-white relative overflow-hidden">
                @csrf
                <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none">
                    <i data-lucide="cpu" class="size-32"></i>
                </div>

                <div class="flex items-center justify-between mb-12 border-b border-zinc-100 pb-6">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-950" x-text="isEditing ? 'Protocol_Editor_V3' : 'Timeline_Matrix_Builder'"></h3>
                        <p class="text-[8px] text-cyan-700 mt-1 uppercase tracking-widest">Operational // Structural_Design</p>
                    </div>
                </div>

                <div class="mb-10">
                    <label class="block text-[9px] text-zinc-500 uppercase font-bold tracking-widest mb-3">Protocol_Identifier_Label</label>
                    <input type="text" name="title" x-model="currentProtocolTitle" placeholder="E.G. SUMMER_SHRED_PHASE_1" required
                           class="w-full bg-zinc-50 px-5 py-4 text-[10px] border border-zinc-200 outline-none focus:border-cyan-600 font-mono text-zinc-950 uppercase tracking-widest shadow-inner rounded-none">
                </div>

                <div class="space-y-4">
                    <label class="block text-[9px] text-zinc-500 uppercase font-bold tracking-widest mb-6">Slot_Assignment_Matrix</label>
                    @foreach($categories as $cat)
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-6 bg-zinc-50 border border-zinc-200 hover:border-cyan-500 hover:bg-white transition-all group">
                            <div class="flex items-center space-x-6">
                                <div class="h-4 w-1 bg-zinc-300 group-hover:bg-cyan-600 transition-colors"></div>
                                <span class="text-[10px] text-zinc-900 font-bold uppercase w-32 font-mono">{{ $cat->name }}</span>
                                
                                <input type="hidden" name="items[{{ $loop->index }}][slot]" value="{{ $cat->name }}">
                                <input type="hidden" name="items[{{ $loop->index }}][day]" value="Everyday">
                                <!-- Hidden input for the selected meal id, synced by Alpine -->
                                <input type="hidden" name="items[{{ $loop->index }}][meal_id]" 
                                       :value="protocolItems.find(i => i.slot === '{{ $cat->name }}')?.meal_id">
                            </div>
                            
                            <div class="relative mt-4 md:mt-0" x-data='{ open: false }'>
                                <button type="button" @click="open = !open" 
                                        class="px-5 py-3 text-[9px] text-cyan-700 font-mono font-bold uppercase border border-zinc-200 bg-white hover:border-cyan-600 transition-all min-w-[200px] flex justify-between items-center rounded-none"
                                        x-text="getMealName('{{ $cat->name }}')">
                                </button>
                                <div x-show="open" @click.outside="open = false" x-cloak
                                     class="absolute right-0 mt-1 w-72 bg-white border border-zinc-200 z-[120] shadow-2xl max-h-64 overflow-y-auto rounded-none">
                                    <div class="p-2 border-b border-zinc-100 bg-zinc-50 sticky top-0">
                                        <p class="text-[8px] text-zinc-400 uppercase text-center tracking-widest">Select_Module</p>
                                    </div>
                                    @foreach($meals as $m)
                                        <div @click="setMeal('{{ $cat->name }}', {{ $m->id }}); open = false" 
                                             class="px-5 py-3 text-[9px] uppercase font-bold hover:bg-cyan-600 hover:text-white cursor-pointer border-b border-zinc-50 text-zinc-600 transition-colors flex justify-between items-center group/item">
                                            <span>{{ $m->name }}</span>
                                            <span class="text-[7px] opacity-0 group-hover/item:opacity-100 font-mono tracking-tighter">{{ $m->calories }} KCAL</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 pt-8 border-t border-zinc-100 flex justify-end gap-x-4">
                    <button type="button" @click="programView = 'list'" class="px-8 py-4 border border-zinc-200 text-zinc-400 text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-50">Cancel_Build</button>
                    <button type="submit" class="px-10 py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.98]">
                        <span x-text="isEditing ? 'Commit_Protocol_Updates' : 'Initialize_Protocol_Node'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Externalized Print Modals -->
    @include('coach.nutrition.partials.pdf_styles')
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endsection
