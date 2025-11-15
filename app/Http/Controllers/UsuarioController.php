<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Si tens middleware d'admin, el podries activar així:
    // public function __construct(){ $this->middleware('can:admin'); }

    public function index()
    {
        $usuarios = Usuario::orderBy('id','desc')->paginate(15);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'     => ['required','string','max:255'],
            'correo'     => ['required','email','max:255','unique:usuarios,correo'],
            'contrasena' => ['required','string','min:6'],
            'rol'        => ['required', Rule::in(['admin','cliente'])],
        ]);

        $data['contrasena'] = Hash::make($data['contrasena']);

        $usuario = Usuario::create($data);

        return redirect()
            ->route('usuarios.show', $usuario)
            ->with('success','Usuari creat correctament.');
    }

    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'nombre'     => ['required','string','max:255'],
            'correo'     => ['required','email','max:255', Rule::unique('usuarios','correo')->ignore($usuario->id)],
            'contrasena' => ['nullable','string','min:6'],
            'rol'        => ['required', Rule::in(['admin','cliente'])],
        ]);

        if (!empty($data['contrasena'])) {
            $data['contrasena'] = Hash::make($data['contrasena']);
        } else {
            unset($data['contrasena']);
        }

        $usuario->update($data);

        return redirect()
            ->route('usuarios.show', $usuario)
            ->with('success','Usuari actualitzat.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()
            ->route('usuarios.index')
            ->with('success','Usuari eliminat.');
    }
}
