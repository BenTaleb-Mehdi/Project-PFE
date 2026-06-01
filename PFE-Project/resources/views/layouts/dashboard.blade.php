<!-- resources/views/layouts/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Coach') }} | @yield('title', 'Admin Engine V3.0')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Fonts & Tokens -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap">
    <style>
        :root {
            --font-mono: 'JetBrains Mono', monospace;
        }
        /* Global Rounding */
        * {
            border-radius: var(--radius-sm);
        }
        [x-cloak] { display: none !important; }
        .ag-card {
            background-color: #FFFFFF;
            border: 1px solid #E4E4E7;
            border-radius: var(--radius-xl);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .ag-card:hover {
            border-color: #0891B2;
            transform: translateY(-2px);
            box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 0.05);
        }
        .font-mono { font-family: var(--font-mono) !important; }

        /* Custom Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f4f4f5; /* zinc-100 */
        }
        ::-webkit-scrollbar-thumb {
            background: #0891B2; /* chartgraphique blue */
            border-radius: 0px !important;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0E7490;
        }
    </style>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-50 antialiased v3-admin" 
      x-data="{ 
        loading: false,
        isSidebarOpen: false, 
        isLargeScreen: window.innerWidth >= 1024 
      }"
      @submit.window="loading = true"
      x-init="window.addEventListener('resize', () => isLargeScreen = window.innerWidth >= 1024)">

    <!-- Global Loading Overlay -->
    <div x-show="loading" x-transition.opacity x-cloak 
         class="fixed inset-0 z-[1000] bg-zinc-950/40 backdrop-blur-md flex items-center justify-center">
        <div class="flex flex-col items-center">
            <div class="size-12 border-2 border-zinc-800 border-t-cyan-600 rounded-full animate-spin mb-4"></div>
            <p class="text-[10px] font-mono text-white uppercase tracking-[0.3em] animate-pulse">Synchronizing Data...</p>
        </div>
    </div>

    <!-- Mobile Backdrop -->
    <div x-show="isSidebarOpen" 
         x-transition.opacity
         @click="isSidebarOpen = false"
         class="fixed inset-0 bg-zinc-950/20 backdrop-blur-sm z-50 lg:hidden"
         style="display: none;"></div>

    <!-- Layout Components -->
    <x-admin.header />
    <x-admin.sidebar />

    <!-- Content Area -->
    <main class="lg:ml-64 min-h-screen p-6 lg:p-12 pt-12">

        <!-- ── Notification Top Bar ── -->
        <div class="flex items-center justify-end mb-6">
            <div x-data="notificationHub" class="relative" x-init="init()" @destroy="destroy()">

                <!-- Bell Button -->
                <button id="notif-bell-btn"
                    @click="toggle()"
                    class="relative flex items-center justify-center h-9 w-9 border border-zinc-200 bg-white hover:bg-zinc-50 hover:border-cyan-500 transition-all duration-200"
                    title="Notifications">
                    <i data-lucide="bell" class="size-4 text-zinc-600"></i>
                    <span x-show="unreadCount > 0" x-cloak
                          x-text="unreadCount > 9 ? '9+' : unreadCount"
                          class="absolute -top-1.5 -right-1.5 h-4 min-w-4 px-1 bg-cyan-600 text-white text-[9px] font-bold flex items-center justify-center">
                    </span>
                </button>

                <!-- Dropdown Panel -->
                <div x-show="open" x-cloak
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute right-0 top-12 z-[300] w-80 bg-white border border-zinc-200 shadow-xl overflow-hidden">

                    <!-- Header -->
                    <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-100">
                        <div class="flex items-center gap-x-2">
                            <div class="h-3 w-0.5 bg-cyan-600"></div>
                            <p class="text-[10px] font-mono font-bold uppercase tracking-widest text-zinc-800">Notifications</p>
                        </div>
                        <button @click="markAllRead()" x-show="unreadCount > 0" x-cloak
                                class="text-[9px] font-mono text-cyan-600 hover:text-cyan-800 uppercase tracking-wider transition-colors">
                            Mark all read
                        </button>
                    </div>

                    <!-- Notification List -->
                    <div class="max-h-80 overflow-y-auto divide-y divide-zinc-50">
                        <template x-if="notifications.length === 0">
                            <div class="px-4 py-8 text-center">
                                <i data-lucide="bell-off" class="size-6 text-zinc-300 mx-auto mb-2"></i>
                                <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-wider">No notifications yet</p>
                            </div>
                        </template>

                        <template x-for="n in notifications" :key="n.id">
                            <div @click="markRead(n.id)"
                                 :class="n.is_read ? 'bg-white' : 'bg-cyan-50/40'"
                                 class="px-4 py-3 hover:bg-zinc-50 cursor-pointer transition-colors group">
                                <div class="flex items-start gap-x-3">
                                    <div class="mt-0.5 h-5 w-5 flex items-center justify-center flex-shrink-0"
                                         :style="'color:' + colorForType(n.type)">
                                        <i :data-lucide="iconForType(n.type)" class="size-3.5"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] font-semibold text-zinc-900 truncate" x-text="n.title"></p>
                                        <p class="text-[10px] text-zinc-500 mt-0.5 line-clamp-2" x-text="n.body"></p>
                                        <p class="text-[9px] font-mono text-zinc-400 mt-1 uppercase tracking-wider" x-text="timeAgo(n.created_at)"></p>
                                    </div>
                                    <span x-show="!n.is_read" class="h-1.5 w-1.5 bg-cyan-500 rounded-full flex-shrink-0 mt-1.5"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Footer -->
                    <div class="px-4 py-2.5 border-t border-zinc-100 bg-zinc-50/60">
                        <p class="text-[9px] font-mono text-zinc-400 text-center uppercase tracking-wider"
                           x-text="loading ? 'Syncing…' : 'Auto-refreshes every 30s'"></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- ── / Notification Top Bar ── -->

        <!-- Dashboard Header Context -->
        <header class="mb-8 font-sans">
            <h1 class="text-3xl font-bold tracking-tight uppercase text-zinc-900">@yield('header_title', 'Dashboard')</h1>
            <p class="text-[10px] text-zinc-400 mt-2 uppercase tracking-[0.2em] font-mono">@yield('header_subtitle', 'Operational Intel // System Sync Active')</p>
        </header>
        
        <!-- Global Alerts Hub -->
        @if(session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-x-full opacity-0"
                 x-transition:enter-end="translate-x-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0 opacity-100"
                 x-transition:leave-end="translate-x-full opacity-0"
                 class="fixed top-8 right-8 z-[200] bg-zinc-900 border border-zinc-800 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.1)] p-6 min-w-[320px] pointer-events-auto"
                 x-cloak>
                <div class="flex items-start gap-x-4">
                    <div class="h-10 w-1 bg-cyan-600 flex-shrink-0 animate-pulse"></div>
                    <div class="flex-1">
                        <p class="text-[8px] font-mono text-cyan-600 uppercase tracking-widest mb-1">Status: Success Sync</p>
                        <p class="text-[10px] font-bold text-zinc-100 uppercase tracking-wider">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-zinc-500 hover:text-white transition-colors">
                        <i data-lucide="x" class="size-4"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-x-full opacity-0"
                 x-transition:enter-end="translate-x-0 opacity-100"
                 class="fixed top-8 right-8 z-[200] bg-white border border-red-200 shadow-[8px_8px_0px_0px_rgba(220,38,38,0.05)] p-6 min-w-[320px] pointer-events-auto"
                 x-cloak>
                <div class="flex items-start gap-x-4">
                    <div class="h-10 w-1 bg-red-600 flex-shrink-0"></div>
                    <div class="flex-1">
                        <p class="text-[8px] font-mono text-red-600 uppercase tracking-widest mb-1">Status: Error Conflict</p>
                        <ul class="text-[10px] font-bold text-zinc-900 uppercase tracking-wider space-y-1">
                            @if(session('error'))
                                <li>{{ session('error') }}</li>
                            @endif
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="text-zinc-400 hover:text-zinc-900 transition-colors">
                        <i data-lucide="x" class="size-4"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Dynamic Content -->
        @yield('content')

    </main>

    <!-- Lucide Icons Re-init (Alternative if JS doesn't catch it) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
