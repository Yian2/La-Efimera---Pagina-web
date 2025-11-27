<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TakeawayController extends Controller
{
    public function create()
    {
        $productos = Producto::where('activo', true)
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->get()
            ->groupBy('tipo');

        $timeSlots = [
            '18:30','18:45','19:00','19:15','19:30','19:45',
            '20:00','20:15','20:30','20:45','21:00','21:15','21:30','21:45','22:00',
        ];

        return view('takeaway.create', compact('productos','timeSlots'));
    }

    public function store(Request $request)
    {
        // Validació bàsica
        $validated = $request->validate([
            'pickup_time' => ['required','string'],
            'lines'       => ['required','array'],
            'lines.*.producto_id' => ['nullable','integer','exists:productos,id'],
            'lines.*.cantidad'    => ['nullable','integer','min:1','max:20'],
            // 'lines.*.nota' -> només per al resum al front; NO es guarda
        ]);

        $userId = auth()->id();

        // Línies vàlides (producte + quantitat)
        $lines = collect($validated['lines'])
            ->filter(fn($l) => !empty($l['producto_id']) && !empty($l['cantidad']))
            ->values();

        if ($lines->isEmpty()) {
            return back()->withErrors(['lines' => __('Afegeix com a mínim un producte.')])->withInput();
        }

        $pedido = DB::transaction(function () use ($userId, $validated, $lines) {
            $pedido = Pedido::create([
                'user_id'        => $userId,
                'estado'         => 'pendiente',
                'es_para_llevar' => true,     // ← Take Away = true
                'total'          => 0,
                'fecha_creacion' => now(),
            ]);

            foreach ($lines as $line) {
                $producto = Producto::find($line['producto_id']);
                $cantidad = (int) $line['cantidad'];
                $precio   = (float) $producto->precio;

                DetallePedido::create([
                    'pedido_id'          => $pedido->id,
                    'producto_id'        => $producto->id,
                    'cantidad'           => $cantidad,
                    'precio_unitario'    => $precio,
                    'subtotal'           => $cantidad * $precio,
                    'fecha_creacion'     => now(),
                    'fecha_actualizacion'=> now(),
                ]);
            }

            $total = $pedido->detalles()->sum('subtotal');
            $pedido->update(['total' => $total]);

            return $pedido;
        });

        return redirect()->route('takeaway.success', $pedido);
    }

    public function success(Pedido $pedido)
    {
        $pedido->load('detalles.producto');
        return view('takeaway.success', compact('pedido'));
    }
}
