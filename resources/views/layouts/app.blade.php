{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    {{-- Vite (si el fas servir) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 👇 Fonts + el teu CSS global (public/css/style.css) --}}
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Quicksand:wght@400;600&family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Si alguna vista fa @push('styles'), ho rebrà aquí --}}
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
