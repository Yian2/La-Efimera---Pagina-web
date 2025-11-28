{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Títol fix per a les pàgines de convidat (login / registre) --}}
    <title>La Efímera · Pizzeria creativa</title>

    {{-- Vite (si el fas servir) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Fonts + CSS global de la web --}}
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Quicksand:wght@400;600&family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Favicon amb el logo de La Efímera --}}
    {{-- Posa el teu fitxer a public/img/laefimera-favicon.png (o canvia el nom aquí) --}}
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
</head>
<body class="font-sans antialiased">
    {{-- Fons general estil La Efímera; el contingut concret el pinta cada vista (login/register) --}}
    <div class="min-h-screen" style="background: radial-gradient(circle at top, #1b1f2a 0, #05060b 45%, #05060b 100%); color:#f8f4ec;">
        {{ $slot }}
    </div>
</body>
</html>
