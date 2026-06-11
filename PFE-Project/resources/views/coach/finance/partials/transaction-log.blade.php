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
            <span>{{ str_replace('_', ' ', request('status', 'ALL_TRANSACTIONS')) }}</span>
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

<!-- Transaction Table (Desktop) -->
<div class="ag-card overflow-hidden bg-white border border-zinc-200 hidden md:block">
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
                        <td class="px-6 py-4 text-[10px] text-zinc-900 font-bold tracking-tight">{{ optional($txn->client)->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-[10px] font-mono text-zinc-900 font-bold">{{ number_format($txn->amount, 0) }} MAD</td>
                        <td class="px-6 py-4">
                            <!-- Tactical System Badges -->
                            @if(str_contains(strtoupper($txn->status ?? ''), 'PAID'))
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 font-mono text-[9px] font-bold uppercase tracking-wider border border-emerald-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Settled Node
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 font-mono text-[9px] font-bold uppercase tracking-wider border border-amber-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                    Pending Sync
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('coach.finance.receipt.download', $txn->id) }}" class="p-2 text-zinc-400 hover:text-cyan-600 transition-colors" title="Download Receipt PDF"><i data-lucide="file-text" class="size-3.5"></i></a>
                                <button @click="openEditModal({{ json_encode($txn->load('client.user')) }})" class="p-2 text-zinc-400 hover:text-cyan-600 transition-colors"><i data-lucide="edit-3" class="size-3.5"></i></button>
                                <button @click="confirmDelete({{ json_encode(['id' => $txn->id, 'name' => optional($txn->client)->user->name ?? 'N/A']) }})" class="p-2 text-zinc-400 hover:text-red-600 transition-colors"><i data-lucide="trash-2" class="size-3.5"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Transaction Cards (Mobile) -->
<div class="md:hidden space-y-3">
    @foreach($transactions as $txn)
        <div class="ag-card bg-white p-4 border border-zinc-200 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-mono text-cyan-700 font-bold">#{{ $txn->id }}</span>
                
                <!-- Mobile Adaptive Badge -->
                @if(str_contains(strtoupper($txn->status ?? ''), 'PAID'))
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 font-mono text-[8px] font-bold uppercase border border-emerald-200">
                        Paid
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-50 text-amber-700 font-mono text-[8px] font-bold uppercase border border-amber-200">
                        Pending
                    </span>
                @endif
            </div>
            <div class="flex items-center justify-between text-[10px]">
                <span class="text-zinc-400 font-mono">{{ $txn->date }}</span>
                <span class="text-zinc-900 font-bold">{{ optional($txn->client)->user->name ?? 'N/A' }}</span>
            </div>
            <div class="flex items-center justify-between pt-2 border-t border-zinc-100">
                <span class="text-xs font-mono text-zinc-900 font-bold">{{ number_format($txn->amount, 0) }} MAD</span>
                <div class="flex gap-3">
                    <a href="{{ route('coach.finance.receipt.download', $txn->id) }}" class="p-1.5 text-zinc-400 hover:text-cyan-600"><i data-lucide="file-text" class="size-3.5"></i></a>
                    <button @click="openEditModal({{ json_encode($txn->load('client.user')) }})" class="p-1.5 text-zinc-400 hover:text-cyan-600"><i data-lucide="edit-3" class="size-3.5"></i></button>
                    <button @click="confirmDelete({{ json_encode(['id' => $txn->id, 'name' => optional($txn->client)->user->name ?? 'N/A']) }})" class="p-1.5 text-zinc-400 hover:text-red-600"><i data-lucide="trash-2" class="size-3.5"></i></button>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-8 font-mono">
    {{ $transactions->appends(request()->query())->links() }}
</div>