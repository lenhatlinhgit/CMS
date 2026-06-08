@props(['class' => 'bg-bg min-h-screen overflow-hidden overflow-y-auto'])

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @livewireStyles
    @vite(['resources/css/app.css'])
    {{ $head ?? '' }}
    <script>
        (function(){const s=document.documentElement,d=s.dataset.theme,l=localStorage.getItem('theme'),m=window.matchMedia('(prefers-color-scheme: dark)').matches;s.classList.toggle('dark',d?d==='dark':l?l==='dark':m)})();
    </script>
</head>

<body {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
    @livewireScripts
    @vite(['resources/js/app.js','resources/js/flexilla.js'])
</body>
</html>
