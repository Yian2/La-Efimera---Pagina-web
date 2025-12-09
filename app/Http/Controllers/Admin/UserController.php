<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'rol'       => ['required', 'in:admin,worker,client'],
            'descompte' => ['nullable', 'numeric', 'min:0', 'max:1'],
        ]);

        $user->rol = $validated['rol'];
        $user->descompte = $validated['descompte'] ?? 0;
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', __('Usuari actualitzat correctament.'));
    }
}
