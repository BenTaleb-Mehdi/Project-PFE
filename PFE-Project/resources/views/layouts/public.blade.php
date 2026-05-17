<!DOCTYPE html>
<html lang="en" x-data="app" :class="lightMode ? 'light' : 'dark'" id="html-root">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Achraf Coach — Build Your Champion Body</title>
  
  <!-- Inline theme check to prevent Flash of Unstyled Content (FOUC) -->
  <script>
    if (localStorage.getItem('ironcoach-theme') === 'light') {
      document.documentElement.classList.add('light');
      document.documentElement.classList.remove('dark');
    } else {
      document.documentElement.classList.add('dark');
      document.documentElement.classList.remove('light');
    }
  </script>
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700;900&family=Barlow+Condensed:wght@400;600;700;900&display=swap" rel="stylesheet">

  <!-- Vite: compiles Tailwind + style.css + Alpine + app.js -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Lenis smooth scroll (CDN only — no npm package needed) -->
  <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
</head>

<body class="antialiased">

  <main>
    @yield('content')
  </main>

</body>
</html>