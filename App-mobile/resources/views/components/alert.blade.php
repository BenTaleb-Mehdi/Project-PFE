<div x-data 
     x-show="$store.alert.visible"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="-translate-x-full opacity-0"
     x-transition:enter-end="translate-x-0 opacity-100"
     x-transition:leave="transition ease-in duration-400"
     x-transition:leave-start="translate-x-0 opacity-100"
     x-transition:leave-end="-translate-x-full opacity-0"
     @click="$store.alert.visible = false"
     class="fixed top-8 left-4 z-[200] w-auto cursor-pointer"
     x-cloak>
    
    <div class="bg-ag-black border border-ag-cyan/30 p-4 rounded-xl shadow-[10px_10px_30px_rgba(0,0,0,0.4)] relative overflow-hidden w-full">
        {{-- Background Pattern --}}
        <div class="absolute top-0 right-0 w-16 h-16 bg-ag-cyan/5 -translate-y-8 translate-x-8 rotate-45 pointer-events-none"></div>
        
        <div class="flex items-center gap-4 relative z-10">
            {{-- Icon Left --}}
            <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 bg-ag-cyan/10 border border-ag-cyan/30 rounded-lg">
                <template x-if="$store.alert.type === 'success'">
                    <x-lucide-check-circle class="h-5 w-5 text-ag-cyan" />
                </template>
                <template x-if="$store.alert.type === 'error'">
                    <x-lucide-x-circle class="h-5 w-5 text-red-500" />
                </template>
            </div>

            {{-- Content --}}
            <div>
                <p class="text-[8px] font-mono text-ag-grey uppercase tracking-[0.2em] mb-0.5">Status_Pulse</p>
                <h4 class="text-xs font-mono font-bold text-white uppercase tracking-wider leading-tight" 
                    x-text="$store.alert.message"></h4>
            </div>
        </div>

        {{-- Animated Progress Bar --}}
        <div class="absolute bottom-0 left-0 h-[2px] bg-ag-cyan shadow-[0_0_10px_#45B6C5]"
             x-show="$store.alert.visible"
             x-transition:enter="transition-[width] duration-[4000ms] ease-linear"
             x-transition:enter-start="w-0"
             x-transition:enter-end="w-full"></div>
    </div>
</div>
