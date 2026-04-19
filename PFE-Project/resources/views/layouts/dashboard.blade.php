<!-- resources/views/layouts/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Coach') }} | @yield('title', 'Admin Engine V3.0')</title>
    
    <!-- Fonts & Tokens -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap">
    <style>
        :root {
            --font-mono: 'JetBrains Mono', monospace;
        }
        * {
            border-radius: 0 !important;
        }
        [x-cloak] { display: none !important; }
        .ag-card {
            background-color: #FFFFFF;
            border: 1px solid #E4E4E7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .ag-card:hover {
            border-color: #0891B2;
            transform: translateY(-2px);
            box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 0.05);
        }
        .font-mono { font-family: var(--font-mono) !important; }
    </style>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-50 antialiased v3-admin" 
      x-data="{ 
        isSidebarOpen: false, 
        isLargeScreen: window.innerWidth >= 1024 
      }"
      x-init="window.addEventListener('resize', () => isLargeScreen = window.innerWidth >= 1024)">

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
        
        <!-- Dashboard Header Context -->
        <header class="mb-8 font-sans">
            <h1 class="text-3xl font-bold tracking-tight uppercase text-zinc-900">@yield('header_title', 'Dashboard')</h1>
            <p class="text-[10px] text-zinc-400 mt-2 uppercase tracking-[0.2em] font-mono">@yield('header_subtitle', 'Operational_Intel // System_Sync_Active')</p>
        </header>

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
