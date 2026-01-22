<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;

class LocalizationController extends Controller
{
    public function index(string $idioma): RedirectResponse
    {
        App::setLocale($idioma);
        session()->put('idioma', $idioma);

        // Guarda cookie per sobreviure a canvis de sessió
        Cookie::queue(cookie('idioma', $idioma, 60 * 24 * 365)); // 1 any

        return redirect()->back();
    }
}
