{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Títol (pot venir de <x-app-layout :title="...">, si no, per defecte) --}}
    <title>{{ $title ?? 'La Efímera · Pizzeria creativa' }}</title>

    {{-- Vite (si el fas servir a l’app) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Fonts + CSS global (public/css/style.css) --}}
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Quicksand:wght@400;600&family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Favicon / PWA bàsic --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=1">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}?v=1">

    {{-- Meta SEO i socials --}}
    <meta name="description" content="Pizzes artesanes amb fermentació lenta, postres casolans i take away.">
    <meta property="og:title" content="La Efímera · Pizzeria creativa">
    <meta property="og:description" content="Pizzes artesanes amb fermentació lenta, postres casolans i take away.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}?v=1">
    <meta property="og:image:alt" content="Logo La Efímera">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="La Efímera · Pizzeria creativa">
    <meta name="twitter:description" content="Pizzes artesanes amb fermentació lenta, postres casolans i take away.">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}?v=1">

    {{-- Qualsevol estil extra que “pushis” des de vistes --}}
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- Espai per a scripts específics de vistes --}}
    @stack('scripts')
</body>
</html>
