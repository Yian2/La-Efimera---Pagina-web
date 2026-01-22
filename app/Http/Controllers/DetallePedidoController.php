<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallePedidoController extends Controller
{
    public function store(Request $request, Pedido $pedido)
    {//aquest metode crea una nova linia de comanda

        // Validem les dades d'entrada per crear una línia de comanda
        $data = $request->validate([
            'producto_id'     => ['required','exists:productos,id'],
            'cantidad'        => ['required','integer','min:1'],
            'precio_unitario' => ['required','numeric','min:0'],
        ]);

        // Calculem el subtotal de la línia i assignem timestamps (si la taula no els gestiona automàticament)
        $data['subtotal'] = $data['cantidad'] * $data['precio_unitario'];
        $data['fecha_creacion'] = now();
        $data['fecha_actualizacion'] = now();

        // Operació atòmica: creem la línia i recalculam el total del pedido dins una transacció
        DB::transaction(function() use ($pedido, $data) {
            $pedido->detalles()->create($data);
            $this->recalcularTotal($pedido);
        });

        return back()->with('success','Línia afegida.');
    }

    public function update(Request $request, Pedido $pedido, DetallePedido $detalle)
    {//aquest metode actualitza la linia existent
        // Seguretat: assegurem que el detall pertany a aquest pedido (evita manipular línies d'altres comandes)
        abort_if($detalle->pedido_id !== $pedido->id, 404);

        // Validem els camps actualitzables
        $data = $request->validate([
            'producto_id'     => ['required','exists:productos,id'],
            'cantidad'        => ['required','integer','min:1'],
            'precio_unitario' => ['required','numeric','min:0'],
        ]);

        // Recalculem subtotal i actualitzem la data de modificació
        $data['subtotal'] = $data['cantidad'] * $data['precio_unitario'];
        $data['fecha_actualizacion'] = now();

        // Transacció: actualitzem la línia i recalculam el total del pedido
        DB::transaction(function() use ($pedido, $detalle, $data) {
            $detalle->update($data);
            $this->recalcularTotal($pedido);
        });

        return back()->with('success','Línia actualitzada.');
    }

    public function destroy(Pedido $pedido, DetallePedido $detalle)
    {//Elimina la linia 
        // Seguretat: comprovem que el detall és de la comanda indicada
        abort_if($detalle->pedido_id !== $pedido->id, 404);

        // Transacció: eliminem la línia i recalculam el total del pedido
        DB::transaction(function() use ($pedido, $detalle) {
            $detalle->delete();
            $this->recalcularTotal($pedido);
        });

        return back()->with('success','Línia eliminada.');
    }

    private function recalcularTotal(Pedido $pedido): void
    {
        // Recalcula el total de la comanda a partir de la suma dels subtotals de totes les línies
        // (això garanteix consistència després d'afegir/editar/eliminar detalls)
        $total = $pedido->detalles()->sum('subtotal');
        $pedido->update(['total' => $total]);
    }
}
