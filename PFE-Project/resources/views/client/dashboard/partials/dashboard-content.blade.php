<!-- Bio-Metric Analytics Quick View -->
<div class="ag-card p-10 bg-white relative overflow-hidden group shadow-sm">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h4 class="text-[10px] font-mono font-bold uppercase tracking-[0.4em] text-zinc-900">Mass Trajectory</h4>
            <p class="text-[8px] font-mono text-zinc-400 uppercase mt-1">7-Day Bio-Sync History</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="text-[8px] font-mono font-bold text-cyan-600 uppercase tracking-widest">Active Link</span>
        </div>
    </div>
    <div class="h-[120px] w-full">
        <canvas id="dashboardWeightChart"></canvas>
    </div>
</div>

<!-- Next Meal Focus -->
@if($programData['program_title'] !== 'NO_ACTIVE_PROTOCOL')
<div x-show="nextMeal" class="ag-card bg-white border border-zinc-200 shadow-[12px_12px_0px_0px_rgba(0,0,0,0.04)] relative overflow-hidden group transition-all duration-300">
    
    <!-- Top System Status Strip -->
    <div class="px-6 py-3 bg-zinc-950 text-white flex justify-between items-center border-b border-zinc-900">
        <div class="flex items-center gap-2">
            <span class="h-1.5 w-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
            <span class="text-[9px] font-mono font-bold uppercase tracking-[0.3em]" x-text="'LIVE PROTOCOL NODE // ' + nextMeal?.cat"></span>
        </div>
        <span class="text-[9px] font-mono text-zinc-500 uppercase tracking-widest hidden sm:inline">SYS.ACTIVE</span>
    </div>
    
    <!-- Core Content Block -->
    <div class="p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        
        <!-- Left Wing: Node Meta & Target Clock -->
        <div class="flex items-start gap-4 sm:gap-5">
            <div class="h-14 w-14 bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600 shrink-0 shadow-[4px_4px_0px_0px_rgba(6,182,212,0.1)]">
                <i data-lucide="zap" class="size-6 animate-pulse"></i>
            </div>
            <div>
                <p class="text-[8px] font-mono font-bold text-zinc-400 uppercase tracking-[0.4em] mb-1">Next Scheduled Node</p>
                <h3 class="text-xl sm:text-2xl font-mono font-bold text-zinc-900 uppercase tracking-tighter leading-tight" x-text="nextMeal?.menu"></h3>
                
                <!-- Target Time Metric Window -->
                <div class="flex items-center gap-3 mt-3">
                    <div class="flex items-center gap-1.5 px-2.5 py-0.5 bg-zinc-100 border border-zinc-200 text-zinc-800 rounded-sm">
                        <i data-lucide="clock" class="size-3 text-zinc-500"></i>
                        <span class="text-[10px] font-mono font-bold" x-text="nextMeal?.time"></span>
                    </div>
                    <span class="text-[8px] font-mono font-bold text-zinc-400 uppercase tracking-wider">Target Execution Window</span>
                </div>
            </div>
        </div>

        <!-- Right Wing: System Actions -->
        <div class="flex items-center gap-3 w-full md:w-auto justify-end border-t border-zinc-100 pt-4 md:border-t-0 md:pt-0">
            <form action="{{ route('client.meals.validate') }}" method="POST" class="m-0 flex-1 md:flex-initial">
                @csrf
                <input type="hidden" name="program_item_id" :value="nextMeal?.id">
                <button type="submit" 
                        class="w-full md:w-auto px-5 py-3.5 bg-cyan-600 text-white text-[10px] font-mono font-bold uppercase tracking-widest hover:bg-cyan-700 transition-all shadow-[6px_6px_0px_0px_rgba(8,145,178,0.1)] active:scale-95 flex items-center justify-center gap-2 whitespace-nowrap">
                    <i data-lucide="check-circle" class="size-4"></i>
                    Validate Node
                </button>
            </form>
            
            <a href="{{ route('client.programs.index') }}" 
               class="h-11 w-11 bg-zinc-950 border border-zinc-900 flex items-center justify-center text-white hover:bg-cyan-600 hover:border-cyan-600 transition-all duration-300 shadow-[6px_6px_0px_0px_rgba(0,0,0,0.05)] active:scale-95 group/btn shrink-0">
                <i data-lucide="arrow-right" class="size-5 group-hover/btn:translate-x-0.5 transition-transform"></i>
            </a>
        </div>
    </div>
</div>
@else
<!-- Empty/Pending Diagnostic Panel -->
<div class="ag-card p-8 sm:p-12 bg-zinc-50/50 border border-dashed border-zinc-200 text-center relative overflow-hidden group shadow-inner">
    <div class="max-w-md mx-auto flex flex-col items-center">
        <div class="h-14 w-14 bg-white ag-border border-zinc-200 flex items-center justify-center mb-5 text-zinc-400 shadow-sm relative group-hover:scale-105 transition-transform duration-500">
            <i data-lucide="shield-alert" class="size-5 text-zinc-400 group-hover:text-amber-500 transition-colors"></i>
        </div>
        <h3 class="text-base font-mono font-bold text-zinc-900 uppercase tracking-[0.2em] mb-2">Protocol Pending</h3>
        <p class="text-[11px] font-mono text-zinc-400 uppercase tracking-[0.1em] max-w-xs leading-relaxed mb-6">
            Awaiting coach deployment. Your personalized nutrition protocol is currently being calibrated in the central hub.
        </p>
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-50 border border-amber-100/70 text-amber-700">
            <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
            <span class="text-[8px] font-mono font-bold uppercase tracking-widest">Awaiting Nexus Sync</span>
        </div>
    </div>
</div>
@endif

<!-- Active Protocol Snippet -->

