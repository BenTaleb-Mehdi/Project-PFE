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

        <!-- Deadline Alert Center -->
        <div x-data="{ settingsOpen: false, whatsapp: '{{ $whatsappNumber }}' }" class="ag-card p-8 flex flex-col relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4">
                <button @click="settingsOpen = true" class="h-8 w-8 bg-zinc-50 border border-zinc-200 flex items-center justify-center text-zinc-400 hover:text-cyan-600 hover:border-cyan-200 transition-all">
                    <i data-lucide="settings-2" class="size-4"></i>
                </button>
            </div>

            <h3 class="text-xs font-bold uppercase tracking-widest mb-8 border-b border-zinc-100 pb-4 flex items-center">
                <i data-lucide="bell-ring" class="size-3.5 mr-2 {{ $deadlineAlerts->isEmpty() ? 'text-zinc-300' : 'text-amber-500 animate-pulse' }}"></i>
                <span>Action Required</span>
            </h3>

            @if($deadlineAlerts->isEmpty())
                <div class="flex-1 flex flex-col items-center justify-center py-12 text-center">
                    <div class="h-16 w-16 border border-zinc-100 flex items-center justify-center mb-6">
                        <i data-lucide="shield-check" class="h-8 w-8 text-cyan-600 opacity-20"></i>
                    </div>
                    <h4 class="text-[10px] font-bold uppercase tracking-widest text-zinc-950">Coach Safe Core</h4>
                    <p class="text-[8px] text-zinc-400 mt-2 uppercase font-mono tracking-widest">Integrity check: 100% // No conflicts found</p>
                </div>
            @else
                <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($deadlineAlerts as $client)
                        <div class="p-4 bg-zinc-50 border border-zinc-200 flex items-center justify-between group/alert hover:border-amber-200 hover:bg-amber-50/30 transition-all">
                            <div class="flex items-center space-x-4">
                                <div class="h-8 w-8 bg-white border border-zinc-200 flex items-center justify-center font-bold text-[10px]">
                                    {{ substr($client->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase">{{ $client->user->name ?? 'Unknown' }}</p>
                                    <p class="text-[8px] text-amber-600 font-mono mt-0.5 uppercase">Program ends in {{ $client->days_left }} days</p>
                                </div>
                            </div>
                            <a href="{{ route('coach.clients.index', ['search' => $client->user->name]) }}" class="h-8 w-8 bg-white border border-zinc-200 flex items-center justify-center text-zinc-400 hover:text-cyan-600 hover:border-cyan-200 transition-all opacity-0 group-hover/alert:opacity-100">
                                <i data-lucide="arrow-right" class="size-3.5"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Settings Modal -->
            <div x-show="settingsOpen" x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/30 backdrop-blur-sm">
                <div x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     @click.outside="settingsOpen = false"
                     class="ag-card bg-white w-full max-w-sm relative z-10 p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.08)]">
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-6">System Configuration</h4>
                    <div class="space-y-4 font-mono">
                        <div class="space-y-1.5">
                            <label class="text-[8px] uppercase text-zinc-400 tracking-widest">WhatsApp Number (e.g. 2126...)</label>
                            <input type="text" x-model="whatsapp" class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-[10px] outline-none focus:border-cyan-600 transition-colors">
                        </div>
                        <button @click="
                            fetch('{{ route('coach.settings.update') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ 
                                    whatsapp_number: whatsapp
                                })
                            }).then(() => window.location.reload())
                        " class="w-full py-3 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-95">
                            Sync Engine Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
