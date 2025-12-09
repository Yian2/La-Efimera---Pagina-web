<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $query = User::query();

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('email', 'like', '%' . $q . '%')
                    ->orWhere('nombre', 'like', '%' . $q . '%');
                    // si algun dia tens camp "name", aquí es podria afegir
            });
        }

        $users = $query
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString(); // manté el ?q a la paginació

        return view('admin.users', compact('users', 'q'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'rol' => ['required', 'in:admin,worker,client'],
        ]);

        $user->rol = $validated['rol'];
        $user->save();

        if ($request->wantsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('status', __('Usuari actualitzat correctament.'));
    }
}
