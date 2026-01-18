<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    //dona el formulari per registrarse
    public function edit(Request $request): View //mostra el formulari del perfil de l'usuari
    {
        return view('profile.edit', [
            'user' => $request->user(), //passa l'usuari autenticat a la vista
        ]);
    }

    //Actualitzem els usuaris
    public function update(ProfileUpdateRequest $request): RedirectResponse //actualitza les dades del perfil amb validació
    {
        $request->user()->fill($request->validated()); //omple el model User amb les dades validades

        if ($request->user()->isDirty('email')) { //si l'email ha canviat, desverifica l'email
            $request->user()->email_verified_at = null;
        }

        $request->user()->save(); //desa els canvis a la base de dades

        return Redirect::route('profile.edit')->with('status', 'profile-updated'); //torna al perfil amb missatge
    }

    //Funcio per borrar l'usuari
    public function destroy(Request $request): RedirectResponse //elimina el compte (demana contrasenya per seguretat)
    {
        $request->validateWithBag('userDeletion', [ //valida la contrasenya actual abans d'eliminar
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user(); //guardem l'usuari autenticat

        Auth::logout(); //tanca la sessió (logout)

        $user->delete(); 

        $request->session()->invalidate(); //invalida la sessió per seguretat
        $request->session()->regenerateToken(); //genera un nou token CSRF

        return Redirect::to('/'); //redirigeix a la home
    }
}
