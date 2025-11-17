<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallePedidoController extends Controller
{
    public function store(Request $request, Pedido $pedido)
    {
        $data = $request->validate([
            'producto_id'     => ['required','exists:productos,id'],
            'cantidad'        => ['required','integer','min:1'],
            'precio_unitario' => ['required','numeric','min:0'],
        ]);

        $data['subtotal'] = $data['cantidad'] * $data['precio_unitario'];
        $data['fecha_creacion'] = now();
        $data['fecha_actualizacion'] = now();

        DB::transaction(function() use ($pedido, $data) {
            $pedido->detalles()->create($data);
            $this->recalcularTotal($pedido);
        });

        return back()->with('success','Línia afegida.');
    }

    public function update(Request $request, Pedido $pedido, DetallePedido $detalle)
    {
        abort_if($detalle->pedido_id !== $pedido->id, 404);

        $data = $request->validate([
            'producto_id'     => ['required','exists:productos,id'],
            'cantidad'        => ['required','integer','min:1'],
            'precio_unitario' => ['required','numeric','min:0'],
        ]);

        $data['subtotal'] = $data['cantidad'] * $data['precio_unitario'];
        $data['fecha_actualizacion'] = now();

        DB::transaction(function() use ($pedido, $detalle, $data) {
            $detalle->update($data);
            $this->recalcularTotal($pedido);
        });

        return back()->with('success','Línia actualitzada.');
    }

    public function destroy(Pedido $pedido, DetallePedido $detalle)
    {
        abort_if($detalle->pedido_id !== $pedido->id, 404);

        DB::transaction(function() use ($pedido, $detalle) {
            $detalle->delete();
            $this->recalcularTotal($pedido);
        });

        return back()->with('success','Línia eliminada.');
    }

    private function recalcularTotal(Pedido $pedido): void
    {
        $total = $pedido->detalles()->sum('subtotal');
        $pedido->update(['total' => $total]);
    }
}
