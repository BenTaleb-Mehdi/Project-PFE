<form action="{{ route('client.evolution.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-20">
    @csrf
    
    <!-- Left Side: Upload Zone -->
    <div class="space-y-6">
        <div class="relative group h-full min-h-[300px]">
            <input type="file" name="photos[]" multiple @change="handleFileChange" class="absolute inset-0 opacity-0 cursor-pointer z-10" id="photo_input">
            <div class="ag-card h-full p-10 bg-white border-dashed border-2 border-zinc-200 flex flex-col items-center justify-center text-center group-hover:border-cyan-600 transition-all shadow-sm">
                <div class="h-20 w-20 bg-zinc-50 flex items-center justify-center mb-8 group-hover:bg-cyan-50 transition-colors">
                    <i data-lucide="layers" class="h-10 w-10 text-zinc-200 group-hover:text-cyan-600 transition-colors"></i>
                </div>
                <h3 class="text-sm font-mono font-bold uppercase tracking-widest text-zinc-900 mb-3">Deploy Sync Payload</h3>
                <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-[0.2em] leading-relaxed">Multi-Angle Biometric Snapshots<br/>Required Format: PNG / JPG</p>
            </div>
            
            <!-- Live Previews Overlay -->
            <div x-show="previewPhotos.length > 0" class="absolute bottom-6 left-6 right-6 grid grid-cols-5 gap-2 pointer-events-none">
                <template x-for="photo in previewPhotos">
                    <div class="aspect-square ag-border overflow-hidden bg-white shadow-md grayscale hover:grayscale-0 transition-all duration-500">
                        <img :src="photo" class="w-full h-full object-cover">
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Right Side: Metrics & Submit -->
    <div class="space-y-8">
        <div class="ag-card p-10 bg-zinc-950 text-white border-l-4 border-l-cyan-600 shadow-[20px_20px_0px_0px_rgba(0,0,0,0.03)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i data-lucide="activity" class="size-48 stroke-[0.5]"></i>
            </div>
            <div class="relative z-10">
                <label class="block text-[9px] font-mono text-zinc-500 uppercase tracking-[0.3em] mb-4 sm:mb-8">System Mass Input (KG)</label>
                <div class="flex items-baseline space-x-6">
                    <input type="number" step="0.1" name="weight" placeholder="00.0" required
                           class="text-4xl sm:text-7xl font-mono font-bold w-full bg-transparent outline-none text-cyan-500 border-none p-0 focus:ring-0 tracking-tighter placeholder-zinc-800">
                    <span class="text-xs font-mono text-zinc-600 font-bold uppercase">Metric Units</span>
                </div>
            </div>
        </div>

        <input type="hidden" name="recorded_at" value="{{ date('Y-m-d') }}">

        <button type="submit" class="w-full py-6 bg-zinc-900 text-white text-[11px] font-mono font-bold uppercase tracking-[0.4em] hover:bg-black transition-all shadow-[12px_12px_0px_0px_rgba(0,0,0,0.05)] active:scale-[0.98] group hover:tracking-[0.6em] duration-500">
            Finalize Snapshot Sync
            <i data-lucide="arrow-right" class="size-4 ml-4 inline-block transition-transform group-hover:translate-x-2"></i>
        </button>
    </div>
</form>
