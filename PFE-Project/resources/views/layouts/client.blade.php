<!-- resources/views/layouts/client.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Coach') }} | @yield('title', 'Pupil Portal')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap">

    <!-- Vite Assets (CSS + Alpine via app.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Client Portal Design System (inline for guaranteed priority) -->
    <style>
        /* ─── RESET ─── */
        .v3-client, .v3-client * {
            border-radius: var(--radius-sm);
            box-sizing: border-box;
        }

        /* ─── ROOT TOKENS ─── */
        .v3-client {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background-color: #FAFAFA;
            color: #09090B;
        }

        /* ─── TYPOGRAPHY ─── */
        .v3-client .font-mono,
        .v3-client [class*="font-mono"] {
            font-family: 'JetBrains Mono', ui-monospace, monospace !important;
        }

        /* ─── SURFACE CARDS ─── */
        .v3-client .ag-card {
            background-color: #FFFFFF;
            border: 1px solid #E4E4E7;
            border-radius: var(--radius-xl);
            transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }
        .v3-client .ag-card:hover {
            border-color: #0891B2;
            transform: translateY(-2px);
            box-shadow: 4px 4px 0 0 rgba(0, 0, 0, 0.06);
        }
        .v3-client .ag-border {
            border: 1px solid #E4E4E7;
        }

        /* ─── SIDEBAR ─── */
        #client-sidebar {
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @media (max-width: 1023px) {
            #client-sidebar.-translate-x-full {
                transform: translateX(-100%);
            }
        }

        /* ─── SCROLLBAR ─── */
        .v3-client ::-webkit-scrollbar { width: 7px; height: 7px; }
        .v3-client ::-webkit-scrollbar-track { background: #FFFFFF; }
        .v3-client ::-webkit-scrollbar-thumb { 
            background: #0891b2; 
            border: 2px solid #FFFFFF;
        }
        .v3-client ::-webkit-scrollbar-thumb:hover { background: #0e7490; }

        /* ─── FORM INPUTS ─── */
        .v3-client input[type="text"],
        .v3-client input[type="number"],
        .v3-client input[type="date"],
        .v3-client textarea,
        .v3-client select {
            border-radius: 0 !important;
            outline: none;
            font-family: 'JetBrains Mono', monospace;
        }
        .v3-client input:focus, .v3-client textarea:focus, .v3-client select:focus {
            ring: none;
            outline: none;
            box-shadow: none;
        }

        /* ─── PROGRESS BARS ─── */
        .v3-client .progress-bar {
            height: 3px;
            background: #F4F4F5;
            overflow: hidden;
        }
        .v3-client .progress-bar-fill {
            height: 100%;
            background: #0891B2;
            transition: width 0.5s ease;
        }

        /* ─── MOBILE HEADER ─── */
        .v3-client .mobile-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: #FFFFFF;
            border-bottom: 1px solid #E4E4E7;
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        @media (min-width: 1024px) {
            .v3-client .mobile-header { display: none; }
        }

        /* ─── CLOAK ─── */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="v3-client antialiased" x-data="{ sidebarOpen: false }">

    <!-- Mobile Top Bar -->
    <div class="mobile-header lg:hidden">
        <div class="flex items-center gap-x-2">
            <div class="h-4 w-4 bg-cyan-600"></div>
            <span style="font-family:'JetBrains Mono',monospace" class="text-xs font-bold tracking-widest uppercase text-zinc-900">Coach Portal</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" 
                class="h-9 w-9 flex items-center justify-center ag-border text-zinc-600 hover:text-zinc-900 hover:bg-zinc-50 transition-colors">
            <i data-lucide="menu" class="size-4"></i>
        </button>
    </div>

    <!-- Sidebar -->
    <x-client.sidebar />

    <!-- Backdrop -->
    <div x-show="sidebarOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="lg:hidden fixed inset-0 bg-zinc-950/10 backdrop-blur-sm z-40">
    </div>

    <!-- Main Content -->
    <main class="lg:ml-64 min-h-screen bg-zinc-50">
        <div class="p-5 sm:p-8 lg:p-12 pt-20 lg:pt-12">
            @yield('content')
        </div>
    </main>

</body>
</html>
