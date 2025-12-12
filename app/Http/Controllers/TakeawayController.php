<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TakeawayController extends Controller
{
    /**
     * Formulari per crear la comanda
     */
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

    /**
     * Pas intermedi: revisar la comanda abans de confirmar.
     */
    public function review(Request $request)
    {
        $validated = $request->validate([
            'pickup_time' => ['required', 'string'],
            'lines'       => ['required', 'array'],
        ]);

        $pickupTime = $validated['pickup_time'];
        $lines      = $validated['lines'];

        $detalls   = [];
        $subtotal  = 0;

        foreach ($lines as $line) {
            if (empty($line['producto_id']) || empty($line['cantidad'])) {
                continue;
            }

            $producto = Producto::find($line['producto_id']);
            if (!$producto) {
                continue;
            }

            $cantidad = (int) $line['cantidad'];
            $lineSubtotal = $producto->precio * $cantidad;

            $detalls[] = [
                'producto_id' => $producto->id,
                'nombre'      => $producto->nombre,
                'cantidad'    => $cantidad,
                'nota'        => $line['nota'] ?? '',
                'subtotal'    => $lineSubtotal,
            ];

            $subtotal += $lineSubtotal;
        }

        if (empty($detalls)) {
            return back()->withErrors([
                'lines' => __('No s’ha pogut generar la comanda. Revisa els productes.'),
            ]);
        }

        //  Descompte treballador
        $user = Auth::user();
        $isWorker = $user && $user->rol === 'worker';

        $discountPercent = $isWorker ? 25 : 0;
        $discountAmount  = $isWorker ? $subtotal * 0.25 : 0;
        $total           = $subtotal - $discountAmount;

        return view('takeaway.review', [
            'pickupTime'      => $pickupTime,
            'detalls'         => $detalls,
            'subtotal'        => $subtotal,
            'discountPercent' => $discountPercent,
            'discountAmount'  => $discountAmount,
            'total'           => $total,
        ]);
    }

    /**
     * Confirmar la comanda: guardar a BD.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pickup_time' => ['required', 'string'],
            'lines'       => ['required', 'array'],
        ]);

        $pickupTime = $validated['pickup_time'];
        $lines      = $validated['lines'];

        $user = Auth::user();

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $lineasValidas = [];

            foreach ($lines as $line) {
                if (empty($line['producto_id']) || empty($line['cantidad'])) {
                    continue;
                }

                $producto = Producto::find($line['producto_id']);
                if (!$producto) {
                    continue;
                }

                $cantidad = (int) $line['cantidad'];
                $lineSubtotal = $producto->precio * $cantidad;

                $lineasValidas[] = [
                    'producto'  => $producto,
                    'cantidad'  => $cantidad,
                    'nota'      => $line['nota'] ?? '',
                    'subtotal'  => $lineSubtotal,
                ];

                $subtotal += $lineSubtotal;
            }

            if (empty($lineasValidas)) {
                return back()->withErrors([
                    'lines' => __('No s’ha pogut crear la comanda. Revisa els productes.'),
                ]);
            }

            // Descompte treballador
            $isWorker = $user && $user->rol === 'worker';
            $discountAmount = $isWorker ? $subtotal * 0.25 : 0;
            $total          = $subtotal - $discountAmount;

            // Crear Pedido
            $pedido = new Pedido();
            $pedido->user_id     = $user->id;
            $pedido->total       = $total;         // total amb descompte
            $pedido->pickup_time = $pickupTime;
            $pedido->estado      = 'pendent';      // o el que facis servir
            $pedido->save();

            // Crear DetallePedido
            foreach ($lineasValidas as $linea) {
                $detalle = new DetallePedido();
                $detalle->pedido_id   = $pedido->id;
                $detalle->producto_id = $linea['producto']->id;
                $detalle->cantidad    = $linea['cantidad'];
                $detalle->subtotal    = $linea['subtotal'];
                $detalle->nota        = $linea['nota'];
                $detalle->save();
            }

            DB::commit();

            // 👇 IMPORTANT: redirigim a la vista success amb l’ID
            return redirect()->route('takeaway.success', ['pedido' => $pedido->id]);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()->withErrors([
                'general' => __('Hi ha hagut un error en crear la comanda. Torna-ho a provar.'),
            ]);
        }
    }

    /**
     * Pantalla de comanda creada amb èxit
     */
    public function success(Pedido $pedido)
    {
        return view('takeaway.success', compact('pedido'));
    }
}
