<!-- KPI Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
    <!-- Morning Weight -->
    <div class="ag-card p-8 bg-white overflow-hidden relative">
        <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Morning Weight</p>
        <div class="flex items-baseline space-x-2">
            <span class="text-3xl font-mono font-bold text-cyan-700">{{ $biometrics['weight'] }}</span>
            <span class="text-xs font-mono text-zinc-400 uppercase">KG</span>
        </div>
        <div class="mt-4 flex items-center justify-between">
           
            <p class="text-[7px] font-mono text-zinc-300 uppercase tracking-widest">Last Sync: {{ $latest ? \Carbon\Carbon::parse($latest->recorded_at)->diffForHumans() : 'N/A' }}</p>
        </div>
    </div>
    
    <!-- Weekly Compliance -->
    <div class="ag-card p-8 bg-white">
        <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Weekly Compliance</p>
        <div class="flex items-baseline space-x-2">
            <span class="text-3xl font-mono font-bold text-zinc-900">{{ $biometrics['compliance'] }}%</span>
        </div>
        <div class="w-full bg-zinc-100 h-1 mt-6">
            <div class="bg-cyan-600 h-1" style="width: {{ $biometrics['compliance'] }}%"></div>
        </div>
    </div>

    <!-- Streak Status -->
    <div class="ag-card p-8 bg-white border-emerald-100/50">
        <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Streak Status</p>
        <div class="flex items-baseline space-x-2">
            <span class="text-3xl font-mono font-bold text-cyan-600">{{ $biometrics['streak'] }} Days</span>
        </div>
        <p class="text-[8px] font-mono text-zinc-400 mt-4 uppercase tracking-[0.2em]">Unbroken Record</p>
    </div>
</div>
