@extends('layouts.dashboard')

@section('title', 'Finance Control')
@section('header_title', 'Financial_Flows')
@section('header_subtitle', 'Revenue_Control // Transaction_Log_V3.0')

@section('content')
<div x-data="{ 
    isAddPaymentModalOpen: false,
    searchQuery: '',
    filterStatus: 'ALL_TRANSACTIONS',
    transactions: [
        { id: 'TRX-9412', date: '2026-03-01', pupil: 'Mehdi_Bensema', amount: 1200, status: 'Paid' },
        { id: 'TRX-9413', date: '2026-03-02', pupil: 'Yassine_RT', amount: 850, status: 'Pending' }
    ],
    isEditModalOpen: false,
    editingTxn: null,
    isDeleteModalOpen: false,
    txnToDelete: null,
    deleteIndex: null,

    openEditModal(txn) {
        this.editingTxn = JSON.parse(JSON.stringify(txn));
        this.isEditModalOpen = true;
    },
    saveEdit() {
        const index = this.transactions.findIndex(t => t.id === this.editingTxn.id);
        if (index !== -1) this.transactions[index] = this.editingTxn;
        this.isEditModalOpen = false;
    },
    confirmDelete(txn, index) {
        this.txnToDelete = txn;
        this.deleteIndex = index;
        this.isDeleteModalOpen = true;
    },
    executeDelete() {
        this.transactions.splice(this.deleteIndex, 1);
        this.isDeleteModalOpen = false;
    },
    toggleStatus(index) {
        this.transactions[index].status = this.transactions[index].status === 'Paid' ? 'Pending' : 'Paid';
    }
}">
    <!-- Action Header -->
    <div class="mb-8 flex justify-end">
        <button @click="isAddPaymentModalOpen = true"
                class="px-6 py-3 bg-zinc-950 text-white text-[10px] uppercase font-bold tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center gap-x-2 font-mono">
            <i data-lucide="plus" class="size-3"></i>
            Add_Payment
        </button>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 font-sans">
        <div class="ag-card p-6 border border-zinc-200">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Total_Revenue_MTD</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-cyan-700">42,500</span>
                <span class="text-[10px] text-zinc-400 uppercase tracking-widest">MAD</span>
            </div>
        </div>
        <div class="ag-card p-6 border border-zinc-200">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Pending_Syncs</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-amber-600">03</span>
            </div>
        </div>
        <div class="ag-card p-6 border border-zinc-200">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Growth_MTD</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-emerald-600">+12.4%</span>
            </div>
        </div>
    </div>

    <!-- Discovery Bar -->
    <div class="ag-card p-4 bg-white mb-6 border border-zinc-200 flex flex-col md:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full text-zinc-900">
            <input type="text" x-model="searchQuery" placeholder="Search_Transactions (Pupil, ID)..." 
                   class="w-full bg-zinc-50 border border-zinc-200 px-10 py-2.5 text-[10px] font-mono uppercase tracking-widest focus:outline-none focus:border-cyan-600 transition-colors">
            <i data-lucide="search" class="absolute left-3.5 top-3 size-3.5 text-zinc-400"></i>
        </div>

        <div class="relative w-full md:w-64" x-data="{ open: false }">
            <button @click="open = !open" 
                    class="w-full flex justify-between items-center bg-zinc-50 border border-zinc-200 px-4 py-2.5 text-[10px] font-mono uppercase tracking-widest text-zinc-500 hover:text-zinc-900 transition-colors">
                <span x-text="filterStatus.replace('_', ' ')"></span>
                <i data-lucide="chevron-down" class="size-3" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" @click.away="open = false" 
                 class="absolute right-0 mt-1 z-[100] bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-[256px]">
                <div class="py-1">
                    <template x-for="opt in ['ALL_TRANSACTIONS', '_PAID', '_PENDING']">
                        <button @click="filterStatus = opt; open = false" 
                                class="w-full text-left px-4 py-2 text-[10px] font-mono uppercase tracking-widest border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 hover:bg-zinc-50 transition-all"
                                :class="filterStatus === opt ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500'">
                            <span x-text="opt.replace('_', ' ')"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="ag-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse font-sans">
                <thead class="bg-zinc-50 border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono">TXN_ID</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono">Date</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono">Pupil</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono">Amount</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest font-mono text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    <template x-for="(txn, index) in transactions" :key="txn.id">
                        <tr class="hover:bg-zinc-50/50 transition-colors"
                            x-show="(searchQuery === '' || txn.pupil.toLowerCase().includes(searchQuery.toLowerCase()) || txn.id.toLowerCase().includes(searchQuery.toLowerCase())) && (filterStatus === 'ALL_TRANSACTIONS' || (filterStatus === '_PAID' && txn.status === 'Paid') || (filterStatus === '_PENDING' && txn.status === 'Pending'))">
                            <td class="px-6 py-4 text-[10px] font-mono text-cyan-700 font-bold" x-text="'#' + txn.id"></td>
                            <td class="px-6 py-4 text-[10px] text-zinc-500 uppercase font-mono" x-text="txn.date"></td>
                            <td class="px-6 py-4"><p class="text-[10px] font-bold text-zinc-900 uppercase" x-text="txn.pupil"></p></td>
                            <td class="px-6 py-4 text-[10px] font-mono text-zinc-900 font-bold" x-text="txn.amount.toLocaleString() + ' MAD'"></td>
                            <td class="px-6 py-4">
                                <button @click="toggleStatus(index)"
                                        class="px-2 py-1 text-[8px] font-bold uppercase border font-mono transition-all"
                                        :class="txn.status === 'Paid' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100'">
                                    <span x-text="'_' + txn.status.toUpperCase()"></span>
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <button @click="openEditModal(txn)" class="p-2 text-zinc-400 hover:text-cyan-600 transition-colors"><i data-lucide="edit-3" class="size-3.5"></i></button>
                                    <button @click="confirmDelete(txn, index)" class="p-2 text-zinc-400 hover:text-red-600 transition-colors"><i data-lucide="trash-2" class="size-3.5"></i></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modals -->
    <!-- Add Modal -->
    <div x-show="isAddPaymentModalOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/20 backdrop-blur-sm">
        <div @click.outside="isAddPaymentModalOpen = false" class="bg-white w-full max-w-lg border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] p-8">
            <header class="mb-8 font-sans">
                <h2 class="text-xl font-bold tracking-tight uppercase text-zinc-900">Add_New_Transaction</h2>
                <p class="text-[8px] text-cyan-700 uppercase tracking-widest font-mono mt-1">Pupil_Payment_Sync_V3.0</p>
            </header>
            <div class="space-y-6">
                <div class="space-y-4">
                    <div class="space-y-1.5"><label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest font-sans">Select_Pupil</label>
                        <input type="text" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 focus:border-cyan-600 font-sans" placeholder="Search by name or ID...">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5"><label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">Amount (MAD)</label>
                            <input type="number" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 focus:border-cyan-600 font-mono">
                        </div>
                        <div class="space-y-1.5"><label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">Date</label>
                            <input type="date" class="w-full text-[10px] p-2.5 bg-zinc-50 border border-zinc-200 focus:border-cyan-600 font-mono">
                        </div>
                    </div>
                </div>
                <div class="flex space-x-4 pt-4 font-sans">
                    <button class="flex-1 h-11 bg-zinc-900 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all">Initialize_Payment</button>
                    <button @click="isAddPaymentModalOpen = false" class="h-11 px-6 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200 hover:bg-zinc-200">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/20 backdrop-blur-sm">
        <div @click.outside="isEditModalOpen = false" class="bg-white w-full max-w-lg border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] p-8">
            <header class="mb-8 font-sans">
                <h2 class="text-xl font-bold tracking-tight uppercase text-zinc-900">Edit_Transaction</h2>
                <p class="text-[8px] text-cyan-700 uppercase tracking-widest font-mono mt-1">Update_Fiscal_Record // V3.0</p>
            </header>
            <div class="space-y-6" x-if="editingTxn">
                <div class="space-y-1.5"><label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest font-sans">Pupil_Name</label>
                    <input type="text" x-model="editingTxn.pupil" class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 focus:border-cyan-600 font-sans uppercase">
                </div>
                <div class="flex space-x-4 pt-4 font-sans">
                    <button @click="saveEdit()" class="flex-1 h-11 bg-zinc-900 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all">Update_Transaction</button>
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
                <h3 class="text-sm font-bold uppercase tracking-widest">Confirm Deletion</h3>
            </div>
            <p class="text-[10px] text-zinc-500 uppercase mb-8">Purge transaction <span class="font-bold text-zinc-950" x-text="txnToDelete ? '#' + txnToDelete.id : ''"></span>?</p>
            <div class="flex gap-4 font-sans">
                <button @click="executeDelete()" class="flex-1 h-11 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">Confirm_Delete</button>
                <button @click="isDeleteModalOpen = false" class="px-6 h-11 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection
