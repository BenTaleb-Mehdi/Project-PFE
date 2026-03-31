<!DOCTYPE html>
<html lang="en" class="bg-slate-900 border-x border-slate-200 shadow-2xl h-[100dvh] mx-auto w-full max-w-[430px] overflow-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Dashboard | Client</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- ✅ Vite loads app.js (which imports dashboard.js + Alpine) --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ag-bg': '#F4F4F5',
                        'ag-cyan': '#45B6C5',
                        'ag-black': '#18181B',
                        'ag-grey': '#A1A1AA',
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
    </style>
</head>
<body class="bg-ag-bg flex flex-col h-full antialiased text-ag-black overflow-x-hidden relative"
    x-data="dashboardData({{ $clientId }})"
    x-init="fetchMetrics()"
>

    <!-- Header -->
    <header class="absolute top-0 left-0 right-0 bg-white/80 backdrop-blur-md z-40 border-b border-zinc-100 shrink-0">
        <div class="flex items-center justify-between px-5 py-4">
            <span class="text-sm font-bold uppercase tracking-widest text-ag-black">ACHAT</span>
            <button class="h-8 w-8 flex items-center justify-end text-zinc-400 relative hover:text-zinc-600 transition-colors">
                <div class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-none border border-white z-10"></div>
                <i data-lucide="bell" class="h-5 w-5"></i>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto pt-[90px] pb-32 px-5 space-y-5">

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
            <div class="space-y-5">

                {{-- Protocol Status Card --}}
                <section>
                    <div class="bg-ag-black p-6 shadow-sm relative overflow-hidden">
                        <div class="absolute right-0 bottom-0 opacity-10 blur-[1px]">
                            <svg class="h-40 w-40 text-white transform translate-x-12 translate-y-12" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 22h20L12 2zm0 4.6l5.2 10.4H6.8L12 6.6z"></path>
                            </svg>
                        </div>
                        <p class="text-[9px] text-[#A1A1AA] uppercase tracking-widest mb-[6px] font-bold">Current_Status</p>
                        <div class="flex items-center justify-between mb-8 relative z-10">
                            <div>
                                <span class="text-xl font-bold text-white tracking-tight uppercase"
                                    x-text="'Protocol_' + metrics.status"></span>
                                <p class="text-[10px] text-ag-cyan uppercase tracking-widest mt-1 font-bold"
                                    x-text="'Target : ' + metrics.target_goal + ' KG'"></p>
                            </div>
                        </div>
                        <a href="#" class="inline-flex items-center justify-between w-full bg-white text-ag-black py-3 px-4 text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-100 transition-colors relative z-10">
                            <span>Access_Daily_Sequence</span>
                            <i data-lucide="chevron-right" class="h-3 w-3"></i>
                        </a>
                    </div>
                </section>

                {{-- Stats Grid --}}
                <section class="grid grid-cols-2 gap-4">

                    {{-- Weight --}}
                    <div class="bg-white border border-zinc-100 p-5 shadow-sm">
                        <div class="flex justify-between items-start mb-4">
                            <span class="text-[8px] text-zinc-400 font-bold uppercase tracking-widest">Weight_Sync</span>
                            <i data-lucide="scale" class="h-3 w-3 text-zinc-300"></i>
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

                    {{-- Height --}}
                    <div class="bg-white border border-zinc-100 p-5 shadow-sm">
                        <div class="flex justify-between items-start mb-4">
                            <span class="text-[8px] text-zinc-400 font-bold uppercase tracking-widest">Height</span>
                            <i data-lucide="ruler" class="h-3 w-3 text-zinc-300"></i>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-bold text-zinc-900 tracking-tight" x-text="metrics.height"></span>
                            <span class="text-[9px] font-bold text-ag-cyan tracking-widest">CM</span>
                        </div>
                        <p class="text-[8px] text-zinc-400 font-bold mt-2 uppercase tracking-widest" x-text="metrics.client_name"></p>
                    </div>

                </section>
            </div>
        </template>

    </main>

    @include('components.navbar', ['clientId' => $clientId])

    <script>lucide.createIcons();</script>
</body>
</html>