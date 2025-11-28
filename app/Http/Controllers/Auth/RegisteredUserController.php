<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre'  => ['required', 'string', 'max:255'],  // 👈 abans 'name'
            'email'   => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'=> ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nombre'  => $request->nombre,                   // 👈 abans 'name'
            'email'   => $request->email,
            'password'=> Hash::make($request->password),
            // 'rol' => 'cliente', // si vols posar rol per defecte més endavant
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
    }
}
