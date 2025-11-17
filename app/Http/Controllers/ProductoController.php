<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index()
    {
        $search = request('q');
        $productos = Producto::when($search, function($q) use ($search) {
                $q->where('nombre','like',"%{$search}%")
                  ->orWhere('tipo','like',"%{$search}%");
            })
            ->orderBy('id','desc')
            ->paginate(20)
            ->withQueryString();

        return view('productos.index', compact('productos','search'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:255'],
            'descripcion' => ['nullable','string'],
            'precio'      => ['required','numeric','min:0'],
            'tipo'        => ['required','string','max:100', Rule::in([
                'pizza_vermella','pizza_blanca','pizza_gourmet',
                'focaccia','lasanya','calzone','suplement',
                'amanida','pica_pica','postre','cafe','infusio',
                'beguda','vi','pizza'
            ])],
            'activo'      => ['required','boolean'],
        ]);

        $producto = Producto::create($data);

        return redirect()
            ->route('productos.show', $producto)
            ->with('success','Producte creat.');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:255'],
            'descripcion' => ['nullable','string'],
            'precio'      => ['required','numeric','min:0'],
            'tipo'        => ['required','string','max:100', Rule::in([
                'pizza_vermella','pizza_blanca','pizza_gourmet',
                'focaccia','lasanya','calzone','suplement',
                'amanida','pica_pica','postre','cafe','infusio',
                'beguda','vi','pizza'
            ])],
            'activo'      => ['required','boolean'],
        ]);

        $producto->update($data);

        return redirect()
            ->route('productos.show', $producto)
            ->with('success','Producte actualitzat.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('success','Producte eliminat.');
    }
}
