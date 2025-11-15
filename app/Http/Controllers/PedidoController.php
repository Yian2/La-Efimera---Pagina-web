<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Usuario;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('usuario')
            ->orderBy('id','desc')
            ->paginate(20);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $usuarios = Usuario::orderBy('nombre')->get();
        return view('pedidos.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuario_id'     => ['required','exists:usuarios,id'],
            'estado'         => ['required','string','max:50', Rule::in(['pendiente','pagado','entregado','cancelado'])],
            'es_para_llevar' => ['required','boolean'],
        ]);

        // el total el recalcularem després de línies, però per crear el registre cal un valor
        $data['total'] = 0;
        $data['fecha_creacion'] = now();

        $pedido = Pedido::create($data);

        return redirect()
            ->route('pedidos.show', $pedido)
            ->with('success','Comanda creada. Ara afegeix detalls.');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['usuario','detalles.producto']);
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $usuarios = Usuario::orderBy('nombre')->get();
        return view('pedidos.edit', compact('pedido','usuarios'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $data = $request->validate([
            'usuario_id'     => ['required','exists:usuarios,id'],
            'estado'         => ['required','string','max:50', Rule::in(['pendiente','pagado','entregado','cancelado'])],
            'es_para_llevar' => ['required','boolean'],
        ]);

        $pedido->update($data);

        return redirect()
            ->route('pedidos.show', $pedido)
            ->with('success','Comanda actualitzada.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()
            ->route('pedidos.index')
            ->with('success','Comanda eliminada.');
    }
}
