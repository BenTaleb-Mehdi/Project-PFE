<!-- KPI Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8 sm:mb-12 font-sans">
    <!-- KPI Card (Revenue) -->
    <div class="ag-card p-5 sm:p-8 group transition-all duration-300">
        <p class="text-[10px] text-zinc-400 uppercase tracking-widest mb-4">Total Revenue MTD</p>
        <div class="flex items-baseline space-x-2 font-mono">
            <span class="text-3xl font-bold text-cyan-700">{{ $financeMetrics['total_revenue_mtd'] }}</span>
            <span class="text-xs text-zinc-400 uppercase">MAD</span>
        </div>
        <div class="mt-4 flex items-center text-[9px] uppercase font-mono">
            @if(str_contains($financeMetrics['growth_mtd'], '+'))
                <span class="text-emerald-600 flex items-center">
                    <i data-lucide="trending-up" class="h-3 w-3 mr-1"></i>
                    {{ $financeMetrics['growth_mtd'] }} vs prev month
                </span>
            @else
                <span class="text-red-500 flex items-center">
                    <i data-lucide="trending-down" class="h-3 w-3 mr-1"></i>
                    {{ $financeMetrics['growth_mtd'] }} vs prev month
                </span>
            @endif
        </div>
    </div>
    
    <!-- KPI Card (Pupils) -->
    <div class="ag-card p-5 sm:p-8 group transition-all duration-300">
        <p class="text-[10px] text-zinc-400 uppercase tracking-widest mb-4">Pupils Performance Cap</p>
        <div class="flex items-baseline space-x-2 font-mono">
            <span class="text-3xl font-bold text-cyan-700">{{ $activePupils }}</span>
            <span class="text-xs text-zinc-400 uppercase">Active / {{ $totalPupils }}</span>
        </div>
        <div class="w-full bg-zinc-100 h-1 mt-6">
            <div class="bg-cyan-600 h-1 transition-all duration-500" style="width: {{ $pupilsPercent }}%"></div>
        </div>
    </div>

    <!-- KPI Card (Compliance) -->
    <div class="ag-card p-5 sm:p-8 group transition-all duration-300">
        <p class="text-[10px] text-zinc-400 uppercase tracking-widest mb-4">Compliance Index</p>
        <div class="flex items-baseline space-x-2 font-mono">
            <span class="text-3xl font-bold text-emerald-600">{{ $complianceIndex }}%</span>
        </div>
        <p class="text-[8px] text-zinc-400 mt-4 uppercase font-mono">Calculated Log Sync (7D)</p>
    </div>
</div>
