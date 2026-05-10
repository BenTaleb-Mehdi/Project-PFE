import { createIcons, icons } from 'lucide'

export const coachHub = (config) => ({
    init() {
        this.$nextTick(() => {
            createIcons({ icons });
        });

        // Re-render Lucide icons every time the filtered list changes
        this.$watch('programSearch', () => {
            this.$nextTick(() => createIcons({ icons }));
        });
        this.$watch('programFilter', () => {
            this.$nextTick(() => createIcons({ icons }));
        });
        this.$watch('activeTab', () => {
            this.$nextTick(() => createIcons({ icons }));
        });
        this.$watch('programView', () => {
            this.$nextTick(() => createIcons({ icons }));
        });
    },
    activeTab: "meals",
    meals: config.meals || [],
    programs: config.programs || [],
    // Meal Creator Matrix
    p: 30, c: 20, f: 10,
    get kcal() { return (this.p * 4) + (this.c * 4) + (this.f * 9) },
    get totalMacros() { return this.p + this.c + this.f || 1 },
    get pPct() { return (this.p / this.totalMacros) * 100 },
    get cPct() { return (this.c / this.totalMacros) * 100 },
    get fPct() { return (this.f / this.totalMacros) * 100 },
    
    // UI State
    programView: "list",
    mealSearch: config.mealSearch || "",
    mealCategory: "ALL_CATEGORIES",
    programSearch: config.programSearch || "",
    programFilter: "ALL_PROTOCOLS",
    
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

    get filteredPrograms() {
        return this.programs.filter(p => {
            const matchesSearch = !this.programSearch || p.title.toLowerCase().includes(this.programSearch.toLowerCase());
            
            let matchesFilter = true;
            if (this.programFilter === 'ACTIVE') matchesFilter = p.clients_count > 0;
            if (this.programFilter === 'UNUSED') matchesFilter = p.clients_count === 0;
            if (this.programFilter === 'HIGH_DENSITY') matchesFilter = p.items_count >= 5;
            
            return matchesSearch && matchesFilter;
        });
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
        if (!item) return "Select Meal";
        let m = this.meals.find(m => m.id == item.meal_id);
        return m ? m.name : "Unknown Meal";
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
    },

    // Delete Matrix State
    showDeleteModal: false,
    programToDelete: null,
    openDeleteModal(p) {
        this.programToDelete = p;
        this.showDeleteModal = true;
    },
    executeDelete() {
        if (this.programToDelete) {
            this.$refs.deleteForm.action = `/coach/nutrition/programs/${this.programToDelete.id}`;
            this.$refs.deleteForm.submit();
        }
    }
});
