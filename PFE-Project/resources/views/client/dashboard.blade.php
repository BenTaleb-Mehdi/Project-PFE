@extends('layouts.client')

@section('title', 'Dashboard Overview')

@section('content')
<div x-data="{ 
    isLoggingOpen: false,
    activeView: 'dashboard'
}">
    
    <!-- DASHBOARD VIEW -->
    <div class="space-y-12">
        <header class="mb-12">
            <h1 class="text-3xl font-mono font-bold tracking-tight uppercase text-zinc-900">Dashboard</h1>
            <p class="text-[10px] font-mono text-zinc-400 mt-2 uppercase tracking-[0.2em]">Pupil Intel // Progress Sync Active</p>
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
                <div class="mt-4 flex items-center text-[9px] font-mono text-emerald-600 uppercase">
                    <i data-lucide="trending-down" class="h-3 w-3 mr-1"></i>
                    {{ $biometrics['trend'] }}
                </div>
            </div>
            
            <!-- Weekly Compliance -->
            <div class="ag-card p-8 bg-white">
                <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Weekly Compliance</p>
                <div class="flex items-baseline space-x-2">
                    <span class="text-3xl font-mono font-bold text-zinc-900">98%</span>
                </div>
                <div class="w-full bg-zinc-100 h-1 mt-6">
                    <div class="bg-cyan-600 h-1" style="width: 98%"></div>
                </div>
            </div>

            <!-- Streak Status -->
            <div class="ag-card p-8 bg-white border-emerald-100/50">
                <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-4">Streak Status</p>
                <div class="flex items-baseline space-x-2">
                    <span class="text-3xl font-mono font-bold text-emerald-600">14 Days</span>
                </div>
                <p class="text-[8px] font-mono text-zinc-400 mt-4 uppercase tracking-[0.2em]">Unbroken Record</p>
            </div>
        </div>

        <!-- Weight Update Pulse -->
        <div class="ag-card p-8 bg-white">
            <h3 class="text-xs font-mono font-bold uppercase tracking-widest mb-6 border-b border-zinc-100 pb-4">Weight Update Pulse</h3>
            <form action="{{ route('client.evolution.store') }}" method="POST" class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
                @csrf
                <div class="flex-1">
                    <label class="block text-[8px] font-mono text-zinc-400 uppercase tracking-widest mb-2">New Measurement (KG)</label>
                    <input type="number" step="0.1" name="weight" placeholder="00.0" 
                           class="w-full bg-zinc-50 px-4 py-4 text-xl font-mono font-bold ag-border outline-none focus:border-cyan-600 transition-all text-zinc-900 placeholder:text-zinc-200">
                </div>
                <input type="hidden" name="recorded_at" value="{{ date('Y-m-d') }}">
                <button type="submit" class="px-8 py-5 bg-zinc-950 text-white text-[10px] font-mono font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] h-[60px]">
                    Initialize Sync
                </button>
            </form>
        </div>

        <!-- Active Protocol Snippet -->
        @if($programData['program_title'] !== 'NO_ACTIVE_PROTOCOL')
        <div class="ag-card p-8 bg-cyan-900 border-none text-white overflow-hidden relative">
            <div class="relative z-10 flex flex-col md:flex-row justify-between md:items-end">
                <div>
                    <p class="text-[10px] font-mono text-cyan-300 uppercase tracking-[0.3em] mb-4">Active Protocol Lock</p>
                    <h4 class="text-3xl font-bold font-mono tracking-tight uppercase">{{ $programData['program_title'] }}</h4>
                    <p class="text-[8px] text-cyan-500 font-mono mt-2 uppercase tracking-widest">{{ $programData['items_count'] }} Meal Nodes // Sync Active</p>
                </div>
                <div class="mt-8 md:mt-0 flex gap-4">
                    <div class="p-4 bg-white/5 ag-border border-white/10 text-center flex-1 md:flex-none">
                        <p class="text-[6px] text-cyan-400 uppercase font-mono mb-1">Target Kcal</p> 
                        <p class="text-xl font-bold font-mono">{{ $programData['dailyMacros']['kcal'] }}</p>
                    </div>
                    <div class="p-4 bg-white/5 ag-border border-white/10 text-center flex-1 md:flex-none text-emerald-400">
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
