@extends('layouts.client')

@section('title', 'Dashboard Overview')

@section('content')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div x-data='clientDashboard({ 
    history: @json($history), 
    programMeals: @json($programData["meals"] ?? []) 
})'>
    
    <!-- DASHBOARD VIEW -->
    <div class="space-y-8 sm:space-y-12">
        <header class="mb-8 sm:mb-12">
            <h1 class="text-xl sm:text-3xl font-mono font-bold text-zinc-900 uppercase tracking-tighter">Dashboard</h1>
            <p class="text-[9px] sm:text-[10px] font-mono text-zinc-400 uppercase tracking-[0.4em] mt-2">Pupil Intel // Progress Sync Active</p>
        </header>

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
                    <div class="flex items-center text-[9px] font-mono uppercase {{ $biometrics['trend'] === 'DECREASING' ? 'text-emerald-600' : ($biometrics['trend'] === 'INCREASING' ? 'text-rose-600' : 'text-zinc-400') }}">
                        <i data-lucide="{{ $biometrics['trend'] === 'DECREASING' ? 'trending-down' : ($biometrics['trend'] === 'INCREASING' ? 'trending-up' : 'minus') }}" class="h-3 w-3 mr-1"></i>
                        {{ $biometrics['trend'] }}
                    </div>
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
                    <span class="text-3xl font-mono font-bold text-emerald-600">{{ $biometrics['streak'] }} Days</span>
                </div>
                <p class="text-[8px] font-mono text-zinc-400 mt-4 uppercase tracking-[0.2em]">Unbroken Record</p>
            </div>
        </div>

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
        <div x-show="nextMeal" class="ag-card p-[1px] bg-gradient-to-br from-cyan-500 via-zinc-800 to-zinc-950 border-none shadow-2xl group transition-all duration-500 hover:shadow-cyan-900/20">
            <div class="bg-white p-5 sm:p-8 flex flex-col gap-6 relative overflow-hidden">
                <!-- Background Accent Blur -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 h-48 w-48 bg-cyan-50/50 rounded-full blur-3xl group-hover:bg-cyan-100/50 transition-colors duration-700"></div>

                <!-- Top row: icon + meal info -->
                <div class="flex items-center gap-4 sm:gap-6 relative z-10">
                    <div class="h-12 w-12 sm:h-16 sm:w-16 bg-zinc-950 flex items-center justify-center text-cyan-500 shadow-[4px_4px_0px_0px_rgba(8,145,178,0.2)] group-hover:shadow-cyan-500/40 transition-all duration-300 shrink-0">
                        <i data-lucide="zap" class="size-6 sm:size-8 animate-pulse"></i>
                    </div>
                    <div>
                        <p class="text-[8px] font-mono font-bold text-cyan-600 uppercase tracking-[0.5em] mb-1">Next Scheduled Node</p>
                        <h3 class="text-xl sm:text-3xl font-mono font-bold text-zinc-950 uppercase tracking-tighter leading-none" x-text="nextMeal?.menu"></h3>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            <span class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest" x-text="'Sequence Active // ' + nextMeal?.cat"></span>
                        </div>
                    </div>
                </div>

                <!-- Bottom row: time + actions -->
                <div class="flex flex-wrap items-center gap-4 relative z-10">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="clock" class="size-3 text-cyan-600"></i>
                            <p class="text-xl sm:text-2xl font-mono font-bold text-zinc-950 tracking-tighter" x-text="nextMeal?.time"></p>
                        </div>
                        <p class="text-[8px] font-mono text-zinc-400 font-bold uppercase tracking-[0.2em]">Target Window</p>
                    </div>
                    
                    <div class="flex items-center gap-3 ml-auto">
                        <form action="{{ route('client.meals.validate') }}" method="POST">
                            @csrf
                            <input type="hidden" name="program_item_id" :value="nextMeal?.id">
                            <button type="submit" 
                                    class="px-4 sm:px-6 py-3 sm:py-4 bg-zinc-950 text-white text-[10px] font-mono font-bold uppercase tracking-widest hover:bg-cyan-600 transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-95 flex items-center gap-2">
                                <i data-lucide="check-circle" class="size-3.5"></i>
                                Validate Node
                            </button>
                        </form>
                        
                        <a href="{{ route('client.programs.index') }}" 
                           class="h-12 w-12 sm:h-14 sm:w-14 bg-zinc-50 border border-zinc-200 flex items-center justify-center text-zinc-950 hover:bg-zinc-950 hover:text-white hover:border-zinc-950 transition-all duration-300 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] active:scale-95 group/btn">
                            <i data-lucide="arrow-right" class="size-5 sm:size-6 group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="ag-card p-10 bg-white border border-dashed border-zinc-200 text-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-zinc-50/50 to-white -z-10"></div>
            <div class="h-20 w-20 bg-zinc-50 border border-zinc-100 flex items-center justify-center mx-auto mb-6 text-zinc-200 group-hover:scale-110 transition-transform duration-700">
                <i data-lucide="shield-alert" class="size-10"></i>
            </div>
            <h3 class="text-xl font-mono font-bold text-zinc-900 uppercase tracking-widest mb-2">Protocol Pending</h3>
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-[0.2em] max-w-sm mx-auto leading-relaxed">
                Awaiting coach deployment. Your personalized nutrition protocol is currently being calibrated in the central hub.
            </p>
            <div class="mt-8 flex justify-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="text-[8px] font-mono font-bold text-zinc-400 uppercase tracking-widest">Awaiting Sync</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Active Protocol Snippet -->
        @if($programData['program_title'] !== 'NO_ACTIVE_PROTOCOL')
        <div class="ag-card p-6 sm:p-8 bg-cyan-900 border-none text-white overflow-hidden relative">
            <div class="relative z-10 flex flex-col sm:flex-row justify-between sm:items-end gap-6">
                <div>
                    <p class="text-[10px] font-mono text-cyan-300 uppercase tracking-[0.3em] mb-4">Active Protocol Lock</p>
                    <h4 class="text-2xl sm:text-3xl font-bold font-mono tracking-tight uppercase">{{ $programData['program_title'] }}</h4>
                    <p class="text-[8px] text-cyan-500 font-mono mt-2 uppercase tracking-widest">{{ $programData['items_count'] }} Meal Nodes // Sync Active</p>
                </div>
                <div class="flex gap-4">
                    <div class="p-4 bg-white/5 ag-border border-white/10 text-center flex-1 sm:flex-none">
                        <p class="text-[6px] text-cyan-400 uppercase font-mono mb-1">Target Kcal</p> 
                        <p class="text-xl font-bold font-mono">{{ $programData['dailyMacros']['kcal'] }}</p>
                    </div>
                    <div class="p-4 bg-white/5 ag-border border-white/10 text-center flex-1 sm:flex-none text-emerald-400">
                        <p class="text-[6px] text-cyan-400 uppercase font-mono mb-1">Target P</p> 
                        <p class="text-xl font-bold font-mono">{{ $programData['dailyMacros']['p'] }}g</p>
                    </div>
                </div>
            </div>
            <i data-lucide="zap" class="absolute -right-12 -bottom-12 size-48 text-cyan-800 opacity-20"></i>
        </div>
        @else
        <div class="p-12 text-center ag-card bg-zinc-50 border-dashed border-zinc-200">
            <i data-lucide="package-search" class="size-8 text-zinc-300 mx-auto mb-4"></i>
            <p class="text-[10px] text-zinc-500 uppercase font-mono tracking-widest">No Active Protocol Found</p>
        </div>
        @endif
    </div>
</div>
@endsection
