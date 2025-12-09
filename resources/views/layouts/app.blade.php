{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'La Efímera · Pizzeria creativa' }}</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Fonts + CSS global --}}
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Quicksand:wght@400;600&family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=1">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}?v=1">

    {{-- SEO --}}
    <meta name="description" content="Pizzes artesanes amb fermentació lenta, postres casolans i take away.">
    <meta property="og:title" content="La Efímera · Pizzeria creativa">
    <meta property="og:description" content="Pizzes artesanes amb fermentació lenta, postres casolans i take away.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}?v=1">
    <meta property="og:image:alt" content="Logo La Efímera">

    @stack('styles')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">

        {{-- NAV PRINCIPAL --}}
        <nav class="main-nav">
            <div class="main-nav-inner">
                
                {{-- Marca --}}
                <a href="{{ route('home') }}" class="main-nav-brand">
                    La Efímera
                </a>

                {{-- Enllaços --}}
                <div class="main-nav-links">

                    {{-- Enllaços generals --}}
                    <a href="{{ route('home') }}">Inici</a>
                    <a href="#carta">Carta</a>
                    <a href="#takeaway">Take Away</a>
                    <a href="#contacte">Contacte</a>

                    {{-- SI ESTÀ LOGUEJAT --}}
                    @auth

                        {{-- Espai d’usuari --}}
                        <a href="{{ route('client.dashboard') }}">
                            El meu espai
                        </a>

                        {{-- ENLLAÇOS D’ADMIN --}}
                        @can('admin')
                            <a href="{{ route('admin.orders.index') }}">
                                Totes les comandes
                            </a>

                            <a href="{{ route('admin.stats.index') }}">
                                Gràfics de vendes
                            </a>

                            <a href="{{ route('admin.users.index') }}">
                                Gestió d’usuaris
                            </a>
                        @endcan

                        {{-- LOGOUT --}}
                        <form method="POST" action="{{ route('logout') }}" class="main-nav-logout">
                            @csrf
                            <button type="submit">
                                Sortir
                            </button>
                        </form>

                    @endauth

                    {{-- SI NO ESTÀ LOGUEJAT --}}
                    @guest
                        <a href="{{ route('login') }}">
                            Accedeix
                        </a>
                    @endguest

                </div>
            </div>
        </nav>
        {{-- FI NAV --}}

        {{-- CONTINGUT --}}
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>
