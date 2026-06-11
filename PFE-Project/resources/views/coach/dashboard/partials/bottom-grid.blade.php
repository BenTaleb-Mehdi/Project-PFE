<!-- Bottom Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 font-mono">
    <div class="ag-card p-6 sm:p-8">
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
    <div x-data="{ settingsOpen: false, whatsapp: '{{ $whatsappNumber }}', threshold: {{ $threshold }} }" class="ag-card p-4 sm:p-8 flex flex-col relative overflow-hidden group">
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
                        <label class="text-[8px] uppercase text-zinc-400 tracking-widest">Deadline Alert Threshold (Days)</label>
                        <input type="number" x-model="threshold" min="0" max="30" class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-[10px] outline-none focus:border-cyan-600 transition-colors">
                    </div>
                    <button @click="
                        fetch('{{ route('coach.settings.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ 
                                deadline_alert_threshold: threshold
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
