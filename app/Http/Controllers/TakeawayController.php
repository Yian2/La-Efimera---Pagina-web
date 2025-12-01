<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TakeawayController extends Controller
{
    // PAS 0: formulari de Take Away
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

        return view('takeaway.create', compact('productos', 'timeSlots'));
    }

    /**
     * PAS 1: Validar formulari i mostrar el RESUM (NO guarda a la BBDD).
     */
    public function review(Request $request)
    {
        $validated = $request->validate([
            'pickup_time' => ['required','string'],
            'lines'       => ['required','array'],
            'lines.*.producto_id' => ['nullable','integer','exists:productos,id'],
            'lines.*.cantidad'    => ['nullable','integer','min:1','max:20'],
            'lines.*.nota'        => ['nullable','string','max:255'],
        ]);

        // Línies vàlides
        $lines = collect($validated['lines'])
            ->filter(fn($l) => !empty($l['producto_id']) && !empty($l['cantidad']))
            ->values();

        if ($lines->isEmpty()) {
            return back()
                ->withErrors(['lines' => __('Afegeix com a mínim un producte.')])
                ->withInput();
        }

        // Muntem el “carret” per al resum
        $detalls = [];
        $total = 0;

        foreach ($lines as $line) {
            $producto = Producto::find($line['producto_id']);
            if (!$producto) {
                continue;
            }

            $cantidad  = (int) $line['cantidad'];
            $preuUnit  = (float) $producto->precio;
            $subtotal  = $cantidad * $preuUnit;
            $nota      = $line['nota'] ?? null;

            $total += $subtotal;

            $detalls[] = [
                'producto_id'   => $producto->id,
                'nombre'        => $producto->nombre,
                'cantidad'      => $cantidad,
                'precio_unit'   => $preuUnit,
                'subtotal'      => $subtotal,
                'nota'          => $nota,
            ];
        }

        return view('takeaway.review', [
            'pickupTime' => $validated['pickup_time'],
            'detalls'    => $detalls,
            'total'      => $total,
        ]);
    }

    /**
     * PAS 2: Confirmar i guardar a la base de dades.
     */
    public function store(Request $request)
    {
        // Tornem a validar (per seguretat)
        $validated = $request->validate([
            'pickup_time' => ['required','string'],
            'lines'       => ['required','array'],
            'lines.*.producto_id' => ['required','integer','exists:productos,id'],
            'lines.*.cantidad'    => ['required','integer','min:1','max:20'],
            'lines.*.nota'        => ['nullable','string','max:255'],
        ]);

        $userId = auth()->id();

        $lines = collect($validated['lines'])
            ->filter(fn($l) => !empty($l['producto_id']) && !empty($l['cantidad']))
            ->values();

        if ($lines->isEmpty()) {
            return redirect()->route('takeaway.create')
                ->withErrors(['lines' => __('Afegeix com a mínim un producte.')]);
        }

        $pedido = DB::transaction(function () use ($userId, $validated, $lines) {
            $pedido = Pedido::create([
                'user_id'        => $userId,
                'estado'         => 'pendiente',
                'es_para_llevar' => true,
                'total'          => 0,
                'fecha_creacion' => now(),
                // si tens un camp per a l’hora de recollida:
                // 'hora_recollida' => $validated['pickup_time'],
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
                    'nota'               => $line['nota'] ?? null,
                    'fecha_creacion'     => now(),
                    'fecha_actualizacion'=> now(),
                ]);
            }

            $total = $pedido->detalles()->sum('subtotal');
            $pedido->update(['total' => $total]);

            return $pedido;
        });

        // PAS 3: anar a la pantalla de "Gràcies / Comanda confirmada"
        return redirect()->route('takeaway.success', $pedido);
    }

    /**
     * PAS 3: Pantalla final de comanda confirmada.
     */
    public function success(Pedido $pedido)
    {
        $pedido->load('detalles.producto');

        return view('takeaway.success', compact('pedido'));
    }
}
