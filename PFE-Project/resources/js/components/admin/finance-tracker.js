import { createIcons, icons } from 'lucide'

export const financeTracker = (config) => ({
    init() {
        createIcons({ icons });
    },
    isAddPaymentModalOpen: false,
    searchQuery: config.searchQuery || "",
    filterStatus: config.filterStatus || "ALL_TRANSACTIONS",
    
    isEditModalOpen: false,
    editingTxn: { id: "", date: "", pupil: "", amount: 0, status: "paid" },
    isDeleteModalOpen: false,
    txnToDelete: null,

    openEditModal(txn) {
        this.editingTxn = {
            id: txn.id,
            date: txn.date,
            client_id: txn.client_id,
            pupil: txn.client.user.name,
            amount: txn.amount,
            status: txn.status
        };
        this.isEditModalOpen = true;
    },
    confirmDelete(txn) {
        this.txnToDelete = txn;
        this.isDeleteModalOpen = true;
    },

    // Pupil Selection (Add Modal)
    pupilOpen: false,
    pupilSearch: "",
    selectedPupil: { id: "", name: "Select_Pupil" },
    pupils: config.pupils || [],
    
    get filteredPupils() {
        if (this.pupilSearch === "") return this.pupils;
        return this.pupils.filter(c => c.name.toLowerCase().includes(this.pupilSearch.toLowerCase()));
    }
});
