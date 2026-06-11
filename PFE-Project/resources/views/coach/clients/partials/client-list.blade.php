<!-- Client List -->
<div class="grid grid-cols-1 gap-4 font-sans">
    @forelse($clients as $client)
        <div class="ag-card bg-white overflow-hidden group transition-all"
             :class="expandedClientIds.includes({{ $client->id }}) ? 'border-cyan-600 ring-1 ring-cyan-600/10' : 'border-zinc-200'">

            <!-- Main Row -->
            <div @click="expandedClientIds.includes({{ $client->id }}) ? expandedClientIds = expandedClientIds.filter(id => id !== {{ $client->id }}) : expandedClientIds.push({{ $client->id }})"
                 class="p-6 flex flex-col md:flex-row md:items-center justify-between cursor-pointer hover:bg-zinc-50/50 transition-colors">
                <div class="flex items-center space-x-6">
                    <div class="h-10 w-10 border border-zinc-200 flex items-center justify-center font-bold text-cyan-600 bg-cyan-50 font-mono">{{ substr($client->user->name, 0, 1) }}</div>
                    <div>
                        <h4 class="text-xs font-bold uppercase text-zinc-900">{{ $client->user->name }}</h4>
                        <p class="text-[10px] text-zinc-400 uppercase mt-1">
                            <span class="font-mono text-cyan-700">ID: #{{ $client->id }}</span>
                            <span class="mx-2 opacity-50">//</span>
                            <span>Goal: {{ $client->target_goal ?? 'NOT SET' }}</span>
                        </p>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex items-center justify-between md:justify-end space-x-6 md:flex-row flex-row-reverse">
                    <div class="text-zinc-300 transition-all duration-200 transform md:order-last"
                         :class="expandedClientIds.includes({{ $client->id }}) ? 'rotate-180 text-cyan-600' : 'group-hover:text-zinc-950'">
                        <i data-lucide="chevron-down" class="h-4 w-4"></i>
                    </div>

                    <button @click.stop="selectedClient = {{ json_encode($client) }}; showAssignModal = true"
                            class="flex items-center gap-x-1.5 px-4 py-2 text-[10px] uppercase text-cyan-600 font-bold hover:underline font-mono">
                        <i data-lucide="clipboard-list" class="size-3 text-cyan-600"></i>
                        Assign Program
                    </button>

                    <!-- FIXED: Replaced verbose multiline block with contextual system status badges -->
                    <div class="shrink-0">
                        @if(strtolower($client->status ?? '') === 'active')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 font-mono text-[9px] font-bold uppercase tracking-wider border border-emerald-200/60">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Active Node
                            </span>
                        @elseif(strtolower($client->status ?? '') === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 font-mono text-[9px] font-bold uppercase tracking-wider border border-amber-200/60">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                Pending Sync
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-zinc-50 text-zinc-500 font-mono text-[9px] font-bold uppercase tracking-wider border border-zinc-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-zinc-400"></span>
                                {{ $client->status ?? 'Inactive' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Details Pane -->
            <div x-show="expandedClientIds.includes({{ $client->id }})"
                 x-collapse
                 x-cloak
                 class="border-t border-dashed border-zinc-100 bg-zinc-50/50">
                <div class="p-4 sm:p-8 grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-8">
                    <!-- Bio Metrics -->
                    <div class="space-y-4">
                        <h5 class="text-[8px] font-mono text-zinc-400 uppercase tracking-[0.2em] mb-4">Bio Metrics Core</h5>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white p-3 border border-zinc-100">
                                <p class="text-[8px] text-zinc-400 uppercase">Weight</p>
                                <p class="text-xs font-mono font-bold text-zinc-900">{{ $client->current_weight ?? '--' }} KG</p>
                            </div>
                            <div class="bg-white p-3 border border-zinc-100">
                                <p class="text-[8px] text-zinc-400 uppercase">Height</p>
                                <p class="text-xs font-mono font-bold text-cyan-600">{{ $client->height ?? '--' }} CM</p>
                            </div>
                            <div class="bg-white p-3 border border-zinc-100">
                                <p class="text-[8px] text-zinc-400 uppercase">BMI</p>
                                <p class="text-xs font-mono font-bold text-zinc-900">
                                    @if($client->height && $client->current_weight)
                                        {{ round($client->current_weight / (($client->height / 100) ** 2), 1) }}
                                    @else
                                        --
                                    @endif
                                </p>
                            </div>
                            <div class="bg-white p-3 border border-zinc-100 flex flex-col justify-between">
                                <p class="text-[8px] text-zinc-400 uppercase mb-1">Status</p>
                                <div>
                                    @if(strtolower($client->status ?? '') === 'active')
                                        <span class="inline-block px-1.5 py-0.5 bg-emerald-50 text-emerald-700 text-[8px] font-mono font-bold uppercase border border-emerald-100">Active</span>
                                    @else
                                        <span class="inline-block px-1.5 py-0.5 bg-zinc-100 text-zinc-600 text-[8px] font-mono font-bold uppercase border border-zinc-200">{{ $client->status ?? 'N/A' }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Program Status -->
                    <div class="space-y-4">
                        <h5 class="text-[8px] font-mono text-zinc-400 uppercase tracking-[0.2em] mb-4">Current Assignment</h5>
                        @if($client->program)
                            <div class="bg-white p-4 border border-zinc-200">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-[10px] font-bold text-zinc-900 uppercase">{{ $client->program->title }}</span>
                                    <span class="text-[8px] font-mono text-cyan-700">
                                        Day {{ \Carbon\Carbon::parse($client->program_started_at)->diffInDays(now()) + 1 }}/{{ $client->duration_weeks * 7 }}
                                    </span>
                                </div>
                                <div class="w-full h-1 bg-zinc-100 overflow-hidden">
                                    @php
                                        $daysElapsed = \Carbon\Carbon::parse($client->program_started_at)->diffInDays(now()) + 1;
                                        $totalDays = $client->duration_weeks * 7;
                                        $progress = ($daysElapsed / $totalDays) * 100;
                                    @endphp
                                    <div class="h-full bg-cyan-600 transition-all duration-500" style="width: {{ min(100, $progress) }}%"></div>
                                </div>
                                <p class="text-[8px] text-zinc-400 mt-3 uppercase tracking-widest">Adherence Tracking: <span class="text-zinc-900 font-bold">ACTIVE</span></p>
                            </div>
                        @else
                            <div class="bg-white p-4 border border-zinc-200 border-dashed border-2 flex flex-center">
                                <p class="text-[9px] text-zinc-400 uppercase py-4">No Active Protocol Assigned</p>
                            </div>
                        @endif
                    </div>

                    <!-- Intelligence Feed -->
                    <div class="space-y-4">
                        <h5 class="text-[8px] font-mono text-zinc-400 uppercase tracking-[0.2em] mb-4">Intelligence Feed // Biometric Snapshots</h5>
                        <div class="space-y-3 max-h-[160px] overflow-y-auto pr-1">
                            @forelse($client->evolutions as $evolution)
                                <div class="border border-zinc-200 bg-white p-3 space-y-2 shadow-sm">
                                    <div class="flex justify-between items-center text-[9px] uppercase font-mono">
                                        <span class="text-zinc-900 font-bold">Weight: {{ $evolution->weight }} KG</span>
                                        <span class="text-zinc-400">{{ $evolution->recorded_at->format('Y-m-d') }}</span>
                                    </div>
                                    @if(!empty($evolution->images))
                                        <div class="grid grid-cols-3 gap-1.5">
                                            @foreach($evolution->images as $img)
                                                <div class="aspect-square bg-zinc-50 border border-zinc-100 overflow-hidden relative cursor-pointer group"
                                                     @click.stop="previewImage = '{{ asset('storage/' . $img) }}'">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                    <div class="absolute inset-0 bg-black/35 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                        <i data-lucide="eye" class="size-3.5 text-white"></i>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-[8px] text-zinc-300 italic uppercase">No Snapshots Captured</p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-[9px] text-zinc-300 italic uppercase">No Recent Traffic</p>
                            @endforelse
                        </div>
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <button @click.stop="openModal({{ json_encode($client->load('user')) }})" class="w-full py-2 bg-white text-zinc-900 text-[8px] uppercase font-bold tracking-widest hover:bg-zinc-50 transition-all border border-zinc-200 hover:border-cyan-600 hover:text-cyan-600 flex items-center justify-center gap-x-1.5 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">
                                <i data-lucide="edit-3" class="size-3"></i>
                                Edit Profile
                            </button>
                            <button @click.stop="confirmDelete({{ json_encode(['id' => $client->id, 'name' => $client->user->name]) }})" class="w-full py-2 bg-red-50 text-red-600 text-[8px] uppercase font-bold tracking-widest hover:bg-red-100 transition-all border border-red-100 flex items-center justify-center gap-x-1.5 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.05)]">
                                <i data-lucide="trash-2" class="size-3"></i>
                                Terminate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="p-12 bg-white border border-dashed border-zinc-200 text-center uppercase font-mono text-[10px] text-zinc-400">
            No Pupils Found In Registry
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-8 font-mono">
    {{ $clients->appends(request()->query())->links() }}
</div>