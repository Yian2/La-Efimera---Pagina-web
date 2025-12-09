<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientComptController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\TakeawayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// 🔴 Admin
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\StatsController as AdminStatsController;

/*
|--------------------------------------------------------------------------
| Rutes públiques
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

// Botó “Accés”: si està loguejat → espai client; si no → login
Route::get('/acces', function () {
    return auth()->check()
        ? redirect()->route('client.dashboard')
        : redirect()->route('login');
})->name('acces');

/*
|--------------------------------------------------------------------------
| Dashboard predeterminat de Laravel/Breeze
|→ redirigeix al panell del client
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('client.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Perfil usuari
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Àrea client (usuari logat)
| URL base: /client/...
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('client')->name('client.')->group(function () {
    // Panell “El meu espai”
    Route::get('/', [ClientComptController::class, 'index'])->name('dashboard');

    // Historial de comandes
    Route::get('/orders', [ClientComptController::class, 'orders'])->name('orders');

    // Seguiment estat de la comanda
    Route::get('/track', [ClientComptController::class, 'track'])->name('track');
});

/*
|--------------------------------------------------------------------------
| Canvi d’idioma
|--------------------------------------------------------------------------
*/
Route::get('/lang/{idioma}', [LocalizationController::class, 'index'])
    ->whereIn('idioma', ['ca', 'es', 'en', 'fr'])
    ->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Take Away (només logats)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/takeaway', [TakeawayController::class, 'create'])->name('takeaway.create');
    Route::post('/takeaway/review', [TakeawayController::class, 'review'])->name('takeaway.review');
    Route::post('/takeaway/confirm', [TakeawayController::class, 'store'])->name('takeaway.store');
    Route::get('/takeaway/success/{pedido}', [TakeawayController::class, 'success'])->name('takeaway.success');
});

/*
|--------------------------------------------------------------------------
| Recuperar contrasenya
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

/*
|--------------------------------------------------------------------------
| Zona ADMIN (només rol = admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Gestió d’usuaris
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');

        // Totes les comandes
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');

        // Estadístiques / vendes
        Route::get('/stats', [AdminStatsController::class, 'index'])->name('stats.index');
    });

require __DIR__.'/auth.php';
