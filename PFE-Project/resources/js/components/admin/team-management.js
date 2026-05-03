import { createIcons, icons } from 'lucide'

export const teamManagement = (config) => ({
    init() {
        createIcons({ icons });
    },
    isAddMemberModalOpen: false,
    searchQuery: config.searchQuery || "",
    filterSpec: config.filterSpec || "ALL_SPECIALIZATIONS",
    
    isEditModalOpen: false,
    editingMember: { id: "", name: "", email: "", specialties: [], status: "active", phone_number: "" },
    isDeleteModalOpen: false,
    memberToDelete: null,
    
    isSpecialtyModalOpen: false,
    editingSpecialty: { id: null, name: "" },
    
    openEditModal(staff) {
        this.editingMember = {
            id: staff.id,
            name: staff.user.name,
            email: staff.user.email,
            specialties: staff.specialties.map(s => s.id),
            status: staff.status || "active",
            phone_number: staff.phone_number || ""
        };
        this.isEditModalOpen = true;
    },
    confirmDelete(staff) {
        this.memberToDelete = staff;
        this.isDeleteModalOpen = true;
    }
});
