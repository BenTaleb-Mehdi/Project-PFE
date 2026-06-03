import { createIcons, icons } from 'lucide'

export const clientRegistry = (config) => ({
    init() {
        createIcons({ icons });
    },
    showAssignModal: false,
    selectedClient: null,
    showClientModal: false,
    isEditing: false,
    editingClientId: null,
    newClient: { name: "", email: "", phone_number: "", target_goal: "", current_weight: "", height: "", status: "active" },
    previewImage: null,
    
    // Assignment State
    protocolOpen: false,
    protocolSearch: "",
    protocols: config.protocols || [],
    selectedProtocol: { id: null, title: "Select Nutrition Protocol" },
    
    get filteredProtocols() {
        if (this.protocolSearch === "") return this.protocols;
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
            this.newClient = { name: "", email: "", phone_number: "", target_goal: "", current_weight: "", height: "", status: "active" };
        }
        this.showClientModal = true;
    },

    isDeleteModalOpen: false,
    clientToDelete: null,
    confirmDelete(client) {
        this.clientToDelete = client;
        this.isDeleteModalOpen = true;
    },

    searchQuery: config.searchQuery || "",
    filterStatus: config.filterStatus || "ALL_STATUSES",
    expandedClientIds: [],
});
