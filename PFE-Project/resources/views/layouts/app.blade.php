<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Top‑rated bodybuilding and training services in Tangier. Tailored plans, expert guidance, and results‑driven coaching.">
    <meta name="keywords" content="gym training Tangier, bodybuilding coach, custom workout plans, health and wellness">
    <meta property="og:title" content="{{ config('app.name', 'Laravel') }}">
    <meta property="og:description" content="Top‑rated bodybuilding and training services in Tangier. Tailored plans, expert guidance, and results‑driven coaching.">
    <meta property="og:type" content="website">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-head.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 dark:from-gray-800 dark:via-gray-900 dark:to-black text-white py-20">
  <div class="container mx-auto px-6 md:px-12 text-center">
    <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight mb-4 animate-fade-in-up">Elevate Your Fitness Journey</h1>
    <p class="text-xl md:text-2xl mb-8 animate-fade-in-up delay-200">Personalized coaching, cutting‑edge training plans, and results you can see.</p>
    <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-600 font-medium rounded-full px-8 py-3 shadow-lg hover:bg-gray-100 transition transform hover:-translate-y-1 animate-fade-in-up delay-400">Join Now</a>
  </div>
</section>

<main class="py-4">
    @yield('content')
        </main>
    </div>
</body>
</html>
