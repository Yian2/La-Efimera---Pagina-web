<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\RedirectResponse;

class LocalizationController extends Controller
{
    public function index(string $idioma): RedirectResponse
    {
        // Guarda l'idioma a la sessió i aplica'l a la petició actual
        App::setLocale($idioma);
        session()->put('idioma', $idioma);

        return redirect()->back();
    }
}
