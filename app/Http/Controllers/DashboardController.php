<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
    //Agafem l'usuari autenticat per poder mostrar informació personalitzada al dashboard
        $user = auth()->user();
    // Retornem la vista principal del dashboard amb l'usuari
        return view('dashboard.index', compact('user'));
    }
}
