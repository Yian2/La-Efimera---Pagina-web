<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index()
    {
        $search = request('q'); //agafa el text de cerca de la url (?q=...)

        $productos = Producto::when($search, function($q) use ($search) { //si hi ha cerca, filtra per nom o tipus
                $q->where('nombre','like',"%{$search}%")
                  ->orWhere('tipo','like',"%{$search}%");
            })
            ->orderBy('id','desc') //ordena de més nou a més antic
            ->paginate(20) //et mostren de 20 productes i la seguent pagina 20 productes mes
            ->withQueryString(); //manté el ?q=... quan canvies de pàgina

        return view('productos.index', compact('productos','search'));
    }

    public function create() //mostra el formulari per crear un producte
    {
        return view('productos.create');
    }

    public function store(Request $request) //crea el producte a la base de dades amb validació
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:255'],
            'descripcion' => ['nullable','string'],
            'precio'      => ['required','numeric','min:0'],
            'tipo'        => ['required','string','max:100', Rule::in([ //només permet aquests tipus
                'pizza_vermella','pizza_blanca','pizza_gourmet',
                'focaccia','lasanya','calzone','suplement',
                'amanida','pica_pica','postre','cafe','infusio',
                'beguda','vi','pizza'
            ])],
            'activo'      => ['required','boolean'],
        ]);

        $producto = Producto::create($data); //guarda el producte

        return redirect()
            ->route('productos.show', $producto) //redirigeix al detall del producte
            ->with('success','Producte creat.');
    }

    public function show(Producto $producto) //mostra el producte en detall
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto) //mostra el formulari per editar el producte
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto) //actualitza el producte amb validació
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

        $producto->update($data); //desa els canvis

        return redirect()
            ->route('productos.show', $producto) //torna al detall amb missatge
            ->with('success','Producte actualitzat.');
    }

    public function destroy(Producto $producto) //elimina el producte de la bd i torna al llistat
    {
        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('success','Producte eliminat.');
    }
}
