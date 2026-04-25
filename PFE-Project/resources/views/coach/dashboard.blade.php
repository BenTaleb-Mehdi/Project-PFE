@extends('layouts.dashboard')

@section('title', 'Dashboard Overview')
@section('header_title', 'Dashboard')
@section('header_subtitle', 'Operational Intel // System Sync Active')

@section('content')
    <!-- Navbar Molecule -->
    <div class="mb-12">
        <nav class="bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full overflow-x-auto">
            <div class="flex items-center px-6">
                <div class="flex space-x-8 h-12">
                    <a href="#" class="flex items-center h-full text-[10px] font-bold uppercase tracking-widest text-cyan-600 border-b-2 border-cyan-600 transition-all font-sans">
                        Overview
                        <span class="ml-2 px-1.5 py-0.5 bg-cyan-50 text-cyan-700 font-mono text-[9px] border border-cyan-100">MTD</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 font-sans">
        <!-- KPI Card (Revenue) -->
        <div class="ag-card p-8 group transition-all duration-300">
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
        <div class="ag-card p-8 group transition-all duration-300">
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
        <div class="ag-card p-8 group transition-all duration-300">
            <p class="text-[10px] text-zinc-400 uppercase tracking-widest mb-4">Compliance Index</p>
            <div class="flex items-baseline space-x-2 font-mono">
                <span class="text-3xl font-bold text-emerald-600">{{ $complianceIndex }}%</span>
            </div>
            <p class="text-[8px] text-zinc-400 mt-4 uppercase font-mono">Calculated Log Sync (7D)</p>
        </div>
    </div>

    <!-- Bottom Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 font-mono">
        <div class="ag-card p-8">
            <h3 class="text-xs font-bold uppercase tracking-widest mb-8 border-b border-zinc-100 pb-4 flex justify-between">
                <span>System Stream</span>
                <span class="text-[8px] animate-pulse text-cyan-600">Live</span>
            </h3>
            <div class="space-y-6">
                @forelse($systemStream as $event)
                    <div class="flex items-start space-x-4">
                        <div class="w-2 h-2 {{ $event['type'] === 'REGISTRATION' ? 'bg-cyan-600' : 'bg-emerald-600' }} mt-1"></div>
                        <div>
                            <p class="text-xs uppercase font-bold">{{ $event['title'] }}</p>
                            <p class="text-[10px] text-zinc-500 mt-1">{{ $event['desc'] }}</p>
                            <p class="text-[8px] text-zinc-400 mt-1 uppercase font-mono">{{ \Carbon\Carbon::parse($event['time'])->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center py-8 text-zinc-300">
                        <i data-lucide="radio" class="size-6 mb-2 opacity-20"></i>
                        <p class="text-[10px] uppercase font-mono">No Recent Traffic</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="ag-card p-8 flex flex-col justify-center items-center text-center">
            <div class="h-16 w-16 border border-zinc-100 flex items-center justify-center mb-6">
                <i data-lucide="shield-check" class="h-8 w-8 text-cyan-600"></i>
            </div>
            <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-950">Coach Safe Core</h4>
            <p class="text-[10px] text-zinc-400 mt-2 uppercase">Integrity check: 100% // No conflicts found</p>
        </div>
    </div>
@endsection
