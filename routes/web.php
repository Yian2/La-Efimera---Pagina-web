<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Producto;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/', function () {//Vista del home
    return view('home'); // resources/views/home.blade.php
})->name('home');




Route::get('/', function () {
    // Productes actius agrupats per tipus
    $productos = Producto::where('activo', true)
        ->orderBy('tipo')
        ->orderBy('nombre')
        ->get()
        ->groupBy('tipo');

    // Etiquetes boniques per a cada categoria
    $labels = [
        'pizza_vermella' => ['Les Vermelles', '(base de tomàquet + mozzarella)'],
        'pizza_blanca'   => ['Les Blanques', '(base de mozzarella)'],
        'pizza_gourmet'  => ['Les Gourmets', ''],
        'focaccia'       => ['Focaccies', ''],
        'lasanya'        => ['Lasanya', ''],
        'calzone'        => ['Calzones', ''],
        'suplement'      => ['Suplements', ''],
        'amanida'        => ['Amanides', ''],
        'pica_pica'      => ['Pica pica', ''],
        'postre'         => ['Postres', ''],
        'cafe'           => ['Cafès', ''],
        'infusio'        => ['Infusions', ''],
        'beguda'         => ['Begudes', ''],
        'vi'             => ['Vins', ''],
    ];

    return view('home', compact('productos','labels'));
})->name('home');


require __DIR__.'/auth.php';
