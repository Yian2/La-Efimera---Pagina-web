<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class Idioma
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('idioma', config('app.locale', 'ca'));
        App::setLocale($locale);

        return $next($request);
    }
}
