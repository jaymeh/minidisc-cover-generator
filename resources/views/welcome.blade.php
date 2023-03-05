<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Minidisc Cover Generator</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles

        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="antialiased">
        <livewire:cover-form />

        @livewireScripts
    </body>
</html>
