<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientComptController;
use Illuminate\Support\Facades\Route;
use App\Models\Producto;
use App\Http\Controllers\LocalizationController;


/*
|--------------------------------------------------------------------------
| Públiques
|--------------------------------------------------------------------------
*/

// HOME (única definició)
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

// Botó “Accés” (obre login o porta al panell si ja ha fet login)
Route::get('/acces', function () {
    return auth()->check()
        ? redirect()->route('client.dashboard')
        : redirect()->route('login');
})->name('acces');


/*
|--------------------------------------------------------------------------
| Rutes que vénen amb Breeze
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('client.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Àrea client (logat)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('client')->name('client.')->group(function () {
    Route::get('/', [ClientComptController::class, 'index'])->name('dashboard');     // Panell
    Route::get('/orders', [ClientComptController::class, 'orders'])->name('orders'); // Historial
    Route::get('/track', [ClientComptController::class, 'track'])->name('track');    // Estat comanda
    Route::get('/loyalty', [ClientComptController::class, 'loyalty'])->name('loyalty'); // Punts
});




//rutes canvi idiomes

/*
Route::get('/lang/{idioma}', [LocalizationController::class, 'index'])
    ->whereIn('idioma', ['ca','es','en','fr'])
    ->name('lang.switch');*/



Route::get('/lang/{locale}', function (string $locale) {
$available = ['ca','es'];
if (in_array($locale, $available, true)) {
session(['idioma' => $locale]);
}
return back();
})->name('lang.switch');


require __DIR__.'/auth.php';
