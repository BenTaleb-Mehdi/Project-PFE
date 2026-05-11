@extends('layouts.dashboard')

@section('title', 'Finance Control')
@section('header_title', 'Financial Flows')
@section('header_subtitle', 'Revenue Control // Transaction Log V3.0')

@section('content')
<div x-data='financeTracker({ 
    searchQuery: "{{ request("search") }}",
    filterStatus: "{{ request("status", "ALL_TRANSACTIONS") }}",
    pupils: {{ $clients->map(fn($c) => ["id" => $c->id, "name" => $c->user->name])->toJson() }}
})'>

    <!-- Action Header -->
    <div class="mb-8 lg:flex lg:justify-end font-mono">
        <button @click="isAddPaymentModalOpen = true"
                class="px-6 py-3 bg-zinc-950 text-white text-[10px] uppercase font-bold tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center gap-x-2">
            <i data-lucide="plus" class="size-3"></i>
            Add Payment
        </button>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 font-sans">
        <div class="ag-card p-6 border border-zinc-200 bg-white">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Total Revenue MTD</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-cyan-700">{{ $metrics['total_revenue_mtd'] }}</span>
                <span class="text-[10px] text-zinc-400 uppercase tracking-widest">MAD</span>
            </div>
        </div>
        <div class="ag-card p-6 border border-zinc-200 bg-white">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Pending Syncs</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-amber-600">{{ $metrics['pending_syncs'] }}</span>
            </div>
        </div>
        <div class="ag-card p-6 border border-zinc-200 bg-white">
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Growth MTD</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-2xl font-bold text-emerald-600">{{ $metrics['growth_mtd'] }}</span>
            </div>
        </div>
    </div>

    <!-- Discovery Bar -->
    <div class="ag-card p-4 bg-white mb-6 border border-zinc-200 flex flex-col md:flex-row gap-4 items-center">
        <form action="{{ route('coach.finance') }}" method="GET" class="relative flex-1 w-full text-zinc-900 font-mono">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Transactions (Pupil, ID)..." 
                   class="w-full bg-zinc-50 border border-zinc-200 px-10 py-2.5 text-[10px] uppercase tracking-widest focus:outline-none focus:border-cyan-600 rounded-none transition-colors">
            <i data-lucide="search" class="absolute left-3.5 top-3 size-3.5 text-zinc-400"></i>
        </form>

        <div class="relative w-full md:w-64" x-data="{ open: false }">
            <button @click="open = !open" 
                    @click.away="open = false"
                    class="w-full flex justify-between items-center bg-zinc-50 border border-zinc-200 px-4 py-2.5 text-[10px] font-mono uppercase tracking-widest text-zinc-500 hover:text-zinc-900 transition-colors">
                <span x-text="filterStatus.replace('_', ' ')"></span>
                <i data-lucide="chevron-down" class="size-3 transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-cloak
                 class="absolute right-0 mt-1 z-[100] bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-[256px] font-mono uppercase">
                <div class="py-1">
                    @foreach(['ALL_TRANSACTIONS', '_PAID', '_PENDING'] as $opt)
                        <a href="{{ route('coach.finance', ['status' => $opt, 'search' => request('search')]) }}"
                           class="w-full text-left flex items-center px-4 py-2 text-[10px] border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 hover:bg-zinc-50 transition-all {{ request('status', 'ALL_TRANSACTIONS') === $opt ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500' }}">
                            {{ str_replace('_', ' ', $opt) }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="ag-card overflow-hidden bg-white border border-zinc-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse font-sans font-medium">
                <thead class="bg-zinc-50 border-b border-zinc-200 uppercase font-mono tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">TXN ID</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Date</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Pupil</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Amount</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 uppercase">
                    @foreach($transactions as $txn)
                        <tr class="hover:bg-zinc-50/50 transition-colors">
                            <td class="px-6 py-4 text-[10px] font-mono text-cyan-700 font-bold">#{{ $txn->id }}</td>
                            <td class="px-6 py-4 text-[10px] text-zinc-400 font-mono">{{ $txn->date }}</td>
                            <td class="px-6 py-4 text-[10px] text-zinc-900 font-bold tracking-tight">{{ $txn->client->user->name }}</td>
                            <td class="px-6 py-4 text-[10px] font-mono text-zinc-900 font-bold">{{ number_format($txn->amount, 0) }} MAD</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-[8px] font-bold border font-mono {{ $txn->status === 'paid' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                                    {{ strtoupper($txn->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('coach.finance.receipt.download', $txn->id) }}" class="p-2 text-zinc-400 hover:text-cyan-600 transition-colors" title="Download Receipt PDF"><i data-lucide="file-text" class="size-3.5"></i></a>
                                    <button @click="openEditModal({{ json_encode($txn->load('client.user')) }})" class="p-2 text-zinc-400 hover:text-cyan-600 transition-colors"><i data-lucide="edit-3" class="size-3.5"></i></button>
                                    <button @click="confirmDelete({{ json_encode(['id' => $txn->id, 'name' => $txn->client->user->name]) }})" class="p-2 text-zinc-400 hover:text-red-600 transition-colors"><i data-lucide="trash-2" class="size-3.5"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-8 font-mono">
        {{ $transactions->appends(request()->query())->links() }}
    </div>

    <!-- Modals -->
    <!-- Add Payment Modal -->
    <div x-show="isAddPaymentModalOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
        <form action="{{ route('coach.finance.store') }}" method="POST"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4 scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 scale-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 translate-y-0 scale-100"
              x-transition:leave-end="opacity-0 translate-y-2"
              @click.outside="isAddPaymentModalOpen = false"
              class="relative bg-white w-full max-w-lg border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] p-8 font-mono">
            @csrf
            <header class="mb-8 font-sans">
                <h2 class="text-xl font-bold tracking-tight uppercase text-zinc-900">Add New Transaction</h2>
                <p class="text-[8px] text-cyan-700 uppercase tracking-widest font-mono mt-1">Pupil Payment Sync V3.0</p>
            </header>
            <div class="space-y-6">
                <!-- Pupil Selection -->
                <div class="space-y-1.5 font-sans relative">
                    <label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">Select Pupil</label>
                    <input type="hidden" name="client_id" :value="selectedPupil.id">
                    <button type="button" @click="pupilOpen = !pupilOpen" 
                            class="w-full flex justify-between items-center text-[10px] p-3 bg-zinc-50 border border-zinc-200 uppercase font-sans text-cyan-700">
                        <span x-text="selectedPupil.name"></span>
                        <i data-lucide="chevron-down" class="size-4" :class="pupilOpen ? 'rotate-180' : ''"></i>
                    </button>
                    
                    <div x-show="pupilOpen" @click.away="pupilOpen = false" x-cloak
                         class="absolute z-[120] left-0 right-0 mt-1 bg-white border border-zinc-200 shadow-xl max-h-64 overflow-hidden flex flex-col uppercase font-mono">
                        <!-- Search Box -->
                        <div class="p-3 bg-white border-b border-zinc-200 flex items-center gap-x-2 focus-within:bg-zinc-50/50 transition-all">
                            <i data-lucide="search" class="size-3 text-zinc-400"></i>
                            <input type="text" x-model="pupilSearch" placeholder="Type to filter..." 
                                   class="w-full bg-transparent border-none focus:ring-0 text-[10px] uppercase font-mono placeholder:text-zinc-300 p-0">
                        </div>
                        
                        <!-- List -->
                        <div class="overflow-y-auto max-h-48 divide-y divide-zinc-50">
                            <template x-for="client in filteredPupils" :key="client.id">
                                <div @click="selectedPupil = { id: client.id, name: client.name }; pupilOpen = false; pupilSearch = ''" 
                                     class="px-4 py-3 text-[10px] hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer border-l-2 border-transparent hover:border-cyan-600 transition-all text-zinc-500 font-bold flex justify-between items-center">
                                    <span x-text="client.name"></span>
                                    <span class="text-[8px] opacity-30" x-text="'#' + client.id"></span>
                                </div>
                            </template>
                            <div x-show="filteredPupils.length === 0" class="p-8 text-center text-[8px] text-zinc-400 italic">
                                Search Mismatch // No Pupil Found
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 font-sans">
                    <div class="space-y-1.5 font-mono">
                        <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Amount (MAD)</label>
                        <input type="number" name="amount" required class="w-full text-sm p-3 bg-zinc-50 border border-zinc-200 focus:border-cyan-600 outline-none text-cyan-700 font-bold">
                    </div>
                    <div class="space-y-1.5 font-mono">
                        <label class="text-[10px] text-zinc-400 uppercase tracking-widest">Transaction Date</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600">
                    </div>
                </div>

                <div class="space-y-1.5 font-sans">
                    <label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">Initial_Status</label>
                    <div class="flex space-x-3 uppercase">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="status" value="paid" class="hidden peer" checked>
                            <span class="px-4 py-2 bg-zinc-50 border border-zinc-200 text-[10px] font-bold peer-checked:bg-emerald-50 peer-checked:text-emerald-600 peer-checked:border-emerald-100 transition-all font-mono">_PAID</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="status" value="pending" class="hidden peer">
                            <span class="px-4 py-2 bg-zinc-50 border border-zinc-200 text-[10px] font-bold peer-checked:bg-amber-50 peer-checked:text-amber-600 peer-checked:border-amber-100 transition-all font-mono">_PENDING</span>
                        </label>
                    </div>
                </div>

                <div class="flex space-x-4 pt-4 font-sans">
                    <button type="submit" class="flex-1 h-11 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center justify-center gap-x-2">
                        <i data-lucide="check" class="size-3"></i>
                        Initialize Payment
                    </button>
                    <button type="button" @click="isAddPaymentModalOpen = false" class="h-11 px-6 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Edit Transaction Modal -->
    <div x-show="isEditModalOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
        <form :action="'{{ route('coach.finance') }}/' + editingTxn.id" method="POST"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4 scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 scale-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 translate-y-0 scale-100"
              x-transition:leave-end="opacity-0 translate-y-2"
              @click.outside="isEditModalOpen = false"
              class="relative bg-white w-full max-w-lg border border-zinc-200 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)] p-8 font-mono">
            @csrf
            @method('PUT')
            <header class="mb-8 font-sans">
                <h2 class="text-xl font-bold tracking-tight uppercase text-zinc-900">Edit Transaction</h2>
                <p class="text-[8px] text-cyan-700 uppercase tracking-widest font-mono mt-1">Update Fiscal Record // V3.0</p>
            </header>
            <div class="space-y-6">
                <div class="space-y-1.5 uppercase opacity-50">
                    <label class="text-[10px] text-zinc-400 tracking-widest">Pupil Name (Read Only)</label>
                    <input type="text" x-model="editingTxn.pupil" disabled class="w-full text-sm p-3 bg-zinc-100 border border-zinc-200 cursor-not-allowed">
                </div>

                <div class="grid grid-cols-2 gap-4 font-sans uppercase">
                    <div class="space-y-1.5 font-mono">
                        <label class="text-[10px] text-zinc-400 tracking-widest">Amount (MAD)</label>
                        <input type="number" name="amount" x-model="editingTxn.amount" required class="w-full text-sm p-3 bg-zinc-50 border border-zinc-200 focus:border-cyan-600 outline-none text-cyan-700 font-bold">
                    </div>
                    <div class="space-y-1.5 font-mono">
                        <label class="text-[10px] text-zinc-400 tracking-widest">Date</label>
                        <input type="date" name="date" x-model="editingTxn.date" required class="w-full text-[10px] p-3 bg-zinc-50 border border-zinc-200 outline-none focus:border-cyan-600">
                    </div>
                </div>

                <div class="space-y-1.5 font-sans">
                    <label class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">Current Status</label>
                    <div class="flex space-x-3">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="status" value="paid" x-model="editingTxn.status" class="hidden peer">
                            <span class="px-4 py-2 bg-zinc-50 border border-zinc-200 text-[10px] font-bold peer-checked:bg-emerald-50 peer-checked:text-emerald-600 peer-checked:border-emerald-100 transition-all font-mono uppercase">PAID</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="status" value="pending" x-model="editingTxn.status" class="hidden peer">
                            <span class="px-4 py-2 bg-zinc-50 border border-zinc-200 text-[10px] font-bold peer-checked:bg-amber-50 peer-checked:text-amber-600 peer-checked:border-amber-100 transition-all font-mono uppercase">PENDING</span>
                        </label>
                    </div>
                </div>

                <div class="flex space-x-4 pt-4 font-sans">
                    <button type="submit" class="flex-1 h-11 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,0.1)]">Save Modifications</button>
                    <button type="button" @click="isEditModalOpen = false" class="h-11 px-6 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="isDeleteModalOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
        <form :action="'{{ route('coach.finance') }}/' + (txnToDelete ? txnToDelete.id : '')" method="POST"
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
                    <h3 class="text-sm font-bold uppercase tracking-widest">Confirm Deletion</h3>
                    <p class="text-[8px] text-zinc-400 uppercase tracking-widest mt-0.5">FISCAL PURGE // RECORD REMOVAL</p>
                </div>
            </div>
            <p class="text-[10px] text-zinc-500 uppercase mb-8 leading-relaxed">
               Purging transaction <span class="font-bold text-zinc-950" x-text="txnToDelete ? '#' + txnToDelete.id : ''"></span> for <span class="font-bold text-zinc-950" x-text="txnToDelete ? txnToDelete.name : ''"></span>. Irreversible.
            </p>
            <div class="flex gap-4 font-sans">
                <button type="submit" class="flex-1 h-11 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">Execute Purge</button>
                <button type="button" @click="isDeleteModalOpen = false" class="px-6 h-11 bg-zinc-100 text-zinc-500 text-[10px] font-bold uppercase tracking-widest border border-zinc-200">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
