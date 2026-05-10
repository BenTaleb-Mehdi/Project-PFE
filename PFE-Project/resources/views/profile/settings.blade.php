@extends(auth()->user()->hasRole('client') ? 'layouts.client' : 'layouts.dashboard')

@section('title', 'System Settings')
@section('header_title', 'Security & Profile')
@section('header_subtitle', 'Encryption Hub // Identity Synchronization')

@section('content')
<div class="max-w-4xl space-y-8">
    <!-- Profile Information Section -->
    <div class="ag-card bg-white border border-zinc-200 overflow-hidden">
        <div class="p-6 border-b border-zinc-100 flex justify-between items-center">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-900">Identity Nodes</h3>
                <p class="text-[9px] font-mono text-zinc-400 uppercase mt-1">Primary user data synchronization</p>
            </div>
            <div class="h-8 w-8 bg-zinc-50 border border-zinc-200 flex items-center justify-center">
                <i data-lucide="user" class="size-4 text-zinc-400"></i>
            </div>
        </div>
        
        <form action="{{ route('profile.settings.update') }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-mono">
                <div class="space-y-1.5">
                    <label class="text-[8px] uppercase text-zinc-400 tracking-widest">Public Alias / Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-[10px] uppercase outline-none focus:border-cyan-600 transition-colors" required>
                </div>
                
                <div class="space-y-1.5">
                    <label class="text-[8px] uppercase text-zinc-400 tracking-widest">Communication Node / Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-[10px] outline-none focus:border-cyan-600 transition-colors" required>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-8 py-3 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center gap-x-2">
                    <i data-lucide="refresh-cw" class="size-3.5"></i>
                    Sync Identity Data
                </button>
            </div>
        </form>
    </div>

    <!-- Security Section -->
    <div class="ag-card bg-white border border-zinc-200 overflow-hidden">
        <div class="p-6 border-b border-zinc-100 flex justify-between items-center">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-900">Encryption Protocol</h3>
                <p class="text-[9px] font-mono text-zinc-400 uppercase mt-1">Master password reconfiguration</p>
            </div>
            <div class="h-8 w-8 bg-zinc-50 border border-zinc-200 flex items-center justify-center">
                <i data-lucide="shield-check" class="size-4 text-zinc-400"></i>
            </div>
        </div>

        <form action="{{ route('profile.settings.password') }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6 font-mono">
                <div class="space-y-1.5">
                    <label class="text-[8px] uppercase text-zinc-400 tracking-widest">Current Encryption Key</label>
                    <input type="password" name="current_password" 
                           class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-[10px] outline-none focus:border-cyan-600 transition-colors" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-1.5">
                        <label class="text-[8px] uppercase text-zinc-400 tracking-widest">New System Key</label>
                        <input type="password" name="password" 
                               class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-[10px] outline-none focus:border-cyan-600 transition-colors" required>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[8px] uppercase text-zinc-400 tracking-widest">Verify New Key</label>
                        <input type="password" name="password_confirmation" 
                               class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-[10px] outline-none focus:border-cyan-600 transition-colors" required>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-8 py-3 bg-cyan-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-cyan-700 transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.99] flex items-center gap-x-2">
                    <i data-lucide="lock" class="size-3.5"></i>
                    Update Encryption
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
