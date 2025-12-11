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
        <nav class="navbar">
            <div class="nav-inner">
                {{-- Marca La Efímera estil boho --}}
                <a href="{{ route('home') }}" class="brand" aria-label="@lang('Inici')">
                    <span class="brand-script">La Efímera</span>
                    <span class="brand-sub">@lang('pizzeria creativa')</span>
                </a>

                {{-- Menú principal (links + idioma + usuari) --}}
                <nav class="nav">
                    {{-- Enllaços públics --}}
                    <a href="{{ route('home') }}">@lang('Inici')</a>
                    <a href="{{ route('home') }}#carta">@lang('Carta')</a>
                    <a href="{{ route('home') }}#takeaway">@lang('Take Away')</a>
                    <a href="{{ route('home') }}#contacte">@lang('Contacte')</a>
                    <a href="{{ route('acces') }}" target="_blank" rel="noopener">@lang('Accés')</a>

                    {{-- Desplegable d'idioma --}}
                    <div class="lang-dropdown">
                        <button class="lang-btn" aria-haspopup="true" aria-expanded="false">
                            {{ strtoupper(app()->getLocale()) }}
                            <svg width="12" height="12" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M5 7l5 6 5-6H5z" fill="currentColor"/>
                            </svg>
                        </button>
                        <div class="lang-menu">
                            <a href="{{ route('lang.switch','ca') }}">Català</a>
                            <a href="{{ route('lang.switch','es') }}">Español</a>
                            <a href="{{ route('lang.switch','en') }}">English</a>
                            <a href="{{ route('lang.switch','fr') }}">Français</a>
                        </div>
                    </div>

                    {{-- Zona usuari/admin (surt a la dreta com la resta) --}}
                    @auth
                        <a href="{{ route('client.dashboard') }}" class="nav-link-user">
                            @lang('El meu espai')
                        </a>

                        @can('admin')
                            <a href="{{ route('admin.orders.index') }}" class="nav-link-user">
                                @lang('Totes les comandes')
                            </a>
                            <a href="{{ route('admin.stats.index') }}" class="nav-link-user">
                                @lang('Gràfics de vendes')
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="nav-link-user">
                                @lang('Gestió d’usuaris')
                            </a>
                        @endcan

                        <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                            @csrf
                            <button type="submit">
                                @lang('Sortir')
                            </button>
                        </form>
                    @endauth
                </nav>
            </div>
        </nav>
        {{-- FI NAVBAR GLOBAL --}}



        {{-- CONTINGUT --}}
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>
