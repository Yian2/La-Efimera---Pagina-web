<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class Idioma
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1) prova query/form ?lang=en  (ex: al POST /login)
        $fromRequest = $request->input('lang');

        // 2) si no, prova sessió
        $fromSession = session('idioma');

        // 3) si no, prova cookie
        $fromCookie = $request->cookie('idioma');

        $locale = $fromRequest ?? $fromSession ?? $fromCookie ?? config('app.locale', 'ca');

        App::setLocale($locale);

        // assegura que sessió i cookie queden sincronitzades
        session(['idioma' => $locale]);
        Cookie::queue(cookie('idioma', $locale, 60 * 24 * 365)); // 1 any

        return $next($request);
    }
}
