@extends('layouts.app')

@section('title', 'Dashboard | Client')

@section('body_attributes')
    x-data="dashboardData({{ $clientId }})"
    x-init="fetchMetrics()"
@endsection

@section('content')
    {{-- LOADING --}}
    <div x-show="loading" x-cloak class="flex flex-col gap-4 mt-4 animate-pulse">
        <div class="bg-zinc-300 h-40 w-full"></div>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-zinc-200 h-28"></div>
            <div class="bg-zinc-200 h-28"></div>
        </div>
    </div>

    {{-- ERROR --}}
    <div x-show="error && !loading" x-cloak
        class="bg-red-100 text-red-600 text-xs p-4 font-bold uppercase tracking-widest mt-4">
        ⚠ <span x-text="error"></span>
    </div>

    {{-- DATA --}}
    <template x-if="metrics && !loading">
        <div class=" space-y-5">

            {{-- Protocol Status Card --}}
            <section>
                <div class="bg-ag-black p-6 shadow-sm relative overflow-hidden rounded-xl">
                    <div class="absolute right-0 bottom-0 opacity-10 blur-[1px]">
                        <svg class="h-40 w-40 text-white transform translate-x-12 translate-y-12" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 22h20L12 2zm0 4.6l5.2 10.4H6.8L12 6.6z"></path>
                        </svg>
                    </div>
                    <p class="text-[9px] text-[#A1A1AA] uppercase tracking-widest mb-[6px] font-bold">Current Status</p>
                    <div class="flex items-center justify-between mb-8 relative z-10">
                        <div>
                            <span class="text-xl font-bold text-white tracking-tight uppercase"
                                x-text="'Protocol_' + metrics.status"></span>
                            <p class="text-[10px] text-ag-cyan uppercase tracking-widest mt-1 font-bold"
                                x-text="'Target : ' + metrics.target_goal + ' KG'"></p>
                        </div>
                    </div>
                    <a href="/client/{{ $clientId }}/program" class="inline-flex items-center justify-between w-full bg-white text-ag-black py-3 px-4 text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-100 transition-colors relative z-10 rounded-xl">
                        <span>Access Daily Sequence</span>
                        <x-lucide-chevron-right class="h-3 w-3" />
                    </a>
                </div>
            </section>

            {{-- Stats Grid 1 --}}
            <section class="grid grid-cols-2 gap-4">
                {{-- Weight --}}
                <div class="bg-white border border-zinc-100 p-5 shadow-sm rounded-xl">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-[8px] text-zinc-400 font-bold uppercase tracking-widest">Weight Sync</span>
                        <x-lucide-scale class="h-3 w-3 text-zinc-300" />
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-zinc-900 tracking-tight" x-text="metrics.current_weight"></span>
                        <span class="text-[9px] font-bold text-ag-cyan tracking-widest">KG</span>
                    </div>
                    <p class="text-[8px] font-bold mt-2 uppercase tracking-widest"
                        :class="metrics.weight_change <= 0 ? 'text-green-500' : 'text-red-500'"
                        x-text="(metrics.weight_change > 0 ? '+' : '') + metrics.weight_change + ' KG'">
                    </p>
                </div>

                {{-- Streak --}}
                <div class="bg-white border border-zinc-100 p-5 shadow-sm rounded-xl">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-[8px] text-zinc-400 font-bold uppercase tracking-widest">Master Streak</span>
                        <x-lucide-flame class="h-3 w-3 text-orange-500" />
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-zinc-900 tracking-tight" x-text="metrics.streak"></span>
                        <span class="text-[9px] font-bold text-ag-cyan tracking-widest">DAYS</span>
                    </div>
                    <p class="text-[8px] text-zinc-400 font-bold mt-2 uppercase tracking-widest">Continuous Sync</p>
                </div>
            </section>

            {{-- Stats Grid 2 --}}
            <section class="grid grid-cols-2 gap-4">
                {{-- Adherence --}}
                <div class="bg-white border border-zinc-100 p-5 shadow-sm rounded-xl">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-[8px] text-zinc-400 font-bold uppercase tracking-widest">Adherence</span>
                        <x-lucide-check-circle class="h-3 w-3 text-emerald-500" />
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-zinc-900 tracking-tight" x-text="metrics.compliance"></span>
                        <span class="text-[9px] font-bold text-ag-cyan tracking-widest">%</span>
                    </div>
                    <p class="text-[8px] text-zinc-400 font-bold mt-2 uppercase tracking-widest">7_Day_Window</p>
                </div>

                {{-- Height --}}
                <div class="bg-white border border-zinc-100 p-5 shadow-sm rounded-xl">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-[8px] text-zinc-400 font-bold uppercase tracking-widest">Height</span>
                        <x-lucide-ruler class="h-3 w-3 text-zinc-300" />
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-zinc-900 tracking-tight" x-text="metrics.height"></span>
                        <span class="text-[9px] font-bold text-ag-cyan tracking-widest">CM</span>
                    </div>
                    <p class="text-[8px] text-zinc-400 font-bold mt-2 uppercase tracking-widest" x-text="metrics.client_name"></p>
                </div>
            </section>
            
            {{-- Weight Update Pulse --}}
            <section>
                <div class="bg-white border border-zinc-100 p-6 shadow-sm  rounded-xl">
                    <p class="text-[9px] text-zinc-400 uppercase tracking-widest mb-4 font-bold">Weight Update Pulse</p>
                    
                    <div class="flex gap-2 items-stretch h-12">
                        <div class="flex-1 h-full">
                            <input type="number" 
                                step="0.1" 
                                x-model="newWeight"
                                class="w-full h-full bg-ag-bg border-none px-4 text-lg font-bold tracking-tight focus:ring-1 focus:ring-ag-cyan outline-none text-zinc-900 rounded-xl"
                                placeholder="82.0">
                        </div>
                        <button 
                            @click="updateWeight()" 
                            :disabled="updating"
                            class="bg-ag-black py-0 px-8 h-12 flex items-center justify-center min-w-[120px] space-x-2 transition-colors hover:bg-zinc-800 disabled:opacity-50 shadow-sm rounded-xl">
                            <x-lucide-refresh-cw class="h-3.5 w-3.5 text-white" x-show="!updating" />
                            <span class="text-white text-[11px] font-bold uppercase tracking-wide leading-none"
                                x-text="updating ? 'Saving...' : 'Update'">Update</span>
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </template>
@endsection