<!DOCTYPE html>
<html lang="en" class="bg-white border-x border-slate-200 shadow-2xl h-[100dvh] mx-auto w-full max-w-[430px] overflow-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mobile App')</title>

    {{-- Vite Assets (Localized Dependencies) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-ag-bg flex flex-col h-full antialiased text-ag-black overflow-x-hidden relative" @yield('body_attributes')>

    @if(!Route::is('login'))
        @include('components.header')
    @endif

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto pt-20 pb-28 px-5 bg-ag-bg">
        @yield('content')
    </main>

    <x-alert />

    @if(!Route::is('login'))
        @include('components.menu', ['clientId' => $clientId ?? (request()->route('id') ?? 1)])
    @endif

    @stack('scripts')

    {{-- Initialize Icons (Bundled in app.js) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof createIcons === 'function') {
                createIcons();
            }
        });
    </script>
</body>
</html>
