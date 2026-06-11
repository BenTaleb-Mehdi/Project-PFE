<!-- Discovery Bar -->
<div class="ag-card p-4 bg-white mb-6 border border-zinc-200 flex flex-col md:flex-row gap-4 items-center">
    <form action="{{ route('coach.team') }}" method="GET" class="relative flex-1 w-full text-zinc-900">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Members (Name, Email, ID)..."
               class="w-full bg-zinc-50 border border-zinc-200 px-10 py-2.5 text-[10px] font-mono uppercase tracking-widest focus:outline-none focus:border-cyan-600 transition-colors">
        <i data-lucide="search" class="absolute left-3.5 top-3 size-3.5 text-zinc-400"></i>
    </form>

    <div class="relative w-full md:w-64" x-data="{ open: false }">
        <button @click="open = !open"
                @click.away="open = false"
                class="w-full flex justify-between items-center bg-zinc-50 border border-zinc-200 px-4 py-2.5 text-[10px] font-mono uppercase tracking-widest text-zinc-500 hover:text-zinc-900 transition-colors">
            <span x-text="filterSpec.replace('_', ' ')"></span>
            <i data-lucide="chevron-down" class="size-3 transition-transform" :class="open ? 'rotate-180' : ''"></i>
        </button>
        <div x-show="open" x-cloak
             class="absolute right-0 mt-1 z-[100] bg-white border border-zinc-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] w-full max-w-[256px]">
            <div class="py-1">
                @foreach($specialties as $spec)
                    <a href="{{ route('coach.team', ['specialty' => $spec->id, 'search' => request('search')]) }}"
                       class="w-full text-left block px-4 py-2 text-[10px] font-mono uppercase tracking-widest border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 hover:bg-zinc-50 transition-all {{ request('specialty') == $spec->id ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500' }}">
                        {{ $spec->name }}
                    </a>
                @endforeach
                <a href="{{ route('coach.team', ['search' => request('search')]) }}"
                   class="w-full text-left block px-4 py-2 text-[10px] font-mono uppercase tracking-widest border-l-2 border-transparent hover:border-l-cyan-600 hover:text-cyan-600 hover:bg-zinc-50 transition-all {{ !request('specialty') ? 'bg-zinc-50 text-cyan-600 border-l-cyan-600' : 'text-zinc-500' }}">
                    ALL_SPECIALIZATIONS
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Staff Table (Desktop) -->
<div class="ag-card overflow-hidden hidden md:block">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse font-sans font-medium">
            <thead class="bg-zinc-50 border-b border-zinc-200 uppercase font-mono tracking-widest">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Member ID</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Identity</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Specialization</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-zinc-400">Status</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-zinc-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100 uppercase">
                @foreach($team as $member)
                    <tr class="hover:bg-zinc-50/50 transition-colors">
                        <td class="px-6 py-4 text-[10px] font-mono text-cyan-700 font-bold">#STF-{{ str_pad($member->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4">
                            <p class="text-[10px] font-bold text-zinc-900">{{ $member->user->name }}</p>
                            <p class="text-[8px] text-zinc-400 font-mono">{{ $member->user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($member->specialties as $spec)
                                    <span class="px-1.5 py-0.5 bg-zinc-100 text-zinc-500 text-[7px] font-bold tracking-tighter">{{ $spec->name }}</span>
                                @endforeach
                                @if($member->specialties->isEmpty())
                                    <span class="text-[8px] text-zinc-300 italic">No Specialization</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($member->status === 'active')
                                <div class="flex flex-col">
                                    <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">Status: Success Sync</span>
                                    <span class="text-[10px] font-mono font-bold text-cyan-600 uppercase tracking-widest">PROFILE_SYNCED // Record_Modified</span>
                                </div>
                            @else
                                <div class="flex flex-col">
                                    <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">Status: Success Sync</span>
                                    <span class="text-[10px] font-mono font-bold text-cyan-600 uppercase tracking-widest">PROFILE_SYNCED // Record_Modified</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-3">
                                <button @click="openEditModal({{ json_encode($member->load(['user', 'specialties'])) }})" class="p-2 text-zinc-400 hover:text-cyan-600 transition-colors"><i data-lucide="edit-3" class="size-3.5"></i></button>
                                <button @click="confirmDelete({{ json_encode(['id' => $member->id, 'name' => $member->user->name]) }})" class="p-2 text-zinc-400 hover:text-red-600 transition-colors"><i data-lucide="trash-2" class="size-3.5"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Staff Cards (Mobile) -->
<div class="md:hidden space-y-3">
    @foreach($team as $member)
        <div class="ag-card bg-white p-4 border border-zinc-200 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-mono text-cyan-700 font-bold">#STF-{{ str_pad($member->id, 3, '0', STR_PAD_LEFT) }}</span>
                @if($member->status === 'active')
                    <div class="flex flex-col">
                        <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">Status: Success Sync</span>
                        <span class="text-[10px] font-mono font-bold text-cyan-600 uppercase tracking-widest">PROFILE_SYNCED // Record_Modified</span>
                    </div>
                @else
                    <div class="flex flex-col">
                        <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">Status: Success Sync</span>
                        <span class="text-[10px] font-mono font-bold text-cyan-600 uppercase tracking-widest">PROFILE_SYNCED // Record_Modified</span>
                    </div>
                @endif
            </div>
            <div>
                <p class="text-[10px] font-bold text-zinc-900">{{ $member->user->name }}</p>
                <p class="text-[8px] text-zinc-400 font-mono">{{ $member->user->email }}</p>
            </div>
            <div class="flex flex-wrap gap-1">
                @foreach($member->specialties as $spec)
                    <span class="px-1.5 py-0.5 bg-zinc-100 text-zinc-500 text-[7px] font-bold">{{ $spec->name }}</span>
                @endforeach
                @if($member->specialties->isEmpty())
                    <span class="text-[8px] text-zinc-300 italic">No Specialization</span>
                @endif
            </div>
            <div class="flex justify-end gap-3 pt-2 border-t border-zinc-100">
                <button @click="openEditModal({{ json_encode($member->load(['user', 'specialties'])) }})" class="p-1.5 text-zinc-400 hover:text-cyan-600"><i data-lucide="edit-3" class="size-3.5"></i></button>
                <button @click="confirmDelete({{ json_encode(['id' => $member->id, 'name' => $member->user->name]) }})" class="p-1.5 text-zinc-400 hover:text-red-600"><i data-lucide="trash-2" class="size-3.5"></i></button>
            </div>
        </div>
    @endforeach
</div>
<div class="mt-8 font-mono">
    {{ $team->appends(request()->query())->links() }}
</div>
