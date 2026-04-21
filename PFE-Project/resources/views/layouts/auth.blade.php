<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Coach') }} // @yield('title')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cyan: {
                            500: '#06b6d4',
                            600: '#0891b2',
                            900: '#164e63',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * { border-radius: var(--radius-sm); }
        [x-cloak] { display: none !important; }
        .selection\:bg-cyan-100::selection { background-color: #cffafe; }
        .selection\:text-cyan-900::selection { background-color: #164e63; }
    </style>
</head>
<body class="h-full bg-white text-zinc-900 font-sans selection:bg-cyan-100 selection:text-cyan-900">

    @yield('content')

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
