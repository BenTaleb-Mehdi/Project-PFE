<!-- Sync Modal -->
<div x-show="syncModalOpen" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4">
    
    <div @click="syncModalOpen = false" 
         class="absolute inset-0 bg-zinc-950/90 backdrop-blur-2xl"></div>

    <div x-show="syncModalOpen"
         x-data="{ currentImg: 0 }"
         x-transition:enter="transition ease-out duration-350"
         x-transition:enter-start="opacity-0 scale-95 translate-y-8"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="ag-card bg-white w-full max-w-4xl max-h-[85vh] relative z-10 overflow-hidden shadow-[24px_24px_0px_0px_rgba(0,0,0,0.15)] flex flex-col">
        
        <!-- Header: Fixed Height -->
        <div class="p-6 border-b border-zinc-100 bg-zinc-50/50 flex justify-between items-center shrink-0">
            <div>
                <div class="flex items-center space-x-3 mb-1.5">
                    <span class="h-2 w-2 bg-cyan-600 animate-pulse"></span>
                    <h2 class="text-xl font-mono font-bold text-zinc-900 uppercase tracking-tighter">Sync Node Analysis V3</h2>
                </div>
                <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-[0.4em] flex items-center">
                    <i data-lucide="fingerprint" class="size-3 mr-2 text-cyan-600"></i>
                    Archive Hash ID: #000<span x-text="selectedSync?.id || '00'"></span> // SECURE LOG TRACE
                </p>
            </div>
            <button @click="syncModalOpen = false" class="h-10 w-10 ag-border flex items-center justify-center text-zinc-400 hover:text-zinc-900 hover:rotate-90 duration-500 shadow-sm bg-white">
                <i data-lucide="x" class="size-5"></i>
            </button>
        </div>

        <!-- Split Content Wrapper -->
        <div class="flex flex-col lg:flex-row divide-y lg:divide-y-0 lg:divide-x divide-zinc-100 flex-1 min-h-0 overflow-y-auto lg:overflow-hidden">
            
            <!-- Gallery Section: Edge-to-Edge Image Fix -->
            <div class="w-full lg:w-1/2 bg-zinc-950 relative min-h-[350px] lg:min-h-0 flex flex-col justify-end overflow-hidden">
                
                <!-- Main Image Viewport -->
                <div class="absolute inset-0 w-full h-full">
                    <template x-if="selectedSync?.images && selectedSync.images.length > 0">
                        <template x-for="(img, index) in selectedSync.images" :key="index">
                            <div x-show="currentImg === index" class="w-full h-full">
                                <img :src="'/storage/' + img" class="w-full h-full object-cover">
                            </div>
                        </template>
                    </template>
                    
                    <template x-if="!selectedSync?.images || selectedSync.images.length === 0">
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-zinc-100 p-6">
                            <i data-lucide="image-off" class="size-16 mb-4 stroke-[0.5] text-zinc-700"></i>
                            <span class="text-[9px] font-mono text-zinc-500 uppercase tracking-[0.4em]">No Photo Captured</span>
                        </div>
                    </template>
                </div>
                
                <!-- Overlaid UI Controls (Only visible with multi-images) -->
                <div x-show="selectedSync?.images && selectedSync.images.length > 1" 
                     class="relative z-10 p-4 bg-gradient-to-t from-zinc-950/90 via-zinc-950/40 to-transparent w-full flex flex-col items-center space-y-3 shrink-0">
                    
                    <!-- Bullet Indicators -->
                    <div class="flex justify-center space-x-2">
                        <template x-for="(img, index) in selectedSync.images" :key="index">
                            <button @click="currentImg = index" 
                                    class="h-1 transition-all duration-300"
                                    :class="currentImg === index ? 'bg-cyan-500 w-8' : 'bg-white/40 w-4 hover:bg-white'"></button>
                        </template>
                    </div>
                    
                    <!-- Thumbnails Strip -->
                    <div class="flex space-x-2 overflow-x-auto max-w-full p-0.5 scrollbar-hide justify-center">
                        <template x-for="(img, index) in selectedSync.images" :key="index">
                            <div @click="currentImg = index" 
                                 class="h-11 w-11 flex-shrink-0 border cursor-pointer transition-all bg-zinc-900 p-0.5"
                                 :class="currentImg === index ? 'border-cyan-500 scale-105 shadow-md' : 'opacity-60 hover:opacity-100 border-zinc-800'">
                                <img :src="'/storage/' + img" class="w-full h-full object-cover">
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Stats & Diagnostics Section -->
            <div class="w-full lg:w-1/2 p-6 lg:p-8 space-y-6 bg-white overflow-y-auto lg:max-h-full progress-scrollbar">
                <div class="bg-zinc-50/50 p-4 ag-border border-dashed">
                    <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest mb-2 flex items-center">
                        <i data-lucide="clock" class="size-3 mr-2"></i>
                        Timestamp Metric
                    </p>
                    <p class="text-lg font-mono font-bold text-zinc-900 tracking-tighter underline decoration-cyan-100 underline-offset-4" x-text="formatDate(selectedSync?.recorded_at)"></p>
                </div>

                <div class="space-y-4">
                    <div class="p-6 bg-zinc-950 text-white relative overflow-hidden group shadow-md">
                        <div class="absolute -right-4 -top-4 text-zinc-900/60 group-hover:scale-110 transition-transform duration-1000 pointer-events-none">
                            <i data-lucide="activity" class="size-24 stroke-[0.3]"></i>
                        </div>
                        <div class="relative z-10">
                            <p class="text-[9px] font-mono text-zinc-500 uppercase tracking-[0.3em] mb-2">Sync Recorded Mass</p>
                            <div class="flex items-baseline space-x-3">
                                <span class="text-5xl font-mono font-bold tracking-tighter text-cyan-500" x-text="selectedSync?.weight"></span>
                                <span class="text-[10px] font-mono text-zinc-500 font-bold uppercase tracking-widest">KILOGRAMS</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-2">
                        <div class="p-4 ag-border flex justify-between items-center bg-zinc-50/30 hover:bg-zinc-50 transition-colors">
                            <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest">BM Sync Status</p>
                            <div class="flex flex-col">
                                <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">Status: Success Sync</span>
                                <span class="text-[10px] font-mono font-bold text-cyan-600 uppercase tracking-widest">PROFILE_SYNCED // Record_Modified</span>
                            </div>
                        </div>
                        <div class="p-4 ag-border flex justify-between items-center bg-zinc-50/30 hover:bg-zinc-50 transition-colors">
                            <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest">Trend Analysis</p>
                            <span class="text-[10px] font-mono font-bold text-cyan-600 uppercase tracking-widest">Bio Sync Elite</span>
                        </div>
                    </div>
                </div>

                <!-- Diagnostic Data -->
                <div class="pt-6 border-t border-zinc-100">
                    <h5 class="text-[10px] font-mono font-bold text-zinc-900 uppercase tracking-widest mb-4 border-b border-zinc-50 pb-2 flex items-center justify-between">
                        <span>Detailed Log Trace</span>
                        <i data-lucide="scroll-text" class="size-4 text-zinc-200"></i>
                    </h5>
                    <div class="space-y-3">
                        <div class="flex justify-between text-[10px] font-mono uppercase items-center">
                            <span class="text-zinc-400 tracking-widest">Node Architecture</span>
                            <span class="text-zinc-900 font-bold bg-zinc-50 px-2 py-0.5 ag-border">SECURE ALPHA</span>
                        </div>
                        <div class="flex justify-between text-[10px] font-mono uppercase items-center text-zinc-400">
                            <span>Sync Protocol</span>
                            <span class="text-zinc-900 font-bold">MULTI SURFACE V3</span>
                        </div>
                        <div class="flex justify-between text-[10px] font-mono uppercase items-center">
                            <span class="text-zinc-400">Integrity Check</span>
                            <div class="flex flex-col items-end">
                                <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">Status: Success Sync</span>
                                <span class="text-[10px] font-mono font-bold text-cyan-600 uppercase tracking-widest">PROFILE_SYNCED // Record_Modified</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer: Fixed Height -->
        <div class="p-6 bg-zinc-50 border-t border-zinc-100 flex gap-4 shrink-0">
            <form :action="'{{ route('client.evolution.destroy', ['id' => 'REPLACE_ID']) }}'.replace('REPLACE_ID', selectedSync?.id)" method="POST" class="flex-1 m-0" onsubmit="return confirm('CRITICAL_WARNING: This action will purge the biometric log. Proceed?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full py-4 bg-white border border-red-100 text-red-600 text-[10px] font-mono font-bold uppercase tracking-[0.2em] hover:bg-red-50 transition-all duration-300 shadow-sm active:scale-[0.98]">
                    Purge Log Node
                </button>
            </form>
            <button @click="syncModalOpen = false" 
                    class="flex-[2] py-4 bg-zinc-950 text-white text-[11px] font-mono font-bold uppercase tracking-[0.3em] hover:bg-black transition-all hover:tracking-[0.4em] duration-500 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.05)] active:scale-[0.98]">
                Close Analysis
            </button>
        </div>
    </div>
</div>