<!DOCTYPE html>
<html lang="en" class="bg-white border-x border-slate-200 shadow-2xl h-[100dvh] mx-auto w-full max-w-[430px] overflow-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Mobile Program | Coach V3.0</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ag-bg': '#F4F4F5',
                        'ag-cyan': '#45B6C5',
                        'ag-black': '#18181B',
                        'ag-text-dark': '#27272A',
                        'ag-grey': '#A1A1AA',
                        'ag-light-grey': '#E4E4E7'
                    },
                    fontFamily: {
                        mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700;800&display=swap');
        
        body { font-family: 'JetBrains Mono', monospace; }
        ::-webkit-scrollbar { display: none; }
        [x-cloak] { display: none !important; }
        
        .cut-corner {
            position: relative;
        }
        .cut-corner::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            border-width: 0 20px 20px 0;
            border-style: solid;
            border-color: #F4F4F5 #F4F4F5 transparent transparent;
            display: block;
            width: 0;
        }
    </style>
</head>
<body class="bg-ag-bg flex flex-col h-full antialiased text-ag-black overflow-x-hidden selection:bg-cyan-100 selection:text-cyan-900 relative" 
      x-data="programData({{ $clientId }})"
      x-init="fetchProgram()">

    @include('components.header')

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto pt-20 pb-28 px-5 bg-ag-bg">
        
        {{-- LOADING --}}
        <div x-show="loading" x-cloak class="flex flex-col gap-4 mt-4 animate-pulse">
            <div class="bg-zinc-300 h-40 w-full mb-8"></div>
            <div class="bg-zinc-200 h-28 w-full mb-4"></div>
            <div class="bg-zinc-200 h-28 w-full"></div>
        </div>

        {{-- ERROR --}}
        <div x-show="error && !loading" x-cloak class="bg-red-100 text-red-600 text-xs p-4 font-bold uppercase tracking-widest mt-4">
            ⚠ <span x-text="error"></span>
        </div>

        {{-- DATA --}}
        <template x-if="program && !loading">
            <div>
                <!-- Daily Pulse / Macros -->
                <section class="mb-8">
                    <div class="bg-white border text-left border-zinc-200 p-5 rounded-none shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-zinc-50 translate-x-8 -translate-y-8 rotate-45 border-l border-zinc-200"></div>
                        
                        <div class="flex justify-between items-end mb-6 relative z-10">
                            <div>
                                <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest mb-1">Energy_Targets</p>
                                <span class="text-2xl font-mono font-bold text-zinc-900 tracking-tight" x-text="program.dailyMacros.kcal"></span>
                                <span class="text-xs font-mono text-cyan-700 ml-1">KCAL</span>
                            </div>
                        </div>
                        
                        <div class="space-y-4 relative z-10">
                            <div class="grid grid-cols-[3fr_1fr] items-center gap-4">
                                <div class="h-1.5 bg-zinc-100 rounded-none overflow-hidden relative">
                                    <div class="absolute inset-y-0 left-0 bg-cyan-600 w-[85%]"></div>
                                </div>
                                <div class="flex justify-between items-baseline font-mono">
                                    <span class="text-[9px] text-zinc-400 uppercase">PRO</span>
                                    <span class="text-xs font-bold text-zinc-900" x-text="(program.dailyMacros.p || 0) + 'g'"></span>
                                </div>
                            </div>
                            <div class="grid grid-cols-[3fr_1fr] items-center gap-4">
                                <div class="h-1.5 bg-zinc-100 rounded-none overflow-hidden relative">
                                    <div class="absolute inset-y-0 left-0 bg-zinc-900 w-[45%]"></div>
                                </div>
                                <div class="flex justify-between items-baseline font-mono">
                                    <span class="text-[9px] text-zinc-400 uppercase">CAR</span>
                                    <span class="text-xs font-bold text-zinc-900" x-text="(program.dailyMacros.c || 0) + 'g'"></span>
                                </div>
                            </div>
                            <div class="grid grid-cols-[3fr_1fr] items-center gap-4">
                                <div class="h-1.5 bg-zinc-100 rounded-none overflow-hidden relative">
                                    <div class="absolute inset-y-0 left-0 bg-zinc-400 w-[25%]"></div>
                                </div>
                                <div class="flex justify-between items-baseline font-mono">
                                    <span class="text-[9px] text-zinc-400 uppercase">FAT</span>
                                    <span class="text-xs font-bold text-zinc-900" x-text="(program.dailyMacros.f || 0) + 'g'"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Daily Sequence -->
                <section>
                    <div class="flex items-center justify-between mb-5 border-b border-zinc-200 pb-3">
                        <h4 class="text-[10px] font-mono font-bold uppercase tracking-widest text-zinc-900" x-text="program.program_title || 'Sequence_Log'"></h4>
                        <p class="text-[9px] font-mono text-cyan-600 uppercase tracking-widest bg-cyan-50 px-2 py-0.5" x-text="program.meals.length + ' Actions'"></p>
                    </div>
                    
                    <div class="space-y-4 relative">
                        <!-- Timeline Connection Line -->
                        <div class="absolute left-4 top-2 bottom-2 w-[1px] bg-zinc-200 z-0"></div>

                        <template x-for="meal in program.meals">
                            <div @click="selectedMeal = meal; detailModalOpen = true" class="relative z-10 flex cursor-pointer group">
                                
                                <!-- Timeline Node -->
                                <div class="w-8 flex-shrink-0 flex justify-center pt-1.5">
                                    <div class="w-2 h-2 bg-white border border-zinc-400 rounded-none group-hover:border-cyan-600 group-hover:bg-cyan-600 transition-colors z-10"></div>
                                </div>

                                <!-- Card -->
                                <div class="flex-1 bg-white border border-zinc-200 p-4 rounded-none hover:border-cyan-600 hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)] transition-all">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-[9px] font-mono font-bold bg-zinc-100 text-zinc-900 px-1.5 py-0.5 uppercase tracking-widest" x-text="meal.time"></span>
                                            <span class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest" x-text="meal.cat"></span>
                                        </div>
                                        <span class="text-[10px] font-mono font-bold text-cyan-700" x-text="meal.kcal + ' KCAL'"></span>
                                    </div>
                                    <h3 class="text-xs font-mono font-bold text-zinc-900 uppercase tracking-tight mb-3" x-text="meal.menu"></h3>
                                    
                                    <!-- Mini Macro Bar Preview -->
                                    <div class="grid grid-cols-3 gap-2">
                                        <div class="border-t border-zinc-100 pt-1.5 flex flex-col">
                                            <span class="text-[8px] font-mono text-zinc-400 uppercase">Pro</span>
                                            <span class="text-[10px] font-mono font-bold text-zinc-900" x-text="meal.p + 'g'"></span>
                                        </div>
                                        <div class="border-t border-zinc-100 pt-1.5 flex flex-col">
                                            <span class="text-[8px] font-mono text-zinc-400 uppercase">Car</span>
                                            <span class="text-[10px] font-mono font-bold text-zinc-900" x-text="meal.c + 'g'"></span>
                                        </div>
                                        <div class="border-t border-zinc-100 pt-1.5 flex flex-col">
                                            <span class="text-[8px] font-mono text-zinc-400 uppercase">Fat</span>
                                            <span class="text-[10px] font-mono font-bold text-zinc-900" x-text="meal.f + 'g'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <div class="mt-8 pt-8 border-t border-zinc-200 flex justify-center">
                        <div class="h-1 w-1 bg-zinc-200 rounded-none mr-2"></div>
                        <div class="h-1 w-1 bg-zinc-300 rounded-none mr-2"></div>
                        <div class="h-1 w-1 bg-zinc-200 rounded-none"></div>
                    </div>
                </section>
            </div>
        </template>
    </main>

    @include('components.menu', ['clientId' => $clientId])

    <!-- Detail Modal Popup -->
    <div x-show="detailModalOpen" x-cloak class="fixed inset-0 z-[100] flex justify-center pointer-events-none">
        <div class="relative w-full max-w-[430px] h-full pointer-events-auto overflow-hidden">
            <!-- Backdrop -->
            <div x-show="detailModalOpen"
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="detailModalOpen = false" 
                 class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

            <!-- Sheet / Bottom Up Modal -->
            <div x-show="detailModalOpen"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="translate-y-full"
                 class="absolute inset-x-0 bottom-0 bg-white border-t border-zinc-200 rounded-none h-[85vh] flex flex-col shadow-[0px_-8px_16px_0px_rgba(0,0,0,0.05)]">
                
                <!-- Drag Handle Area -->
                <div class="w-full flex justify-center pt-3 pb-2 cursor-pointer" @click="detailModalOpen = false">
                    <div class="w-12 h-1 bg-zinc-200 rounded-none"></div>
                </div>

                <!-- Header -->
                <div class="px-5 pb-5 border-b border-zinc-100 flex justify-between items-start mt-2">
                    <div>
                        <span class="text-[9px] font-mono font-bold text-ag-cyan bg-cyan-50 px-2 py-1 uppercase tracking-widest" x-text="selectedMeal?.time + ' / ' + selectedMeal?.cat"></span>
                        <h2 class="text-xl font-mono font-bold text-zinc-900 uppercase tracking-tight leading-tight mt-3" x-text="selectedMeal?.menu"></h2>
                    </div>
                    <button @click="detailModalOpen = false" class="p-2 bg-zinc-50 text-zinc-400 hover:text-zinc-900 transition-colors border border-zinc-200 focus:outline-none">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>

                <!-- Content Area - Scrollable -->
                <div class="flex-1 overflow-y-auto px-5 py-6 space-y-8">
                    <!-- Yield -->
                    <div class="bg-zinc-50 border border-zinc-200 p-5">
                        <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest mb-1">Total_Yield</p>
                        <p class="text-2xl font-mono font-bold text-cyan-700 tracking-tight" x-text="selectedMeal?.kcal + ' KCAL'"></p>
                    </div>

                    <!-- Macros -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="border border-zinc-200 p-4 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1 bg-cyan-600"></div>
                            <span class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest block mb-2">Pro</span>
                            <span class="text-lg font-mono font-bold text-zinc-900" x-text="selectedMeal?.p + 'g'"></span>
                        </div>
                        <div class="border border-zinc-200 p-4 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1 bg-zinc-900"></div>
                            <span class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest block mb-2">Car</span>
                            <span class="text-lg font-mono font-bold text-zinc-900" x-text="selectedMeal?.c + 'g'"></span>
                        </div>
                        <div class="border border-zinc-200 p-4 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1 bg-zinc-400"></div>
                            <span class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest block mb-2">Fat</span>
                            <span class="text-lg font-mono font-bold text-zinc-900" x-text="selectedMeal?.f + 'g'"></span>
                        </div>
                    </div>

                    <!-- Directives -->
                    <div class="pt-2 pb-6">
                        <h5 class="text-[9px] font-mono text-zinc-900 font-bold uppercase tracking-widest mb-4 flex items-center">
                            <i data-lucide="check-circle" class="h-3 w-3 mr-2"></i>
                            Execution_Protocol
                        </h5>
                        <div class="text-[11px] text-zinc-600 font-sans border-l-2 border-cyan-600 pl-4" 
                             x-html="selectedMeal?.details">
                        </div>
                    </div>
                </div>
                
                <!-- Sticky Bottom Action -->
                <div class="p-5 border-t border-zinc-200 bg-white">
                    <button class="w-full py-4 bg-zinc-900 text-white text-[10px] font-mono font-bold uppercase tracking-widest hover:bg-black transition-colors flex items-center justify-center space-x-2">
                        <i data-lucide="check" class="h-4 w-4"></i>
                        <span>Log_Completion</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
