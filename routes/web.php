<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientComptController;
use Illuminate\Support\Facades\Route;
use App\Models\Producto;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\TakeawayController;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Públiques
|--------------------------------------------------------------------------
*/

// HOME 
Route::get('/', [HomeController::class, 'index'])->name('home');


// Botó “Accés” (obre login o porta al panell si ja ha fet login)
Route::get('/acces', function () {
    return auth()->check()
        ? redirect()->route('client.dashboard')
        : redirect()->route('login');
})->name('acces');



Route::get('/dashboard', function () {
    return redirect()->route('client.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Àrea client (logat)

Route::middleware('auth')->prefix('client')->name('client.')->group(function () {
    Route::get('/', [ClientComptController::class, 'index'])->name('dashboard');     // Panell
    Route::get('/orders', [ClientComptController::class, 'orders'])->name('orders'); // Historial
    Route::get('/track', [ClientComptController::class, 'track'])->name('track');    // Estat comanda
});




//rutes canvi idiomes

Route::get('/lang/{idioma}', [LocalizationController::class, 'index'])
    ->whereIn('idioma', ['ca','es','en','fr'])
    ->name('lang.switch');


//ruta take away

Route::middleware(['auth'])->group(function () {
    // Formulari
    Route::get('/takeaway', [TakeawayController::class, 'create'])->name('takeaway.create');

    // Pas 1: formulari → RESUM (NO guarda a BBDD)
    Route::post('/takeaway/review', [TakeawayController::class, 'review'])->name('takeaway.review');

    // Pas 2: RESUM → CONFIRMAR I GUARDAR
    Route::post('/takeaway/confirm', [TakeawayController::class, 'store'])->name('takeaway.store');

    // Pas 3: Pantalla de gràcies / comanda confirmada
    Route::get('/takeaway/success/{pedido}', [TakeawayController::class, 'success'])->name('takeaway.success');
});

require __DIR__.'/auth.php';
