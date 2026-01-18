<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('usuario')
            ->orderBy('id','desc') //ordena de mes nou a més antiga les comandes
            ->paginate(20);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()//Necesitem la llista d'usuaris per poder assignar la comanda a un usuari
    {
        $usuarios = User::orderBy('nombre')->get();
        return view('pedidos.create', compact('usuarios'));
    }

    public function store(Request $request)//Asigna valors per defecte: total = 0 i data de creacio : ara
    {
        $data = $request->validate([
            'user_id'        => ['required','exists:users,id'],
            'estado'         => ['required','string','max:50', Rule::in(['pendiente','preparando','listo','entregado','cancelado'])],
            'es_para_llevar' => ['required','boolean'],
        ]);

        $data['total'] = 0;
        $data['fecha_creacion'] = now();

        $pedido = Pedido::create($data);

        return redirect()
            ->route('pedidos.show', $pedido)
            ->with('success','Comanda creada. Ara afegeix detalls.');
    }

    public function show(Pedido $pedido)//mostra en detall la comanda
    {
        $pedido->load(['usuario','detalles.producto']);
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)//Necesites la llista d'usuaris per poder canviar  l'usuaria assignat
    {
        $usuarios = User::orderBy('nombre')->get();
        return view('pedidos.edit', compact('pedido','usuarios'));
    }

    public function update(Request $request, Pedido $pedido)//actualitza els camps de la comanda amb les dades valides
    {
        $data = $request->validate([
            'user_id'        => ['required','exists:users,id'],
            'estado'         => ['required','string','max:50', Rule::in(['pendiente','preparando','listo','entregado','cancelado'])],
            'es_para_llevar' => ['required','boolean'],
        ]);

        $pedido->update($data);

        return redirect()//Redirigeix al detall amb missatge de confirmació
            ->route('pedidos.show', $pedido)
            ->with('success','Comanda actualitzada.');
    }

    public function destroy(Pedido $pedido)//Elimina la comanda, t'ho borra de la bd idespres et mostra la llista
    {
        $pedido->delete();

        return redirect()
            ->route('pedidos.index')
            ->with('success','Comanda eliminada.');
    }
}
