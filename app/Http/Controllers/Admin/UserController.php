<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Recollim el text de cerca (?q=...) i construïm una consulta base
        $q = $request->input('q');
        $query = User::query();

        // Si hi ha cerca, filtrem per email o per nom (LIKE)
        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('email', 'like', '%' . $q . '%')
                    ->orWhere('nombre', 'like', '%' . $q . '%');
            });
        }

        // Ordenem i paginem; withQueryString manté el paràmetre q entre pàgines
        $users = $query
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        // Retornem la vista d'admin amb la llista i el valor de cerca per mantenir-lo al formulari
        return view('admin.users', compact('users', 'q'));
    }

    public function update(Request $request, User $user)
    {
        // Validem que el rol sigui un dels valors permesos
        $validated = $request->validate([
            'rol' => ['required', 'in:admin,worker,client'],
        ]);

        // Actualitzem el rol i guardem
        $user->rol = $validated['rol'];
        $user->save();

        // Si la petició és AJAX/JSON, retornem resposta en JSON
        if ($request->wantsJson()) {
            return response()->json(['ok' => true]);
        }

        // Si és una petició normal, redirigim a l’índex amb missatge d’estat
        return redirect()
            ->route('admin.users.index')
            ->with('status', __('Usuari actualitzat correctament.'));
    }
}
