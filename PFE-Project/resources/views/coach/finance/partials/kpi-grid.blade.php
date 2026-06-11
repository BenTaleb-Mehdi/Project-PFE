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
