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
    //Formulari de la comanda
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

    //Rep les dades per POST, les valida, calcula totals, GUARDA a la sessió, i REDIRIGEIX a la ruta GET 'takeaway.review'.
     
    public function processReview(Request $request)
    {
        //Validació
        $validated = $request->validate([
            'pickup_time' => ['required', 'string'],
            'lines'       => ['required', 'array'],
        ]);

        $pickupTime = $validated['pickup_time'];
        $lines      = $validated['lines'];

        // Càlcul de Detalls i Totals
        $detalls    = [];
        $subtotal   = 0;
        
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

            // Afegim el 'producto_id' per usar-lo directament a la funció 'store'
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

        // Càlcul de Descompte
        $user = Auth::user();
        $isWorker = $user && $user->rol === 'worker';

        $discountPercent = $isWorker ? 25 : 0;
        $discountAmount  = $isWorker ? $subtotal * 0.25 : 0;
        $total           = $subtotal - $discountAmount;
        
        // Guardar les dades calculades a la sessió (PRG)
        session()->put('takeaway_review_data', [
            'pickupTime'      => $pickupTime,
            'detalls'         => $detalls,
            'subtotal'        => $subtotal,
            'discountPercent' => $discountPercent,
            'discountAmount'  => $discountAmount,
            'total'           => $total,
        ]);
        
        // Redirigir a la vista de revisió (GET)
        return redirect()->route('takeaway.review.post');
    }


    //Mostra la pàgina de revisió carregant les dades de la sessió. (GET)
    
    public function showReview()
    {
        // Carregar dades de la sessió
        $data = session()->get('takeaway_review_data');
        
        // si no hi ha dades, redirigeix a l'inici de la comanda
        if (!$data) {
            return redirect()->route('takeaway.create')->withErrors([
                'general' => __('Sessió de comanda caducada. Torna a seleccionar els productes.'),
            ]);
        }

        // Mostrar la vista
        return view('takeaway.review', $data);
    }
    

    //confirma la comanda la guarda a la bd
    public function store(Request $request)
    {
        // Carreguem les dades calculades prèviament de la sessió i les eliminem
        $reviewData = session()->pull('takeaway_review_data'); 

        if (!$reviewData) {
            return redirect()->route('takeaway.create')->withErrors([
                'general' => __('Sessió de comanda caducada. Torna a seleccionar els productes.'),
            ]);
        }
        
        // Assignem les dades de la sessió
        $pickupTime = $reviewData['pickupTime'];
        $lineasValidas = $reviewData['detalls']; 
        $total = $reviewData['total'];
        
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Crear Pedido
            $pedido = new Pedido();
            $pedido->user_id     = $user->id;
            $pedido->total       = $total; // total amb descompte
            //$pedido->pickup_time = $pickupTime;
            $pedido->estado      = 'pendent';
            $pedido->save();

            foreach ($lineasValidas as $linea) {
                $detalle = new DetallePedido();
                $detalle->pedido_id      = $pedido->id;
                $detalle->producto_id    = $linea['producto_id'];
                $detalle->cantidad       = $linea['cantidad'];
                $detalle->precio_unitario = $linea['subtotal'] / $linea['cantidad']; // ← AÑADIDO
                $detalle->subtotal       = $linea['subtotal'];
                $detalle->nota           = $linea['nota'];
                $detalle->save();
            }


            DB::commit();

            return redirect()->route('takeaway.success', ['pedido' => $pedido->id]);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return redirect()->route('takeaway.create')->withErrors([
                'general' => __('Hi ha hagut un error en crear la comanda. Torna-ho a provar.'),
            ]);
        }
    }


    //pantalla creada feta
    public function success(Pedido $pedido)
    {
        return view('takeaway.success', compact('pedido'));
    }
}